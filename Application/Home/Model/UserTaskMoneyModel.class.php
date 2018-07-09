<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/11/22
 * Time: 14:28
 */
namespace Home\Model;


class UserTaskMoneyModel extends CommonModel
{
    /**
     * 用户任务金额
     * @author Red
     * @date  2017年3月2日10:35:59
     * @param $userId
     * @param $taskId
     * @param $money
     */
    public function insertTaskMoney($userId, $taskId, $money)
    {

        $data['user_id'] = $userId;
        $data['task_id'] = $taskId;
        if ($this->getOne($data)) {
            $this->update(array('money' => $money), $data);
        } else {
            $data['money']       = $money;
            $data['create_uid']  = get_user_id();
            $data['create_time'] = time();
            $this->insert($data);
        }

    }
}