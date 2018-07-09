<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/11/22
 * Time: 14:28
 */
namespace Home\Model;


class UserLogModel extends CommonModel
{
    /**
     * 插入用户日志
     * @author Red
     * @date 2017年3月2日10:35:45
     * @param $userId
     * @param $msg
     * @param int $operatorId
     */
    public function insertLog($userId, $msg, $operatorId = 0)
    {
        $userModel           = new  UserModel();
        $userInfo            = $userModel->getById($userId);
        $data['user_id']     = $userId;
        $data['username']    = $userInfo['username'];
        $data['operator_id'] = $operatorId;
        $data['create_time'] = time();
        $data['msg']         = $msg;

        $this->insert($data);
    }
}