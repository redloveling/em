<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/8/9
 * Time: 15:28
 */
namespace Home\Model;
class TaskModel extends CommonModel
{

    /**
     * 任务列表
     * @author Red
     * @date 2016年11月14日14:19:51
     * @param $map
     * @param string $field
     * @param $order
     * @param $limit
     * @return array
     */
    public function getTaskList($map, $field = "*", $order = '', $limit = '0,10')
    {
        $user_info = get_user_info();
        if (!$user_info['isSuper']) {
            $map = array_merge($map, array('business_id' => $user_info['business_id']));
        }
        $list           = $this->get($map, $field, true, '', '', $order, $limit);//print_r($this->getLastSql());
        $wageType       = C('wages');
        $settlementList = get_config_table_list('tb_settlement');//原来是tp的加载是只加载当前模块的公共函数和common的公共函数，不会加载其他模块的函数，so多个模块的都会用到的函数最好写在common里面
        $adminUserModel = new AdminUserModel();
        $userTaskModel  = new UserTaskModel();
        foreach ($list as $key => $value) {
            $list[$key]['wages_type_name']      = $wageType[$value['wages_type']]['name'];
            $list[$key]['settlement_type_name'] = $settlementList[$value['settlement_type']]['name'];
            $list[$key]['deadline_name']        = $value['deadline'] ? date('Y-m-d H:i', $value['deadline']) : '';
            $list[$key]['issued_time_name']     = $value['issued_time'] ? date('Y-m-d H:i', $value['issued_time']) : '';
            $list[$key]['start_end']            = $value['start_time'] ? date('Y-m-d H:i', $value['start_time']) . '-' . date('Y-m-d H:i', $value['end_time']) : '';
            $list[$key]['no_confirm']           = $userTaskModel->getCount(array('task_id' => $value['id'], 'status' => 1, 'status_1' => 1));
            $list[$key]['no_pay']               = $userTaskModel->getCount(array('task_id' => $value['id'], 'status' => 3, 'status_3' => 2, 'money' => 0));
            if ($value['issued_uid']) {
                $adminUser                     = $adminUserModel->getById($value['issued_uid'], 'username');
                $list[$key]['issued_uid_name'] = $adminUser['username'];
            }
        }
//        print_r($this->getLastSql());
        $total = $this->getCount($map);

        return array('total' => $total, 'rows' => $list);
    }

    /**
     * 获取当前登陆管理员的任务数量
     * @author Red
     * @date 2016年12月2日15:53:39
     * @return mixed
     */
    public function getCurrentTaskCount()
    {
        $userRoleModel = new AdminUserRoleModel();
        $userTaskModel = new UserTaskModel();
        $userInfo      = get_user_info();
        $isSuperman    = $userRoleModel->getOne(array('role_id' => 1, 'user_id' => get_user_id()));
        if (!$isSuperman) {
            $where_1['business_id'] = $where_2['business_id'] = $userInfo['business_id'];
        }
        //待审核
        $where_1['status']   = 1;
        $where_1['status_1'] = 1;
        $count1              = $userTaskModel->getCount($where_1);
        //未金额结算
        $where_2['status']   = 3;
        $where_2['status_3'] = 2;
        $where_2['money']    = 0;
        $count2              = $userTaskModel->getCount($where_2);

        return $count1 + $count2;
    }

    /**
     * 获取任务信息
     * @author Red
     * @date 2016年12月22日11:40:26
     * @param $taskId
     * @return mixed
     */
    public function getTaskInfo($taskId)
    {
        $taskInfo                         = $this->getById($taskId);
        $wageType                         = C('wages');
        $settlementList                   = get_config_table_list('tb_settlement');
        $taskInfo['wages_type_name']      = $wageType[$taskInfo['wages_type']]['name'];
        $taskInfo['wages']                = $taskInfo['wages'] . '/' . $wageType[$taskInfo['wages_type']]['name'];
        $taskInfo['settlement_type_name'] = $settlementList[$taskInfo['settlement_type']]['name'];
        $taskInfo['work_area_detail']     = unserialize($taskInfo['work_area_detail']);

        return $taskInfo;
    }

    /**
     * 用户可以参加的任务列表
     * @author Red
     * @date 2017年1月5日10:36:55
     * @param $map
     * @param string $field
     * @param string $order
     * @param string $limit
     * @return array
     */
    public function getUserAccessTaskList($map, $field = "*", $order = '', $limit = '0,10')
    {

        $list           = $this->get($map, $field, true, '', '', $order, $limit);//print_r($this->getLastSql());
        $wageType       = C('wages');
        $settlementList = get_config_table_list('tb_settlement');//原来是tp的加载是只加载当前模块的公共函数和common的公共函数，不会加载其他模块的函数，so多个模块的都会用到的函数最好写在common里面
        $userTaskModel  = new UserTaskModel();
        foreach ($list as $key => $value) {
            $list[$key]['wages_type_name']      = $wageType[$value['wages_type']]['name'];
            $list[$key]['settlement_type_name'] = $settlementList[$value['settlement_type']]['name'];
            $list[$key]['no_confirm']           = $userTaskModel->getCount(array('task_id' => $value['id'], 'status' => 1, 'status_1' => 1));
            $list[$key]['no_pay']               = $userTaskModel->getCount(array('task_id' => $value['id'], 'status' => 3, 'status_3' => 2, 'money' => 0));
        }
        $total = $this->getCount($map);

        return array('total' => $total, 'rows' => $list);
    }
}