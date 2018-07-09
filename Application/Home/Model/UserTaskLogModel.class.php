<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/11/22
 * Time: 14:28
 */
namespace Home\Model;


class UserTaskLogModel extends CommonModel
{
    /**
     * 用户任务日志
     * @author Red
     * @date  2017年3月2日10:35:59
     * @param $userId
     * @param $taskId
     * @param $msg
     * @param int $operatorId
     */
    public function insertLog($userId, $taskId, $msg, $operatorId = 0)
    {
        $taskModel           = new  TaskModel();
        $userModel           = new  UserModel();
        $taskInfo            = $taskModel->getById($taskId);
        $userInfo            = $userModel->getById($userId);
        $data['user_id']     = $userId;
        $data['username']    = $userInfo['username'];
        $data['task_id']     = $taskId;
        $data['title']       = $taskInfo['title'];
        $data['business_id'] = $taskInfo['business_id'];
        $data['operator_id'] = $operatorId;
        $data['create_time'] = time();
        $data['msg']         = $msg;

        $this->insert($data);
    }
}