<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 9:46
 */

namespace Extend;


use Home\Model\TaskModel;
use Home\Model\UserCardListModel;
use Home\Model\UserModel;

class Settlement
{
    public function batchSettlement($settlementId)
    {
        $model = M('settlement');
        $model->startTrans();
        //找出要结算的数据
        if ($splitUserIds = $this->getSettlementData($settlementId)) {
            foreach (explode(',', rtrim($splitUserIds, ',')) as $value) {
                //按照银行卡分账
                if (false === self::split($value)) {
                    echo '分账失败';
                    $model->rollback();
                };
            }
//            print_r($splitUserIds);exit();
            //写入工资表
            if (false === self::splitWages($settlementId)) {
                $model->rollback();
            }
            $splitCardModel = M('settlement_split_card');
            $list           = $splitCardModel->where(array('settlement_id' => $settlementId))->select();
            $totalMoney     = 0;
            foreach ($list as $value) {
                $totalMoney += $value['current_money'];
            }
            $data['settlement_uid'] = get_user_id();
            $data['person_count']   = count(explode(',', rtrim($splitUserIds, ',')));
            $data['money']          = $totalMoney;
            $data['split_status']   = 1;
            $model->where(array('id' => $settlementId))->save($data);
            $model->commit();

            return true;

        }
        $model->rollback();
        exit('出现未知错误，请联系管理员');
    }

    /**
     * 获取当前时间点的结账数据
     * @author Red
     * @date 2017年7月14日10:39:18
     * @param $settlementId
     * @return bool
     */
    private function getSettlementData($settlementId)
    {
        //从用户任务结算表中找出status=0的
        $model     = M('user_task_settlement');
        $taskModel = new  TaskModel();
//        $sql   = 'SELECT user_id,SUM(money) as totalMoney FROM `em_user_task_settlement` WHERE `status`=0 GROUP BY user_id ';
        $list = $model->where(array('status' => 0))->select();

        if (!$list) {
            exit('没有需要结算的数据');

            return;
        }
        $userSettleList = [];
        //按用户分组
        foreach ($list as $value) {
            $model->where(array('id' => $value['id']))->save(array('status' => 1));//状态置为1=>结算中
            $userSettleList[$value['user_id']][] = $value;
        }
        //按照用户项目处理
        $userSettleLists = [];
        foreach ($userSettleList as $key => $user) {
            $newSerialize = [];
            foreach ($user as $val) {
                $taskInfo  = $taskModel->getById($val['task_id'], 'title');
                $serialize = unserialize($val['serialize']);
                $userSettleLists[$key]['money'] += $val['money'];//总金额
                $serialize['task_id']   = $val['task_id'];
                $serialize['task_name'] = $taskInfo['title'];
                $userSettleLists[$key]['task_task_settlement_ids'] .= $val['id'] . ',';//用户任务结算ID
                $userSettleLists[$key]['total_reward'] += $serialize['reward'];
                $userSettleLists[$key]['total_debit'] += $serialize['debit'];
                $userSettleLists[$key]['total_commission'] += $serialize['commission'];
                $newSerialize[$val['task_id']] = $serialize;
            }

            $userSettleLists[$key]['user_id'] = $key;
            $userSettleLists[$key]['task']    = $newSerialize;
        }
        //写入分账用户表
        $userModel      = new UserModel();
        $splitUserModel = M('settlement_split_user');
        $splitUserIds   = '';
        $data           = [];
        foreach ($userSettleLists as $value) {
            $userInfo              = $userModel->getById($value['user_id'], 'true_name,tell,card_num');
            $data['settlement_id'] = $settlementId;
            $data['user_id']       = $value['user_id'];
            $data['username']      = $userInfo['true_name'];
            $data['tell']          = $userInfo['tell'];
            $data['card_num']      = $userInfo['card_num'];
            $data['money']         = $value['money'];
            $data['reward']        = $value['total_reward'];
            $data['debit']         = $value['total_debit'];
            $data['commission']    = $value['total_commission'];
            $data['total_money']   = $data['money'];
            $data['serialize']     = serialize($value);
            $data['create_uid']    = get_user_id();
            $data['create_time']   = time();
            $res                   = $splitUserModel->add($data);
            $splitUserIds .= $res . ',';
        }
        session('settlement_split_user', '1');

        return $splitUserIds;
    }


