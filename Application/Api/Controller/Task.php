<?php

/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/12/7
 * Time: 10:27
 */
class Task extends \Api\Controller\BaseApiController
{
    /**
     * 所有可以报名的任务列表
     * @author Red
     * @date 2016年12月21日15:25:41
     */
    public function getTaskList()
    {
        $pageSize  = $this->pageSize;
        $userId    = parent::checkData('user_id', '缺少用户id');
        $pageNum   = parent::checkData('pageNum', '页数');
        $limit     = ($pageNum - 1) * $pageSize . ',' . $pageSize;
        $taskModel = new \Home\Model\TaskModel();
        //准备中（可报名的）
        $list  = $taskModel->getUserAccessTaskList(array('status' => 1), '*', 'create_time desc', $limit);
        $lists = array();
        if ($list['rows']) {
            foreach ($list['rows'] as $key => $value) {
                $lists['rows'][$key]['id']                   = $value['id'];
                $lists['rows'][$key]['title']                = $value['title'];
                $lists['rows'][$key]['work_area']            = $value['work_area'];
                $lists['rows'][$key]['start_time']           = $value['start_time'];
                $lists['rows'][$key]['end_time']             = $value['end_time'];
                $lists['rows'][$key]['task_type']            = $value['task_type'];
                $lists['rows'][$key]['wages']                = $value['wages'] . '/' . $value['wages_type_name'];
                $lists['rows'][$key]['settlement_type_name'] = $value['settlement_type_name'];
                $lists['rows'][$key]['contact_tell']         = $value['contact_tell'];
            }
        } else {
            $lists['rows'] = null;
        }

        $lists['total'] = ceil($list['total'] / $this->pageSize);
        parent::formatSuccessData($lists);
    }

    /**
     * 待录用（我的工作）
     * @author Red
     * @date 2016年12月21日17:50:39
     */
    public function getUserPrepareTaskList()
    {
        $userId                         = parent::checkData('user_id', '缺少用户id');
        $pageSize                       = $this->pageSize;
        $pageNum                        = parent::checkData('pageNum', '页数');
        if($pageNum<=0){
            parent::checkData('pageNum', '页数必须大于0');
        }
        $limit                          = ($pageNum - 1) * $pageSize . ',' . $pageSize;
        $where['em_user_task.user_id']  = $userId;
        $where['em_user_task.status']   = 1;
        $where['em_user_task.status_1'] = 1;
        $list                           = self::getUserTaskList($where, $limit);
        $list['total']                  = ceil($list['total'] / $pageSize);

        parent::formatSuccessData($list);
    }

    /**
     * 进行中（我的工作）
     * @author Red
     * @date 2016年12月21日17:50:39
     */
    public function getUserDoingTaskList()
    {
        $userId                         = parent::checkData('user_id', '缺少用户id');
        $pageSize                       = $this->pageSize;
        $pageNum                        = parent::checkData('pageNum', '页数');
        $limit                          = ($pageNum - 1) * $pageSize . ',' . $pageSize;
        $where['em_user_task.user_id']  = $userId;
        $where['em_user_task.status']   = 2;//进行中
        $where['em_user_task.status_1'] = 3;//报名成功
        $where['em_user_task.status_2'] = 2;//任务中
        $list                           = self::getUserTaskList($where, $limit);
        $list['total']                  = ceil($list['total'] / $pageSize);

        parent::formatSuccessData($list);
    }

    /**
     * 全部（我的工作）
     * @author Red
     * @date 2016年12月21日17:50:39
     */
    public function getUserAllTaskList()
    {
        $userId                        = parent::checkData('user_id', '缺少用户id');
        $pageSize                      = $this->pageSize;
        $pageNum                       = parent::checkData('pageNum', '页数');
        $limit                         = ($pageNum - 1) * $pageSize . ',' . $pageSize;
        $where['em_user_task.user_id'] = $userId;
        $list                          = self::getUserTaskList($where, $limit);
        $list['total']                 = ceil($list['total'] / $pageSize);
        parent::formatSuccessData($list);
    }

