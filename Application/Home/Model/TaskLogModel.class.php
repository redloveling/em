<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/11/22
 * Time: 14:28
 */
namespace Home\Model;


class TaskLogModel extends CommonModel
{
    /**
     * 插入任务日志
     * @author Red
     * @date 2017年3月9日16:09:08
     * @param $taskId
     * @param $msg
     */
    public function insertLog($taskId, $msg)
    {
        $taskModel             = new  TaskModel();
        $userInfo              = get_user_info();
        $taskInfo              = $taskModel->getById($taskId);
        $data['task_id']       = $taskId;
        $data['business_id']   = $taskInfo['business_id'];
        $data['title']         = $taskInfo['title'];
        $data['operator_id']   = $userInfo['id'];
        $data['operator_name'] = $userInfo['username'];
        $data['create_time']   = time();
        $data['msg']           = $msg;
        $this->insert($data);
    }
}