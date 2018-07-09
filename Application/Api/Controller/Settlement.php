<?php

/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/12/7
 * Time: 10:22
 */
class Settlement extends \Api\Controller\BaseApiController
{


    /**
     * 未结算金额
     * @author Red
     * @date 2017年7月27日11:03:47
     */
    public function notSettlement()
    {
        $userId = parent::checkData('user_id', '缺少用户id');
        $model  = M('user_task_settlement');
        $money  = $model->where(array('user_id' => $userId, 'status' => array('in', '0,1')))->sum('money');
        parent::formatSuccessData($money ? $money : '0.00', '获取成功');
    }

    /**
     * 未结算明细
     * @author Red
     * @date 2017年7月27日11:25:23
     */
    public function notSettlementDetail()
    {
        $userId    = parent::checkData('user_id', '缺少用户id');
        $model     = M('user_task_settlement');
        $taskModel = new \Home\Model\TaskModel();
        $taskList  = $model->where(array('user_id' => $userId, 'status' => array('in', '0,1')))->select();
        if (!$taskList) {
            parent::formatSuccessData(array());
        }
        foreach ($taskList as $key => $value) {
            $taskInfo                      = $taskModel->getById($value['task_id'], 'title');
            $serialize                     = $taskInfo['serialize'];
            $list[$key]['task_name']       = $taskInfo['title'];
            $list[$key]['settlement_time'] = $value['create_time'];
            $list[$key]['reward']          = $serialize['reward'] ? $serialize['reward'] : '0.00';
            $list[$key]['debit']           = $serialize['debit'] ? $serialize['debit'] : '0.00';
            $list[$key]['commission']      = $serialize['commission'] ? $serialize['commission'] : '0.00';
            $list[$key]['money']           = $value['money'];
            $list[$key]['list_money']      = $list[$key]['money'] + $list[$key]['reward'] - $list[$key]['debit'] + $list[$key]['commission'];
        }
        parent::formatSuccessData($list, '获取成功');
    }

    /**
     * 未打款
     * @author Red
     * @date 2017年7月27日14:49:36
     */
    public function notPay()
    {
        $userId = parent::checkData('user_id', '缺少用户id');
        $model  = M('settlement_split_wages');
        $money  = $model->where(array('user_id' => $userId, 'status' => 1))->sum('true_money');
        parent::formatSuccessData($money ? $money : '0.00', '获取成功');
    }

    /**
     * 未打款详情
     * @author Red
     * @date 2017年7月27日14:49:57
     */
    public function notPayDetail()
    {
        $userId           = parent::checkData('user_id', '缺少用户id');
        $model            = M('settlement_split_card');
        $settlementModel  = M('user_task_settlement');
        $taskModel        = new \Home\Model\TaskModel();
        $where['user_id'] = $userId;
        $where['status']  = 1;
        $list             = $model->where($where)->group('task_id')->select();
        if (!$list) {
            parent::formatSuccessData(array(), '暂无数据');
        }
        $i = 0;
        foreach ($list as $key => $value) {
            $taskId                          = $value['task_id'];
            $where['task_id']                = $taskId;
            $settlementTask                  = $settlementModel->where(array('user_id' => $userId, 'task_id' => $taskId))->find();
            $taskInfo                        = $taskModel->getById($taskId);
            $taskList[$i]['task_name']       = $taskInfo['title'];
            $taskList[$i]['total']           = count($list);
            $taskList[$i]['settlement_time'] = $settlementTask['create_time'];
            $taskList[$i]['true_money']      = $model->where($where)->sum('true_money');
            $taskList[$i]['tax']             = $model->where($where)->sum('tax');
            $taskList[$i]['total_money']     = $model->where($where)->sum('total_money');
            $bankList                        = $model->where($where)->select();
            foreach ($bankList as $k => $val) {
                $taskList[$i]['bank'][$k]['bank_num']    = $val['bank_num'];
                $taskList[$i]['bank'][$k]['true_money']  = $val['true_money'];
                $taskList[$i]['bank'][$k]['tax']         = $val['tax'];
                $taskList[$i]['bank'][$k]['total_money'] = $val['total_money'];
            }
            $i++;
        }
        parent::formatSuccessData($taskList, '获取成功');
    }

    /**
     * 已到账列表
     * @author Red
     * @date 2017年7月27日16:02:18
     */
    public function arrivedAccountList()
    {
        $pageSize        = $this->pageSize;
        $userId          = parent::checkData('user_id', '缺少用户id');
        $pageNum         = parent::checkData('pageNum', '页数');
        $limit           = ($pageNum - 1) * $pageSize . ',' . $pageSize;
        $model           = M('settlement_split_user');
        $settlementModel = M('settlement');
        $userList        = $model->where(array('user_id' => $userId, 'status' => 2))->limit($limit)->select();
        if (!$userList) {
            parent::formatSuccessData(array('total' => 0, 'rows' => array()));
        }
        $total = $model->where(array('user_id' => $userId, 'status' => 2))->count('*');
        foreach ($userList as $key => $value) {
            $settlementInfo                        = $settlementModel->where(array('id' => $value['settlement_id']))->find();
            $list['rows'][$key]['settlement_id']   = $value['settlement_id'];
            $list['rows'][$key]['settlement_time'] = $settlementInfo['settlement_time'];
            $list['rows'][$key]['money']           = $value['money'];

        }

        $list['total'] = ceil($total / $this->pageSize);
        parent::formatSuccessData($list);
    }

    /**
     * 已到账明细
     * @author Red
     * @date 2017年7月27日16:02:43
     */
    public function arrivedAccountDetail()
    {
        $settlementId           = 1;//parent::checkData('settlement_id', '缺少结算id');
        $userId                 = parent::checkData('user_id', '缺少用户id');
        $model                  = M('settlement_split_card');
        $settlementModel        = M('user_task_settlement');
        $taskModel              = new \Home\Model\TaskModel();
        $where['user_id']       = $userId;
        $where['status']        = 2;
        $where['settlement_id'] = $settlementId;
        $list                   = $model->where($where)->group('task_id')->select();
        if (!$list) {
            parent::formatSuccessData(array(), '暂无数据');
        }
        $i = 0;
        foreach ($list as $key => $value) {
            $taskId                          = $value['task_id'];
            $where['task_id']                = $taskId;
            $settlementTask                  = $settlementModel->where(array('user_id' => $userId, 'task_id' => $taskId))->find();
            $taskInfo                        = $taskModel->getById($taskId);
            $taskList[$i]['task_name']       = $taskInfo['title'];
            $taskList[$i]['total']           = count($list);
            $taskList[$i]['settlement_time'] = $settlementTask['create_time'];
            $taskList[$i]['true_money']      = $model->where($where)->sum('true_money');
            $taskList[$i]['tax']             = $model->where($where)->sum('tax');
            $taskList[$i]['total_money']     = $model->where($where)->sum('total_money');
            $bankList                        = $model->where($where)->select();
            foreach ($bankList as $k => $val) {
                $taskList[$i]['bank'][$k]['bank_num']    = $val['bank_num'];
                $taskList[$i]['bank'][$k]['true_money']  = $val['true_money'];
                $taskList[$i]['bank'][$k]['tax']         = $val['tax'];
                $taskList[$i]['bank'][$k]['total_money'] = $val['total_money'];
            }
            $i++;
        }
        parent::formatSuccessData($taskList, '获取成功');
    }
}