    /**
     * 我的最新兼职
     * @author Red
     * @date 2017年1月9日15:06:54
     */
    public function getUserNewTaskList()
    {
        $userId                         = parent::checkData('user_id', '缺少用户id');
        $where['em_user_task.user_id']  = (int)$userId;
        $where['em_user_task.status']   = array('in', '1,2');//准备中进行中
        $where['em_user_task.status_1'] = array('in', '1,3');//已报名报名成功
        $where['em_user_task.status_2'] = array('in', '2');//任务中
        $list                           = self::getUserTaskList($where, '0,100');
        foreach ($list['rows'] as $key => $value) {
            $lists[$key]['id']          = $value['id'];
            $lists[$key]['task_status'] = $value['task_status'];
            $lists[$key]['title']       = $value['title'];
        }
        parent::formatSuccessData($lists);
    }

    /**
     * 用户任务列表
     * @author Red
     * @date 2016年12月22日11:32:34
     * @param $map
     * @param $limit
     * @param string $order
     * @return array
     */
    private function getUserTaskList($map, $limit = '0,10', $order = 'em_user_task.create_time desc')
    {
        $userTaskModel = new \Home\Model\UserTaskModel();
        $field         = 'k.*,em_user_task.create_time as user_task_time,em_user_task.money as user_money,em_user_task.status_1,em_user_task.status_2,em_user_task.status_3';
        $list          = $userTaskModel->getUserTaskList($map, $field, $order, $limit);
        //print_r($userTaskModel->getLastSql());
        $wageType      = C('wages');
        $lists         = array();
        if ($list['rows']) {
            foreach ($list['rows'] as $key => $value) {
                $lists['rows'][$key]['id']                   = $value['id'];
                $lists['rows'][$key]['title']                = $value['title'];
                $lists['rows'][$key]['work_area']            = $value['work_area'];
                $lists['rows'][$key]['start_time']           = $value['start_time'];
                $lists['rows'][$key]['end_time']             = $value['end_time'];
                $lists['rows'][$key]['task_type']            = $value['task_type'];
                $lists['rows'][$key]['wages']                = $value['wages'] . '/' . $wageType[$value['wages_type']]['name'];
                $lists['rows'][$key]['settlement_type_name'] = $value['settlement_type_name'];
                $lists['rows'][$key]['user_task_time']       = $value['user_task_time'];
                $lists['rows'][$key]['task_status']          = $value['status'];
                $lists['rows'][$key]['user_money']           = $value['user_money'];
                $lists['rows'][$key]['contact_tell']         = $value['contact_tell'];
                $lists['rows'][$key]['status_1']             = $value['status_1'];
                $lists['rows'][$key]['status_2']             = $value['status_2'];
                $lists['rows'][$key]['status_3']             = $value['status_3'];
            }
        } else {
            $lists['rows'] = null;
        }

        $lists['total'] = $list['total'] ? $list['total'] : 0;

        return $lists;
    }

    /**
     * 任务信息
     * @author Red
     * @date 2016年12月22日11:44:00
     */
    public function getTaskInfo()
    {
        $taskId        = parent::checkData('task_id', '任务id');
        $userId        = parent::checkData('user_id', '用户id');
        $taskModel     = new \Home\Model\TaskModel();
        $taskInfo      = $taskModel->getTaskInfo($taskId);
        $userTaskModel = new \Home\Model\UserTaskModel();
        $userTaskInfo  = $userTaskModel->getOne(array('user_id' => $userId, 'task_id' => $taskId), 'status_1,status_2,status_3,money');

        $taskInfo['user_task_status'] = (string)0;//可报名
        $taskInfo['money']            = $userTaskInfo['money'];
        if ($userTaskInfo) {
            if ($userTaskInfo['status_1'] == 4) {//用户取消报名
                $taskInfo['user_task_status'] = (string)0;//可报名
            } elseif ($userTaskInfo['status_1'] == 1) {
                $taskInfo['user_task_status'] = (string)1;//审核中
            } elseif ($userTaskInfo['status_1'] == 3) {
                $taskInfo['user_task_status'] = (string)2;//报名成功
            } else {
                $taskInfo['user_task_status'] = (string)3;//不可报名
            }
            $taskInfo['status_1'] = $userTaskInfo['status_1'];
            $taskInfo['status_2'] = $userTaskInfo['status_2'];
            $taskInfo['status_3'] = $userTaskInfo['status_3'];
        } else {
            $taskInfo['status_1'] = (string)0;
            $taskInfo['status_2'] = (string)0;
            $taskInfo['status_3'] = (string)0;
        }

        //0=>可报名,1=>审核中,2=>报名成功,3=>不可报名
        parent::formatSuccessData($taskInfo);
    }