    /**
     * 分账
     * @author Red
     * @date 2017年7月17日11:41:22
     * @param $splitUserId
     * @return bool
     */
    private function split($splitUserId)
    {
        $model          = M('settlement_split_user');
        $splitCardModel = M('settlement_split_card');
        $userModel      = new UserModel();
        $userCardModel  = new UserCardListModel();
        $splitUserInfo  = $model->where(array('id' => $splitUserId))->find();
        $userInfo       = $userModel->getById($splitUserInfo['user_id'], 'level_id');
        $serialize      = unserialize($splitUserInfo['serialize']);
        $userTaskList   = $serialize['task'];
        $bankList       = get_config_table_list('tb_bank');
        //如果当前金额大于920用户层级置为vip(level_id=1) 可以分账
        if ($userInfo['level_id'] == 1 || $splitUserInfo['money'] >= 920) {
            if (false === $userModel->update(array('level_id' => 1), array('id' => $splitUserInfo['user_id']))) {
                return false;
            }
        }
        //根据用户的真实姓名排序
        if (!$userCardModel->getOne(array('user_id' => $splitUserInfo['user_id'], 'status' => 1, 'status_1' => 1))) {
            exit('用户=>' . $splitUserInfo['username'] . '没有绑定银行卡');

            return false;
        }
        //----------------------------------分账(银行卡)开始-----------------------------------------------
        //根据用户任务循环分卡 生成每个任务对应的分账情况
        foreach ($userTaskList as $key => $value) {
            //先分本人卡（如果存在多张则任选一张），再分他人卡；（根据卡主姓名判断是否本人）
            $userCardList = $userCardModel->getAll(array('user_id' => $splitUserInfo['user_id'], 'status' => 1, 'status_1' => 1, 'split_status' => 0, 'last_money' => array('lt', '800')), '*', 'owner="' . $splitUserInfo['username'] . '" desc');
            if (!$userCardList) {
                $userCardList = $userCardModel->get(array('user_id' => $splitUserInfo['user_id'], 'status' => 1, 'status_1' => 1), '*', true, '', '', 'owner="' . $splitUserInfo['username'] . '" desc', 1);
            }
            foreach ($userCardList as $k => $val) {
                $userCardArr[$k]['id']    = $val['id'];
                $userCardArr[$k]['money'] = $val['money'];//已经存在的金额
                $userCardBrr[$val['id']]  = $val;
            }
            $priceArr = $value['price'];
            $countArr = $value['count'];
            $moneyArr = $value['total'];
            $bankArr  = $userCardArr;
//            print_r($priceArr);
//            print_r($countArr);
//            print_r($moneyArr);
//            print_r($bankArr);exit();
            $splitArr = [];

            $resArr = $this->splitWay($splitArr, $priceArr, $countArr, $moneyArr, $bankArr, 0, 0, 0, $bankArr[0]['id']);
//            print_r($resArr);
//            exit();
            foreach ($resArr as $k => $val) {
                $splitCardArr = [];
                foreach ($val['money'] as $v) {
                    $splitCardArr['list_money'] += $v;
                }
                $splitCardArr['settlement_id'] = $splitUserInfo['settlement_id'];
                $splitCardArr['serialize']     = serialize($val);
                //实在弄不平，把奖励扣款全部放在第一张卡上
                if ($k == $bankArr[0]['id']) {
                    $splitCardArr['reward']     = $val['reward'] + $value['reward'];
                    $splitCardArr['debit']      = $val['debit'] + $value['debit'];
                    $splitCardArr['commission'] = $val['commission'] + $value['commission'];
                } else {
                    $splitCardArr['reward']     = $val['reward'] ? $val['reward'] : '0.00';
                    $splitCardArr['debit']      = $val['debit'] ? $val['debit'] : '0.00';
                    $splitCardArr['commission'] = $val['commission'] ? $val['commission'] : '0.00';
                }

                $splitCardArr['user_id']       = $splitUserInfo['user_id'];
                $splitCardArr['username']      = $userCardBrr[$k]['owner'];//银行卡的户主
                $splitCardArr['tell']          = $userCardBrr[$k]['reserve_mobile'];//预留手机
                $splitCardArr['card_num']      = $userCardBrr[$k]['reserve_num'];//预留身份证号码
                $splitCardArr['bank_num']      = $userCardBrr[$k]['card_no'];//卡号
                $splitCardArr['bank_id']       = $k;
                $splitCardArr['bank_name']     = $bankList[$userCardBrr[$k]['bank_id']]['name'];//银行名称
                $splitCardArr['task_id']       = $value['task_id'];//任务ID
                $splitCardArr['total_money']   = $splitCardArr['list_money'] + $splitCardArr['last_money'] + $splitCardArr['reward'] - $splitCardArr['debit'] + $splitCardArr['commission'];
                $splitCardArr['tax']           = $this->getTax($splitCardArr['total_money']);
                $splitCardArr['true_money']    = $splitCardArr['total_money'] - $splitCardArr['tax'];
                $splitCardArr['current_money'] = $splitCardArr['list_money'] + $splitCardArr['reward'] - $splitCardArr['debit'] + $splitCardArr['commission'];
                $splitCardArr['create_uid']    = get_user_id();
                $splitCardArr['create_time']   = time();

                $userCardModel->where('id=' . $k)->setInc('money', $splitCardArr['current_money']);
                $cardInfo = $userCardModel->getById($k);
                if ($cardInfo['money'] >= 700) {
                    if (false === $userCardModel->update(array('split_status' => 1), array('id' => $k))) {
                        return false;
                    }
                }
                if (false === $splitCardModel->add($splitCardArr)) {
                    return false;
                };
            }

            //写入用户任务分账表（用户是指银行卡的户主）

        }

        return true;

    }

