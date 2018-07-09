<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/10/14
 * Time: 14:52
 */
namespace Home\Widget;

use Home\Model\TaskModel;
use Home\Model\UserTaskModel;
use Think\Controller;
use Think\Exception;

class TaskWidget extends Controller
{
    /**
     * 获取当前任务信息
     * @author Red
     * @date
     * @param $id
     * @return mixed
     */
    private function getTaskInfo($id)
    {
        $taskModel               = new TaskModel();
        $taskInfo                = $taskModel->getById($id);
        $task_list               = C('task_list');
        $taskInfo['status_name'] = $task_list[$taskInfo['status']]['name'];

        return $taskInfo;
    }

    /**
     * 任务的头部信息
     * @author Red
     * @date 2016年11月14日16:55:09
     * @param $taskId
     */
    public function taskHeader($taskId)
    {
        $taskInfo = self::getTaskInfo($taskId);
        //到期时间计算
        if (in_array($taskInfo['status'], array(0, 1))) {
            $taskInfo['deadline_title']  = '距离任务开始执行';
            $taskInfo['deadline_time']   = explode('-', get_deadline($taskInfo['start_time'], 0, true));
            $taskInfo['deadline_day']    = $taskInfo['deadline_time'][0];
            $taskInfo['deadline_minute'] = $taskInfo['deadline_time'][1];
            $taskInfo['deadline_second'] = $taskInfo['deadline_time'][2];
            $taskInfo['start_deadline']  = '距离任务开始执行：' . get_deadline($taskInfo['start_time']);
        }
        if ($taskInfo['status'] == 2) {
            $taskInfo['deadline_title']  = '距离任务结束';
            $taskInfo['deadline_time']   = explode('-', get_deadline($taskInfo['end_time'], 0, true));
            $taskInfo['deadline_day']    = $taskInfo['deadline_time'][0];
            $taskInfo['deadline_minute'] = $taskInfo['deadline_time'][1];
            $taskInfo['deadline_second'] = $taskInfo['deadline_time'][2];
            $taskInfo['start_deadline']  = '距离任务结束：' . get_deadline($taskInfo['end_time']);
        }
        if ($taskInfo['status'] == 3 || $taskInfo['status'] == 4) {
            $taskInfo['start_deadline'] = '<font style="">任务结束时间：<br/>' . date('Y-m-d H:i', $taskInfo['end_time']);
            $taskInfo['deadline_title'] = '任务结束时间';
            $taskInfo['deadline_time']  = date('Y-m-d H:i', $taskInfo['end_time']);
        }

        $this->assign('vo', $taskInfo);
        $this->display('Widget:task/taskHeader');
    }

    /**
     * 选择任务和当前任务下的人员
     * @author Red
     * @date 2016年11月22日09:49:21
     */
    public function taskChoose()
    {
        $taskModel     = new TaskModel();
        $userTaskModel = new UserTaskModel();
        $userInfo      = get_user_info();
        if (!$userInfo['isSuper']) {
            $where['business_id'] = $userInfo['business_id'];
        }
        $where['status'] = array('neq', 0);
        $taskList        = $taskModel->getAll($where);
        $join[]          = 'inner join em_user u on u.id=em_user_task.user_id';
        $userList        = $userTaskModel->get(array('task_id' => $taskList[0]['id']), 'u.*', true, $join);

        $this->assign('taskList', $taskList);
        $this->assign('userList', $userList);
        $this->display('Widget:task/taskChoose');
    }

    /**
     * 任务详情
     * @author Red
     * @date 2017年2月3日16:36:06
     * @param $taskId
     */
    public function taskDetailInfo($taskId)
    {
        $taskInfo                         = self::getTaskInfo($taskId);
        $task_type                        = C('task_type');
        $wageType                         = C('wages');
        $person_type                      = C('person_type');
        $taskInfo['task_type_name']       = $task_type[$taskInfo['task_type']]['name'] . '级';
        $taskInfo['person_type_name']     = $person_type[$taskInfo['person_type']]['name'];
        $taskInfo['wages_type_name']      = $taskInfo['wages'] . '/' . $wageType[$taskInfo['wages_type']]['name'];
        $settlementList                   = get_config_table_list('tb_settlement');
        $taskInfo['settlement_type_name'] = $settlementList[$taskInfo['settlement_type']]['name'];
//        print_r($_SERVER['HTTP_HOST'].'/index.php/Task/detail/id/30');
        $this->assign('copyContent', $_SERVER['HTTP_HOST'] . '/index.php/Task/detail/id/'.$taskId);//app内部地址
        $this->assign('vo', $taskInfo);
        $this->display('Widget:task/taskDetailInfo');
    }

