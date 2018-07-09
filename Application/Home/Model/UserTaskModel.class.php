<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/8/9
 * Time: 15:28
 */
namespace Home\Model;

use Extend\SendShortMessage;

class UserTaskModel extends CommonModel
{
    /**
     * 获取用户任务列表
     * @author Red
     * @date 2016年11月15日09:55:58
     * @param $map
     * @param string $field
     * @param $order
     * @param $limit
     * @return array
     */
    public function getUserTaskList($map, $field = "*", $order = '', $limit = '0,10')
    {
        $join[] = 'left join em_user u on u.id=em_user_task.user_id';
        $join[] = 'left join em_task k on k.id=em_user_task.task_id';
        $join[] = 'left join em_tb_education te on te.id=u.education_id';
        $list   = $this->get($map, $field, true, $join, '', $order, $limit);
//        print_r($map);
        //print_r($this->getLastSql());
        $total          = $this->get($map, $field, true, $join);
        $settlementList = get_config_table_list('tb_settlement');//为什么接口调用不行楠，我累个去
//        $model = M('tb_settlement');
//        if (F('tb_settlement')) {
//            $settlementList =  F('tb_settlement');
//        }else{
//            $settlementLists = $model->where('status=1')->select();
//            foreach ($settlementLists as $value) {
//                $settlementList[$value['id']] = $value;
//            }
//            //缓存到文件中
//            F('tb_settlement', $settlementList);
//        }

        foreach ($list as $key => $value) {
            $list[$key]['settlement_type_name'] = $settlementList[$value['settlement_type']]['name'];
        }

        return array('total' => count($total), 'rows' => $list);
    }

    /**
     * 获取用户参与的任务的相关数量
     * @author Red
     * @date 2016年11月24日10:46:38
     * @param $userId
     * @return mixed
     */
    public function getUserTaskCount($userId)
    {
        $userTaskModel = new UserTaskModel();
        //报名任务（user_task中所有的）
        $userTask['totalCount'] = $userTaskModel->getCount(array('user_id' => $userId));
        //参加任务（报名成功并且已经完成的 status_1=3）
        $userTask['joinCount'] = $userTaskModel->getCount(array('user_id' => $userId, 'status_1' => 3, 'status_3' => 2));

        return $userTask;
    }

    /**
     * 获取某个用户的任务
     * @author Red
     * @date 2016年11月24日11:13:50
     * @param $userId
     * @param string $field
     * @param $order
     * @param $limit
     * @return array
     */
    public function getUserTaskByUserId($userId, $field = "*", $order = '', $limit = '0,10')
    {
        $join[] = 'left join em_user u on u.id=em_user_task.user_id';
        $join[] = 'left join em_task k on k.id=em_user_task.task_id';
        $list   = $this->get(array('user_id' => $userId), $field, true, $join, '', $order, $limit);
        $total  = $this->get(array('user_id' => $userId), $field, true, $join);

        return array('total' => count($total), 'rows' => $list);
    }