    /**
     * 报名
     * @author Red
     * @date 2016年12月21日16:14:19
     */
    public function joinTask()
    {

        $userId        = parent::checkData('user_id', '缺少用户id');
        $taskId        = parent::checkData('task_id', '任务id');
        $userTaskModel = new \Home\Model\UserTaskModel();
        $userModel     = new \Home\Model\UserModel();
        $taskModel     = new \Home\Model\TaskModel();
        $res           = $userModel->judgeUserCanJoinWork($userId, $taskId);
        if ($res !== true) {
            parent::formatErrData($res);
            exit();
        }else{
            //检查是否是重新报名
            $userTaskInfo = $userTaskModel->getOne(array('user_id' => $userId, 'task_id' => $taskId), 'id');
            if ($userTaskInfo) {
                $userTaskModel->update(array('status_1' => 1,'status_msg'=>'已报名/待录用'), array('id' => $userTaskInfo['id']));
            } else {
                if (false === $userTaskModel->addUserTask($userId, $taskId)) {
                    parent::formatErrData('添加失败');
                };
                //任务表中更新报名人数
                $taskModel->where(array('id' => $taskId))->setInc('apply_count', 1);
            }
            //添加日志
            api_insert_user_task_log($userId,$taskId,'报名申请');
            $taskInfo = $taskModel->getById($taskId);
            parent::formatSuccessData($taskInfo['deadline']);
        }

    }

    /**
     * 用户取消报名
     * @author Red
     * @date 2017年1月6日17:23:01
     */
    public function cancelTask()
    {
        $userId        = parent::checkData('user_id', '缺少用户id');
        $taskId        = parent::checkData('task_id', '任务id');
        $userTaskModel = new \Home\Model\UserTaskModel();
        $taskModel     = new \Home\Model\TaskModel();
        $taskInfo      = $taskModel->getById($taskId);
        if (!$taskInfo || !in_array($taskInfo['status'], array(1, 2))) {
            parent::formatErrData('任务不存在或者不能取消');
        }
        $userTaskInfo = $userTaskModel->getOne(array('user_id' => $userId, 'task_id' => $taskId), 'status_1,status_2');
        if (!$userTaskInfo) {
            parent::formatErrData('请先参加任务');
        }
        if ($userTaskInfo['status_1'] == 1) {
            parent::formatErrData('该任务正在审核中');
        }
        if ($userTaskInfo['status_1'] == 2) {
            parent::formatErrData('已被拒绝参加该任务');
        }

        //更改user_task的status_1为4取消报名
        $data['status_1'] = 4;
        $data['modify']   = time();
        //如果任务在进行中改为任务外
        if ($taskInfo['status'] == 2 && $userTaskInfo['status_2'] == 2) {
            $data['status_2'] = 1;
            $data['status_msg'] = '任务外（放弃任务）';
            //添加日志
            api_insert_user_task_log($userId,$taskId,'放弃任务');
        }
        //如果在准备中报名成功
        if($taskInfo['status']==1 && $userTaskInfo['status_1']==3){
            $taskModel->where(array('id'=>$taskId))->setDec('entered_count');
//            $taskModel->where(array('id'=>$taskId))->setDec('apply_count');
            //添加日志
            api_insert_user_task_log($userId,$taskId,'取消报名');
            $data['status_msg'] = '报名失败（取消报名）';
        }
        $userTaskModel->update($data, array('user_id' => $userId, 'task_id' => $taskId));

        parent::formatSuccessData(1);
    }