    /**
     * 任务分账详情
     * @author Red
     * @date 2017年7月24日10:20:12
     * @param $settlementId
     * @param $taskId
     */
    public function taskSettlementDetail($settlementId, $taskId)
    {
        $model                  = M('settlement_split_card');
        $where['settlement_id'] = $settlementId;
        $where['task_id']       = $taskId;
        $list                   = $model->where(array('settlement_id' => $settlementId, 'task_id' => $taskId))->select();
        $taskModel              = new TaskModel();
        $temp = unserialize($list[0]['serialize']);
        $count = count($temp['price']);
        foreach ($list as $key => $value) {
            $serialize               = unserialize($value['serialize']);
            if (count($serialize['price'])>$count){
                $count = count($serialize['price']);
            };

        }
        foreach ($list as $key => $value){
            $serialize               = unserialize($value['serialize']);
            $serialize['price']      = array_pad($serialize['price'], $count, '');
            $serialize['count']      = array_pad($serialize['count'], $count, '');
            $serialize['money']      = array_pad($serialize['money'], $count, '');
            $list[$key]['serialize'] = $serialize;
        }
        $this->assign('count', $count);
        $this->assign('list', $list);
        $this->display('Widget:task/taskSettlementDetail');
    }
    /**
     * 任务分账详情导出
     * @author Red
     * @date 2017年7月24日10:20:12
     * @param $settlementId
     * @param $taskId
     */
    public function exportTaskSplit($settlementId, $taskId)
    {
        $model                  = M('settlement_split_card');
        $where['settlement_id'] = $settlementId;
        $where['task_id']       = $taskId;
        $list                   = $model->where(array('settlement_id' => $settlementId, 'task_id' => $taskId))->select();
        $taskModel              = new TaskModel();
        $temp = unserialize($list[0]['serialize']);
        $count = count($temp['price']);
        foreach ($list as $key => $value) {
            $serialize               = unserialize($value['serialize']);
            if (count($serialize['price'])>$count){
                $count = count($serialize['price']);
            };

        }
        foreach ($list as $key => $value){
            $serialize               = unserialize($value['serialize']);
            $serialize['price']      = array_pad($serialize['price'], $count, '');
            $serialize['count']      = array_pad($serialize['count'], $count, '');
            $serialize['money']      = array_pad($serialize['money'], $count, '');
            $list[$key]['serialize'] = $serialize;
        }
        $taskInfo = $taskModel->getById($taskId,'title');
        include APP_PATH . '/Vendor/Excel.php';
        $Excel = new \Excel($taskInfo['title']);
        $objActSheet = $Excel->create_sheet(0, $taskInfo['title'].'工资');
        $Excel->make_cell_no_merge($objActSheet, 'A', 'A', 1, 1, '姓名');
        $Excel->make_cell_no_merge($objActSheet, 'B', 'B', 1, 1, '电话');
        $Excel->make_cell_no_merge($objActSheet, 'C', 'C', 1, 1, '身份证号');
        $Excel->make_cell_no_merge($objActSheet, 'D', 'D', 1, 1, '银行卡号');
        $Excel->make_cell_no_merge($objActSheet, 'E', 'E', 1, 1, '银行');
        $row = 1;
        $startChar =ord('E');
        for ($i=1;$i<=$count;$i++){
            $startChar++;
            $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '单价'.$i);
            $startChar++;
            $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '数量'.$i);
            $startChar++;
            $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row, '小计'.$i);
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
        $row=2;
        foreach ($list as $value){
            $Excel->make_cell_no_merge($objActSheet, 'A', 'A', $row, $row, $value['username']);
            $Excel->make_cell_no_merge($objActSheet, 'B', 'B', $row, $row, " ".$value['tell']);
            $Excel->make_cell_no_merge($objActSheet, 'C', 'C', $row, $row, " ".$value['card_num']);
            $Excel->make_cell_no_merge($objActSheet, 'D', 'D', $row, $row, " ".$value['bank_num']);
            $Excel->make_cell_no_merge($objActSheet, 'E', 'E', $row, $row, $value['bank_name']);
            $startChar =ord('E');
            $arr = $value['serialize'];
            for ($i=0;$i<$count;$i++){
                $startChar++;
                $Excel->make_cell_no_merge($objActSheet, chr($startChar), chr($startChar), $row, $row,$arr['price'][$i] );
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

//        print_r($Excel);exit();
        $objActSheet->getColumnDimension('B')->setWidth(20);
        $objActSheet->getColumnDimension('C')->setWidth(30);
        $objActSheet->getColumnDimension('D')->setWidth(30);

    }
}