    /**
     * 用户任务报名通过
     * @author Red
     * @date  2016年11月10日11:02:09
     * @param $map
     * @param $userIds
     * @param $taskId
     * @return bool
     */
    public function passApply($map, $userIds, $taskId)
    {
        $taskModel = new TaskModel();
        $taskInfo  = $taskModel->getById($taskId);
        if ($taskInfo['start_time'] < time() || $taskInfo['status'] != 1) {
            saveLog('用户任务报名通过时错误:超过任务开始时间或任务不在准备中，task_id=>' . $taskId, 'userTaskPassApply');

            return '超过任务开始时间或任务状态错误';
        }
        //是否有状态不等于1（准备中）
        $count = $this->getCount(array_merge($map, array('status' => array('neq', 1))));
        if ($count > 0) {
            saveLog('用户任务报名通过时状态错误' . $this->getLastSql(), 'userTaskPassApply');

            return false;
        }
        $uidArr        = explode(',', $userIds);
        $userTaskCount = $this->getCount(array('status' => 1, 'status_1' => 3,'task_id' => $taskId ));
        //写入消息表

        $messageModel = new MessageModel();
        $userModel    = new UserModel();
        $i            = 0;
        foreach ($uidArr as $value) {
            $userInfo = $userModel->getOne(array('id' => $value));
            //排除黑名单用户
            if ($userInfo['black_status'] == 1) {
                return $userInfo['username'] . '为黑名单用户';
            }
            //性别是否符合
            if ($taskInfo['person_type'] != 2 && $userInfo['sex'] != $taskInfo['person_type']) {
                return $userInfo['username'] . '性别不符合任务要求';
            }
            //人数限制
            if (!$this->getOne(array('user_id' => $value, 'task_id' => $taskId, 'status_1' => 3))) {
                $i++;
            }
         
            if ($userTaskCount + $i > $taskInfo['person_num']) {
                return '超过任务报名人数上限';
            }
            
            $userTaskInfo = $this->getOne(array('user_id' => $value, 'task_id' => $taskId), 'status_1');
            //取消报名
            if ($userTaskInfo['status_1'] == 4) {
                return $userInfo['username'] . '已经取消报名';;
            }
            if (in_array($userTaskInfo['status_1'], array(1, 2))) {
                //第一次通过时发送消息
                if (false === $messageModel->insertMessageFromTemplate($value, 4, 0, 0, $taskId)) {
                    return false;
                }
                //更新任务表的报名数量
                if (false == $taskModel->where(array('id' => $taskId))->setInc('entered_count')) {
                    return false;
                }
            }
            //添加日志
            insert_user_task_log($value, $taskId, '报名通过', get_user_id());
        }

        //准备中状态=》status_1改为3（报名成功）
        $map = array_merge($map, array('status' => 1));
        if (false !== $this->update(array('status_1' => 3, 'status_msg' => '报名成功', 'modify_time' => time(), 'pass_time' => time()), $map)) {
            return true;
        }
    }

    /**
     * 用户任务报名拒绝
     * @author Red
     * @date  2016年11月10日11:02:09
     * @param $map
     * @param $userIds
     * @param $taskId
     * @param string $msg
     * @return bool
     */
    public function denyApply($map, $userIds, $taskId, $msg = '')
    {
        //是否有状态不等于1（准备中）
        $count = $this->getCount(array_merge($map, array('status' => array('neq', 1))));
        if ($count > 0) {
            saveLog('用户任务报名拒绝时状态错误' . $this->getLastSql(), 'userTaskDenyApply');

            return false;
        }
        //写入消息表
        $uidArr       = explode(',', $userIds);
        $messageModel = new MessageModel();
        foreach ($uidArr as $value) {
            $userTaskInfo = $this->getOne(array('user_id' => $value, 'task_id' => $taskId), 'status_1');
            if (in_array($userTaskInfo['status_1'], array(1, 3))) {
                //报名成功和第一次报名发送消息
                if (false === $messageModel->insertMessageFromTemplate($value, 5, 0, 0, $taskId, $msg)) {
                    return false;
                }
            }
            if ($userTaskInfo['status_1'] == 3) {
                //更新任务表的报名数量（报名成功后拒绝的）
                $taskModel = new TaskModel();
                if (false == $taskModel->where(array('id' => $taskId))->setDec('entered_count')) {
                    return false;
                }
            }
            //添加日志
            insert_user_task_log($value, $taskId, '拒绝报名', get_user_id());
        }

        $map = array_merge($map, array('status' => 1));

        //准备中状态=》status_1改为2（报名失败）
        return $this->update(array('status_1' => 2, 'status_msg' => '报名失败（拒绝）' . $msg, 'modify_time' => time(), 'deny_time' => time()), $map);
    }