    /**
     * 分账方法
     * @author Red
     * @date  2017年7月24日14:04:06
     * @param $splitArr
     * @param $priceArr
     * @param $countArr
     * @param $moneyArr
     * @param $bankArr
     * @param $reward
     * @param $debit
     * @param $commission
     * @param $firstBank
     * @return mixed
     */
    private function splitWay(&$splitArr, $priceArr, $countArr, $moneyArr, $bankArr, $reward, $debit, $commission, $firstBank)
    {
    	
        $num              = 0;
        $currentCardMoney = $bankArr[$num]['money'];//当前卡已经存在的金额
        $stepMoney        = $reward - $debit + $commission + $currentCardMoney;
        //循环单价
        foreach ($priceArr as $key => $price) {
            $stepMoney = $stepMoney + $moneyArr[$key];
            if (isset($bankArr[$num])) {
                //累计的金额是否大于900
                if ($stepMoney > 900) {
                	
                    //从（700,900）中随机选取一个数作为当前卡的金额
                    $lastMoney     = array_sum($splitArr[$bankArr[$num]['id']]['money']) + $currentCardMoney;//当前单价剩余的金额
                    $currentReward = 0;//由于分账不平衡产生的当前卡的奖励 作为下一张卡的扣款
                    $res           = true;
                    while ($res) {
                        $randMoney = $this->getRandMoney();
                        $step      = (ceil($countArr[$key]) / $countArr[$key]) == 0 ? 1 : 0.5;//数量步长
                        for ($i = $step; $i <= $countArr[$key]; $i += $step) {

                            if ($price * $i + $lastMoney == $randMoney) {
                                //当前卡的当前单价数量、金额
                                $splitArr[$bankArr[$num]['id']]['price'][]    = $price;
                                $splitArr[$bankArr[$num]['id']]['count'][]    = $currentCount = $i;
                                $splitArr[$bankArr[$num]['id']]['money'][]    = $currentMoney = $randMoney - $lastMoney;
                                $splitArr[$bankArr[$num]['id']]['debit']      = $debit;
                                $splitArr[$bankArr[$num]['id']]['last_money'] = $currentCardMoney;
                            } else {
                            	print_r($price * $i + $lastMoney + $j);print_r($randMoney);exit();
                                for ($j = 0; $j <= 200; $j += 0.1) { //奖励
                                    if ($price * $i + $lastMoney + $j == $randMoney) {
                                        //当前卡的当前单价数量、金额
                                        $splitArr[$bankArr[$num]['id']]['price'][]    = $price;
                                        $splitArr[$bankArr[$num]['id']]['count'][]    = $currentCount = $i;
                                        $splitArr[$bankArr[$num]['id']]['money'][]    = $currentMoney = $randMoney - $lastMoney - $j;
                                        $splitArr[$bankArr[$num]['id']]['reward']     = $j;
                                        $splitArr[$bankArr[$num]['id']]['debit']      = $debit;
                                        $splitArr[$bankArr[$num]['id']]['last_money'] = $currentCardMoney;

                                        $currentReward = $j;
                                        $res           = false;
                                    }
                                }
                            }
                        }
                    }

                    //重新生成单价列表 递归
                    $priceArr[$key] = $price;
                    $countArr[$key] = $countArr[$key] - $currentCount;//当前单价剩余的数量
                    $moneyArr[$key] = $moneyArr[$key] - $currentMoney;//当前单价剩余的金额
                    $priceArr       = array_slice($priceArr, $key);
                    $countArr       = array_slice($countArr, $key);
                    $moneyArr       = array_slice($moneyArr, $key);
                    $bankArr        = array_slice($bankArr, $num + 1);
                //print_r($splitArr);print_r($priceArr);print_r($countArr);print_r($moneyArr);print_r($bankArr);print_r($currentReward);exit();
                    $this->splitWay($splitArr, $priceArr, $countArr, $moneyArr, $bankArr, 0, $currentReward, 0, $firstBank);
                    break;
                } else {
                    $splitArr[$bankArr[$num]['id']]['price'][]    = $priceArr[$key];
                    $splitArr[$bankArr[$num]['id']]['count'][]    = $countArr[$key];
                    $splitArr[$bankArr[$num]['id']]['money'][]    = $moneyArr[$key];
                    $splitArr[$bankArr[$num]['id']]['reward']     = $reward;
                    $splitArr[$bankArr[$num]['id']]['debit']      = $debit;
                    $splitArr[$bankArr[$num]['id']]['commission'] = $commission;
                    $splitArr[$bankArr[$num]['id']]['last_money'] = $currentCardMoney;
                }
            } else {
                //没有卡 把剩下的钱全部放到第一张卡上
                $leftPriceArr = array_slice($priceArr, $key);
                $leftCountArr = array_slice($countArr, $key);
                $leftMoneyArr = array_slice($moneyArr, $key);

                foreach ($leftPriceArr as $k => $v) {
                    $splitArr[$firstBank]['price'][] = $v;
                    $splitArr[$firstBank]['count'][] = $leftCountArr[$k];
                    $splitArr[$firstBank]['money'][] = $leftMoneyArr[$k];
                }
                $splitArr[$firstBank]['debit'] += $debit;

                break;
            }

        }

        return $splitArr;
    }


