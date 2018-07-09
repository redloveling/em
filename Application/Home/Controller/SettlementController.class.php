<?php
namespace Home\Controller;

use Extend\Settlement;
use Home\Model\AdminUserModel;
use Home\Model\SettlementModel;
use Home\Model\TaskModel;
use Home\Model\UserModel;


/**
 * 账户结算控制器
 * Class MessageController
 * @package Home\Controller
 */
class SettlementController extends BaseController
{


    /**
     * 账户结算
     * @author Red
     * @date 2016年11月23日17:09:30
     */
    public function index()
    {

        if ($_POST['other'] == 'list') {
            $limit            = I('post.offset') . ',' . I('post.limit');
            $model            = new SettlementModel();
            $userModel        = new AdminUserModel();
            $settlementStatus = C('settlementStatus');
            $list             = $model->get('', '*', true, '', '', 'settlement_time desc', $limit);
            foreach ($list as $key => $value) {
                $list[$key]['settlement_time_name'] = $value['settlement_time'] ? date('Y-m-d', $value['settlement_time']) : '';
                $list[$key]['pay_time_name']        = $value['pay_time'] ? date('Y-m-d', $value['pay_time']) : '-';
                $userInfo                           = $userModel->getById($value['settlement_uid'], 'username');
                $list[$key]['settlement_uid_name']  = $userInfo['username'];
                $list[$key]['status_name']          = $settlementStatus[$value['status']];
            }
            $total = $model->getCount();
            echo json_encode(array('rows' => $list, 'total' => $total));
            exit();
        }


        $this->display();
    }

    /**
     * 根据每个任务结算
     * @author Red
     * @date 2017年7月24日14:31:14
     */
    public function taskSettlement()
    {
        $settlementId = I('settlementId', 0, 'int');
        if ($_POST['other'] == 'list') {
            $limit                  = I('post.offset') . ',' . I('post.limit');
            $model                  = M('settlement_split_card');
            $taskModel              = new TaskModel();
            $wageType               = C('wages');
            $where['settlement_id'] = $settlementId;
            $list                   = $model->where($where)->limit($limit)->group('task_id')->select();
            foreach ($list as $key => $value) {
                $taskInfo                 = $taskModel->getById($value['task_id'], 'title,wages,wages_type');
                $list[$key]['task_name']  = $taskInfo['title'];
                $list[$key]['wages_name'] = $taskInfo['wages'] . '/' . $wageType[$taskInfo['wages_type']]['name'];
            }
            $total = $model->where($where)->count();
            echo json_encode(array('rows' => $list, 'total' => $total));
            exit();
        }
        if ($settlementId) {
            $model          = M('settlement');
            $settlementInfo = $model->where(array('id' => $settlementId))->find();
            if (!$settlementInfo['split_status']) {
                $settlement = new Settlement();
                $settlement->batchSettlement($settlementId);
            }
            $this->assign('settlementId', $settlementId);
            $this->assign('info', $settlementInfo);
            $this->display();
        }

    }

    /**
     * 每个任务结算详情
     * @author Red
     * @date 2017年7月24日14:31:33
     */
    public function taskSettlementDetail()
    {
        $settlementId = I('settlementId', 0, 'int');
        $taskId       = I('taskId', 0, 'int');
        if ($settlementId && $taskId) {
            W('Task/taskSettlementDetail', array($settlementId, $taskId));
        }
    }

    /**
     * 按任务导出分账表
     * @author Red
     * @date 2017年7月24日16:46:37
     */
    public function exportTaskSplit()
    {
        $settlementId = I('settlementId', 0, 'int');
        $taskId       = I('taskId', 0, 'int');
        if ($settlementId && $taskId) {
            W('Task/exportTaskSplit', array($settlementId, $taskId));
        }
    }