    /**
     * 获取用户消息(系统任务消息列表)
     * @author Red
     * @date 2016年12月23日14:40:11
     */
    public function getUserTaskMessageList()
    {
        $userId                      = parent::checkData('user_id', '缺少用户id');
        $pageSize                    = $this->pageSize;
        $pageNum                     = parent::checkData('pageNum', '页数');
        $limit                       = ($pageNum - 1) * $pageSize . ',' . $pageSize;
        $messageModel                = new \Home\Model\MessageModel();
        $where['em_message.get_uid'] = $userId;
        $where['em_message.type']    = 2;
        $field                       = 'em_message.content,em_message.task_id,task.title as task_title';
        $join                        = 'inner join em_task task on task.id=em_message.task_id';
        //$list                        = $messageModel->join($join)->field($field)->where($where)->group('em_message.task_id')->order('em_message.create_time desc')->limit($limit)->select();
        $list_1 =$messageModel->where($where)->group('em_message.task_id')->limit($limit)->order('em_message.create_time desc')->select();
        $list = array();
        foreach($list_1 as $value){
            $where['task_id']=$value['task_id'];
            $list[] = $messageModel->get($where,$field,false,$join,'','em_message.create_time desc');
        }
        $total                       = $messageModel->join($join)->field($field)->where($where)->group('em_message.task_id')->select();
        if ($list) {
            foreach ($list as $key => $value) {
                $whereM['get_uid']   = $userId;
                $whereM['task_id']   = $value['task_id'];
                $whereM['type']      = 2;
                $whereM['status']    = 0;
                $lists['rows'][$key] = $value;
//                $lists['rows'][$key]['totalCount']  = $total;
                $lists['rows'][$key]['noReadCount'] = $messageModel->getCount($whereM);
            }
        } else {
            $lists['rows'] = array();
        }
        //系统消息
        $messageModel = new \Home\Model\MessageModel();
        $list1        = $messageModel->getAll(array('get_uid' => $userId, 'type' => 1), 'id,content,status,create_time','create_time desc, status asc');

        $noReadCount = $messageModel->getCount(array('get_uid' => $userId, 'type' => 1, 'status' => 0));
//        $totalCount           = $messageModel->getCount(array('get_uid' => $userId, 'type' => 1));
        $list2['task_id']    = '';
        $list2['task_title'] = '系统消息';
        $list2['content']    = $list1['0']['content'] ? $list1['0']['content'] : '';
//        $list2['totalCount']  = $totalCount;
        $list2['noReadCount'] = $noReadCount;
        if ($pageNum == 1) {
            array_unshift($lists['rows'], $list2);
        }
        $lists['total'] = ceil(count($total) / $pageSize);
        parent::formatSuccessData($lists);
    }

    /**
     * 获取用户消息(系统任务消息)
     * @author Red
     * @date 2016年12月23日14:40:11
     */
    public function getUserTaskMessage()
    {
        $userId       = parent::checkData('user_id', '缺少用户id');
        $taskId       = parent::checkData('task_id', '缺少任务id');
        $messageModel = new \Home\Model\MessageModel();
        $list         = $messageModel->get(array('get_uid' => $userId, 'type' => 2, 'task_id' => $taskId), 'id,content,status,create_time',true,'','','create_time desc');
//        $count        = count($list);
//        $noReadCount  = $messageModel->getCount(array('get_uid' => $userId, 'type' => 2, 'status' => 0,'task_id'=>$taskId));
//        foreach ($list as $key => $value) {
//            $list[$key]['count']       = $count;
//            $list[$key]['noReadCount'] = $noReadCount;
//        }

        parent::formatSuccessData($list);
    }
}