    private function getRandMoney()
    {
        return rand(700, 900) + (rand(0, 100) * 0.01);
    }

    /**
     * 税费计算 超过800的部分扣10%
     * @author Red
     * @date 2017年7月17日11:03:05
     * @param $money
     * @return int
     */
    private function getTax($money)
    {
        $moneyLine = 800;
        $tax       = 0;
        if ($money > $moneyLine) {
            $tax = ($money - $moneyLine) * 0.2;
        }

        return $tax;
    }

    /**
     * 工资表
     * @author Red
     * @date 2017年7月26日15:05:17
     * @param $settlementId
     * @return bool
     */
    private function splitWages($settlementId)
    {
        $settlementModel = M('settlement');
        $splitCardModel  = M('settlement_split_card');
        $cardModel       = M('user_card_list');
        $wageModel       = M('settlement_split_wages');
        $settlementInfo  = $settlementModel->where(array('id' => $settlementId))->find();
        $list            = $splitCardModel->where(array('settlement_id' => $settlementId))->group('bank_id')->select();
        foreach ($list as $value) {
            $bankId = $value['bank_id'];
            $info   = $splitCardModel->where(array('bank_id' => $bankId))->select();
            $data   = [];
            foreach ($info as $val) {
                $data['task_ids'] .= $val['task_id'] . ',';
                $data['task_money'] .= $val['current_money'] . ',';
                $data['total_money'] += $val['current_money'];
            }
            $data['user_id']       = $value['user_id'];
            $data['settlement_id'] = $settlementId;
            $data['username']      = $value['username'];
            $data['tell']          = $value['tell'];
            $data['card_num']      = $value['card_num'];
            $data['bank_num']      = $value['bank_num'];
            $data['bank_id']       = $value['bank_id'];
            $data['bank_name']     = $value['bank_name'];
            if ($settlementInfo['month'] == 0) {//15号
                $cardModel->where(array('id' => $value['bank_id']))->save(array('last_money' => $data['total_money']));
                $data['tax'] = $this->getTax($data['total_money']);
            } else {
                $cardInfo = $cardModel->where(array('id' => $value['bank_id']))->find();
                if ($cardInfo['last_money'] > 800) {
                    $data['tax'] = $data['total_money'] * 0.2;
                }
                $data['tax'] = $this->getTax($data['total_money'] + $cardInfo['last_money']);
            }
            $data['tax']        = $this->getTax($data['total_money']);
            $data['true_money'] = $data['total_money'] - $data['tax'];
            if (false === $wageModel->add($data)) {
                return false;
            }
            //em_user_card_list
            if (false === $cardModel->where(array('id' => $value['bank_id']))->save(array('last_money' => $data['total_money']))) {
                return false;
            }
            $data                 = [];
            $data['money']        = 0;
            $data['split_status'] = 0;
            if ($settlementInfo['month']) {//30号
                $data['last_money'] = 0;
            }
            if (false === $cardModel->where(array('id' => $value['bank_id']))->save($data)) {
                return false;
            }

        }

        return true;
    }

}