    /**
     * 导出所有的项目结算
     * @author Red
     * @date 2017年7月27日10:27:11
     */
    public function exportSettlement()
    {
        $settlementId = I('settlementId', 0, 'int');
        if ($settlementId) {
            $model                  = M('settlement_split_card');
            $taskModel              = new  TaskModel();
            $where['settlement_id'] = $settlementId;
            $list                   = $model->where(array('settlement_id' => $settlementId))->group('task_id')->select();
//            print_r($list);exit();
            include APP_PATH . '/Vendor/Excel.php';
            $Excel = new \Excel('项目分账表');
            $sheet     = 0;
            foreach ($list as $k=>$task) {
                $taskId      = $task['task_id'];
                $taskInfo    = $taskModel->getById($taskId, 'title');
                $objActSheet = $Excel->create_sheet($sheet, str_replace('/','-',$taskInfo['title']));
                $taskList    = $model->where(array('settlement_id' => $settlementId, 'task_id' => $taskId))->select();
                $temp        = unserialize($taskList[0]['serialize']);
                $count       = count($temp['price']);
                foreach ($taskList as $key => $val) {
                    $serialize = unserialize($val['serialize']);
                    if (count($serialize['price']) > $count) {
                        $count = count($serialize['price']);
                    };

                }
                foreach ($taskList as $key => $val) {
                    $serialize                   = unserialize($val['serialize']);
                    $serialize['price']          = array_pad($serialize['price'], $count, '');
                    $serialize['count']          = array_pad($serialize['count'], $count, '');
                    $serialize['money']          = array_pad($serialize['money'], $count, '');
                    $taskList[$key]['serialize'] = $serialize;
                }
                $Excel->make_cell_no_merge($objActSheet, 'A', 'A', 1, 1, '姓名');
                $Excel->make_cell_no_merge($objActSheet, 'B', 'B', 1, 1, '电话');
                $Excel->make_cell_no_merge($objActSheet, 'C', 'C', 1, 1, '身份证号');
                $Excel->make_cell_no_merge($objActSheet, 'D', 'D', 1, 1, '银行卡号');
                $Excel->make_cell_no_merge($objActSheet, 'E', 'E', 1, 1, '银行');
                $row       = 1;
                $startChar = ord('E');
                for ($i = 1; $i <= $count; $i++) {
                    $startChar++;
                    $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '单价' . $i);
                    $startChar++;
                    $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '数量' . $i);
                    $startChar++;
                    $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '小计' . $i);
                }
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '奖励');
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '扣款');
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '提成');
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '实得金额');
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '备注');
                $row = 2;
                foreach ($taskList as $value) {
                    $Excel->make_cell_no_merge($objActSheet, 'A', 'A', $row, $row, $value['username']);
                    $Excel->make_cell_no_merge($objActSheet, 'B', 'B', $row, $row, " " . $value['tell']);
                    $Excel->make_cell_no_merge($objActSheet, 'C', 'C', $row, $row, " " . $value['card_num']);
                    $Excel->make_cell_no_merge($objActSheet, 'D', 'D', $row, $row, " " . $value['bank_num']);
                    $Excel->make_cell_no_merge($objActSheet, 'E', 'E', $row, $row, $value['bank_name']);
                    $startChar = ord('E');
                    $arr       = $value['serialize'];
                    for ($i = 0; $i < $count; $i++) {
                        $startChar++;
                        $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $arr['price'][$i]);
                        $startChar++;
                        $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $arr['count'][$i]);
                        $startChar++;
                        $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $arr['money'][$i]);
                    }
                    $startChar++;
                    $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $value['reward']);
                    $startChar++;
                    $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $value['debit']);
                    $startChar++;
                    $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $value['commission']);
                    $startChar++;
                    $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $value['current_money']);
                    $startChar++;
                    $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $value['remark']);
                    $row++;
                }
                $objActSheet->getColumnDimension('B')->setWidth(20);
                $objActSheet->getColumnDimension('C')->setWidth(30);
                $objActSheet->getColumnDimension('D')->setWidth(30);
                $sheet++;
            }



        }
    }

    /**
     * 导出工资表
     * @author Red
     * @date 2017年7月26日18:02:49
     */
    public function exportSplitWages()
    {
        $settlementId = I('settlementId', 0, 'int');
        if ($settlementId) {
            $wagesModel = M('settlement_split_wages');
            $cardModel  = M('settlement_split_card');
            $taskModel  = new TaskModel();
            $wagesList  = $wagesModel->where(array('settlement_id' => $settlementId))->select();
            if (!$wagesList) {
                exit('没有数据');
            }
            $cardList = $cardModel->where(array('settlement_id' => $settlementId))->group('task_id')->select();
            $taskList = [];
            foreach ($cardList as $key => $value) {
                $taskInfo                    = $taskModel->getById($value['task_id'], 'title');
                $taskList[$key]['task_id']   = $value['task_id'];
                $taskList[$key]['task_name'] = $taskInfo['title'];
            }
            include APP_PATH . '/Vendor/Excel.php';
            $fileName    = date('Y-m-d') . '工资表';
            $Excel       = new \Excel($fileName);
            $objActSheet = $Excel->create_sheet(0, '工资表');
            $Excel->make_cell_no_merge($objActSheet, 'A', 'A', 1, 1, '姓名');
            $Excel->make_cell_no_merge($objActSheet, 'B', 'B', 1, 1, '电话');
            $Excel->make_cell_no_merge($objActSheet, 'C', 'C', 1, 1, '身份证号');
            $Excel->make_cell_no_merge($objActSheet, 'D', 'D', 1, 1, '银行卡号');
            $Excel->make_cell_no_merge($objActSheet, 'E', 'E', 1, 1, '银行');
            $row       = 1;
            $startChar = ord('E');
            foreach ($taskList as $value) {
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $value['task_name']);
            }
            $startChar++;
            $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '应发数合计');
            $startChar++;
            $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '应扣税款');
            $startChar++;
            $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '实发数合计');
            $row = 2;
            foreach ($wagesList as $value) {
                $startChar = ord('A');
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $value['username']);
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, " " . $value['tell']);
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, " " . $value['card_num']);
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, " " . $value['bank_num']);
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $value['bank_name']);
                $taskIdArr    = explode(',', rtrim($value['task_ids']));
                $taskMoneyArr = explode(',', rtrim($value['task_money']));
                foreach ($taskList as $val) {
                    $startChar++;
                    foreach ($taskIdArr as $k => $v) {
                        if ($val['task_id'] == $v) {
                            $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $taskMoneyArr[$k]);
                        }
                    }

                }
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $value['total_money']);
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $value['tax']);
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, $value['true_money']);
                $row++;
            }
            $objActSheet->getColumnDimension('B')->setWidth(20);
            $objActSheet->getColumnDimension('C')->setWidth(30);
            $objActSheet->getColumnDimension('D')->setWidth(30);
        }
    }
}