    /**
     * 执行拒绝（任务状态为进行中的拒绝）
     * @author Red
     * @date  2016年11月11日11:25:57
     * @param $map
     * @param $userIds
     * @param  $taskId
     * @return bool
     */
    public function denyDoing($map, $userIds, $taskId)
    {
        //是否有状态不等于2（进行中）
        $count = $this->getCount(array_merge($map, array('status' => array('neq', 2))));
        if ($count > 0) {
            saveLog('用户执行任务中的拒绝状态错误' . $this->getLastSql(), 'userTaskDenyDoing');

            return false;
        }
        $uidArr = explode(',', $userIds);
        foreach ($uidArr as $value) {
            //添加日志
            insert_user_task_log($value, $taskId, '执行拒绝', get_user_id());
        }
        $map = array_merge($map, array('status' => 2));

        //进行中状态=》status_2改为1（任务外）
        return $this->update(array('status_2' => 1, 'status_msg' => '任务外（踢出）'), $map);
    }

    /**
     * 任务结束是结算金额
     * @author Red
     * @date 2016年11月21日14:18:45
     * @param $money
     * @param $userId
     * @param  $taskId
     * @return bool
     */
    public function moneyConfirm($money, $userId, $taskId)
    {
        //是否有状态不等于3（已结束）
        $count = $this->getCount(array('user_id' => $userId, 'task_id' => $taskId, 'status' => array('lt', 3)));
        //var_dump($this->getLastSql());exit();
        if ($count > 0) {
            saveLog('用户任务结束后结算金额时状态错误' . $this->getLastSql(), 'userTaskConfirmMoney');

            return false;
        }

        //添加日志
        insert_user_task_log($userId, $taskId, '金额结算(money=>' . $money . ')', get_user_id());
//        //加入到用户任务金额表
//        $taskMoneyModel = new UserTaskMoneyModel();
//        $taskMoneyModel->insertTaskMoney($userId,$taskId,$money);

        $where['user_id']    = $userId;
        $where['task_id']    = $taskId;
        $userTaskInfo        = $this->getOne($where, 'status_3,money');
        $data['money']       = $money;
        $data['status_4']    = $userTaskInfo['status_3'] == 1 ? 1 : 2;
        $data['modify_time'] = time();
        //更新用户金额 先减去以前的 再加上现在的
        $userAccountModel = new UserAccountModel();
        if (false === $userAccountModel->userAccountModify($userId, $userTaskInfo['money'], '-')) {
            return false;
        }
        if (false === $userAccountModel->userAccountModify($userId, $money, '+')) {
            return false;
        }
        //当前任务是否全部完成结算
        if (false===$this->isTaskSettlement($taskId)){
            return false;
        }
        return $this->update($data, $where);


    }

    /**
     * 根据用户任务表判断任务是否已经全部完成结算
     * @author Red
     * @date 2017年7月13日09:48:38
     * @param $taskId
     * @return bool
     */
    public function isTaskSettlement($taskId)
    {
        //任务报名成功后（任务成功或者失败） 所有人至少结算过一次  项目任务状态变为已结算
        if (!$this->getOne(array('task_id' => $taskId, 'status' => 3,'status_3'=>3, 'status_4' => 0))) {
            $taskModel = new TaskModel();
            insert_task_log($taskId, '任务已结算');
            if (false === $taskModel->update(array('status' => 4), array('id' => $taskId))) {
                return false;
            }
            if (false === $this->update(array('status' => 4), array('task_id' => $taskId))) {
                return false;
            }

        }
        return true;
    }

    /**
     * 写入用户任务表（报名）
     * @author Red
     * @date 2016年12月21日16:10:07
     * @param $userId
     * @param $taskId
     * @return mixed
     */
    public function addUserTask($userId, $taskId)
    {
        $userModel           = new UserModel();
        $taskModel           = new TaskModel();
        $userInfo            = $userModel->getById($userId);
        $taskInfo            = $taskModel->getById($taskId);
        $data['user_id']     = $userId;
        $data['task_id']     = $taskId;
        $data['business_id'] = $taskInfo['business_id'];
        $data['title']       = $taskInfo['title'];
        $data['status']      = $taskInfo['status'];
        $data['status_1']    = 1;//报名
        $data['tell']        = $userInfo['tell'];
        $data['status_msg']  = '已报名/待录用';
        $data['create_time'] = time();
        $data['modify_time'] = time();

        return $this->insert($data);
    }
}