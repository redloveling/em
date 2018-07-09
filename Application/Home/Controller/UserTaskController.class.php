<?php
namespace Home\Controller;

use Home\Model\TaskModel;
use Home\Model\UserModel;
use Home\Model\UserTaskModel;

/**
 * 用户任务控制器
 * Class BaseController
 * @package Home\Controller
 */
class UserTaskController extends BaseController
{
    /**
     * 用户报名名单
     * @author Red
     * @date 2016年11月9日16:42:19
     */
    public function applyList()
    {
        $taskId        = I('taskId', 0, 'int');
        $userTaskModel = new UserTaskModel();
        if ($_POST['other'] == 'list') {
            $where             = array();
            $where['k.status'] = 1;//任务状态为1准备中
            $where['task_id']  = $taskId;
            $where['status_1'] = array('neq', '4');
            if (I('status') > -1 && I('status') != '') {
                $where['k.status'] = I('status');
            }
            if (I('search_status', '', 'trim')) {
                $where['em_user_task.status_1'] = array('in', I('search_status', '', 'trim'));
            }
            if (I('start_time') && I('end_time')) {
                $where['em_user_task.create_time'] = array('between', array(strtotime(I('start_time', '', 'trim')), strtotime(I('end_time', '', 'trim'))));
            }
            if (I('selectName') && I('keyWord')) {
                self::searchTrans(I('selectName'), I('keyWord', '', 'trim'), $where);
            }
            $limit = I('post.offset') . ',' . I('post.limit');
            $field = '*,k.status as taskstatus,u.id as uid,em_user_task.create_time as usertaskcreatetime,em_user_task.pass_time as usertaskpasstime,em_user_task.deny_time as usertaskdenytime,em_user_task.black_time as usertaskblacktime';
            $order = 'em_user_task.status_1 asc , em_user_task.create_time asc , em_user_task.pass_time!=0 desc,em_user_task.pass_time, em_user_task.deny_time!=0 desc,em_user_task.deny_time';//未确认 确认-》申请时间升序 -》通过时间升序  拒绝时间升序
            $list  = $userTaskModel->getUserTaskList($where, $field, $order, $limit);
            foreach ($list['rows'] as $key => $value) {
                $list['rows'][$key]['sexName']           = sex_trans($value['sex']);
                $list['rows'][$key]['userTaskStartTime'] = format_time($value['usertaskcreatetime']);//报名时间
                $list['rows'][$key]['userTaskTime']      = $value['usertaskpasstime'] ? format_time($value['usertaskpasstime']) : '-';//操作时间
                $list['rows'][$key]['userTaskStatus']    = self::userTaskStatus($value['taskstatus'], $value['status_1'], $value['status_2'], $value['status_3'], $value['usertaskdenytime'], $value['usertaskblacktime'], $value['usertaskpasstime']);
            }
            S('userTaskApplyList' . get_user_id(), $list['rows']);
            echo json_encode($list);
            exit;
        }
        $this->assign('taskId', $taskId);
        $this->display();
    }

    /**
     * 格式化搜索条件
     * @author Red
     * @date 2016年11月24日17:37:49
     * @param $selectName
     * @param $keyWord
     * @return array
     */
    private function searchTrans($selectName, $keyWord, &$where)
    {
        switch ($selectName) {
            case 'username':
                $where['u.nick_name'] = array('like', '%' . $keyWord . '%');
                break;
            case 'card_num':
                $where['u.card_num'] = array('like', '%' . $keyWord . '%');
                break;
            case 'age':
                $where['u.age'] = $keyWord;
                break;
            case 'sex':
                $where['u.sex'] = $keyWord == '男' ? 1 : ($keyWord == '女' ? 0 : 100);
                break;
            case 'education':
                $where['te.name'] = array('like', '%' . $keyWord . '%');
                break;
            default:
                return true;
        }

        return $where;
    }

    /**
     * 根据后台用户的操作确定用户任务状态
     *
     * 已报名/待录用        用户已经报名
     * 报名失败（拒绝）     后台管理员主动拒绝
     * 报名失败（超时）     后台自动超时
     * 报名失败（取消报名）  用户主动取消
     * 报名失败（拉黑）     任务准备中用户被拉黑
     * 报名成功            后台报名通过
     * 任务中              任务正在执行中
     * 任务外（放弃任务）    任务在执行中被用户取消
     * 任务外（踢出）       任务在执行中被拒绝
     * 任务外（拉黑）       任务在执行中被拉黑
     * 任务完成            任务到期完成
     * 任务失败（放弃任务）            任务被用户取消
     * 任务失败（踢出）               用户被拒绝
     * 任务失败（拉黑）               用户被拉黑
     * @author Red
     * @date 2017年3月17日10:36:26
     * @param $status
     * @param $status_1
     * @param $status_2
     * @param $status_3
     * @param $passTime
     * @param $denyTime
     * @param $blackTime
     * @return string
     */
    private function userTaskStatus($status, $status_1, $status_2, $status_3, $denyTime, $blackTime, $passTime)
    {
        $userTaskStatus = '';
        if ($status == 1) {
            $status_1 == 1 && $userTaskStatus = '<label style="color: #2eafbb">已报名/待录用</label>';
            $status_1 == 2 && !$passTime && $userTaskStatus = '<label style="color: #878787">报名失败（超时）</label>';
            $status_1 == 2 && !$passTime && $denyTime && $userTaskStatus = '<label style="color: #878787">报名失败（拒绝）</label>';
            $status_1 == 4 && $userTaskStatus = '<label style="color: #878787">报名失败（取消报名）</label>';
            $status_1 == 2 && $blackTime && $userTaskStatus = '<label style="color: #878787">报名失败（拉黑）</label>';
            $status_1 == 3 && $userTaskStatus = '<label style="color: #97c646">报名成功</label>';
        }
        if ($status == 2) {
            $status_2 == 1 && $status_1 == 4 && $userTaskStatus = '<label style="color: #878787">任务外（放弃任务）</label>';
            $status_2 == 1 && $userTaskStatus = '<label style="color: #878787">任务外（踢出）</label>';
            $status_2 == 1 && $blackTime && $userTaskStatus = '<label style="color: #878787">任务外（拉黑）</label>';
            $status_2 == 2 && $userTaskStatus = '<label style="color: #97c646">任务中</label>';

            $status_2==0 && $status_1 == 2 && !$passTime && $userTaskStatus = '<label style="color: #878787">报名失败（超时）</label>';
            $status_2==0 && $status_1 == 2 && $denyTime && $userTaskStatus = '<label style="color: #878787">报名失败（拒绝）</label>';
            $status_2==0 && $status_1 == 4 && $userTaskStatus = '<label style="color: #878787">报名失败（取消报名）</label>';
            $status_2==0 && $status_1 == 2 && $blackTime && $userTaskStatus = '<label style="color: #878787">报名失败（拉黑）</label>';
        }
        if ($status == 3) {
            $status_3 == 1 && $status_1 == 4 && $userTaskStatus = '<label style="color: #878787">任务失败（放弃任务）</label>';
            $status_3 == 1 && $userTaskStatus = '<label style="color: #878787">任务失败（踢出）</label>';
            $status_3 == 1 && $blackTime && $userTaskStatus = '<label style="color: #878787">任务失败（拉黑）</label>';
            $status_3 == 2 && $userTaskStatus = '<label style="color: #97c646">任务完成</label>';

            $status_3==0 && $status_1 == 2 && !$passTime && $userTaskStatus = '<label style="color: #878787">报名失败（超时）</label>';
            $status_3==0 && $status_1 == 2 && $denyTime && $userTaskStatus = '<label style="color: #878787">报名失败（拒绝）</label>';
            $status_3==0 && $status_1 == 4 && $userTaskStatus = '<label style="color: #878787">报名失败（取消报名）</label>';
            $status_3==0 && $status_1 == 2 && $blackTime && $userTaskStatus = '<label style="color: #878787">报名失败（拉黑）</label>';

        }

        return $userTaskStatus;
    }

    /**
     * 报名通过
     * @author Red
     * @date 2016年11月10日10:51:48
     */
    public function passApply()
    {
        $ids    = I('ids', '', 'trim');
        $taskId = I('taskId', 0, 'trim');
        if (IS_POST && $ids && $taskId) {
            $ids               = implode(',', $ids);
            $where['user_id']  = array('in', $ids);
            $where['task_id']  = $taskId;
            $where['status_1'] = array('in', array(1, 2, 3));//后台可以手动通过被拒绝的
            $userTaskModel     = new UserTaskModel();
            trans_start();
            $res = $userTaskModel->passApply($where, $ids, $taskId);
            if (true !== $res) {
                trans_back($res == false ? '' : $res);
            }

            trans_commit();
        }
        exit(returnStatus(0, L('OPERATE_FAIL')));
    }

    /**
     * 报名拒绝
     * @author Red
     * @date 2016年11月10日10:51:48
     */
    public function denyApply()
    {
        $ids    = I('ids', '', 'trim');
        $taskId = I('taskId', 0, 'trim');
        $msg = I('msg', 0, 'trim');
        if (IS_POST && $ids && $taskId) {
            $ids               = implode(',', $ids);
            $where['user_id']  = array('in', $ids);
            $where['task_id']  = $taskId;
            $where['status_1'] = array('in', array(1, 2, 3));//后台可以手动拒绝被通过的
            $userTaskModel     = new UserTaskModel();
            trans_start();
            $res = $userTaskModel->denyApply($where, $ids, $taskId,$msg);
            if ($res === false) {
                trans_back();
            }
            trans_commit();
        }
        exit(returnStatus(0, L('OPERATE_FAIL')));
    }

    /**
     * 用户执行名单
     * @author Red·
     * @date 2016年11月11日11:22:55
     */
    public function doingList()
    {
        $taskId        = I('taskId', 0, 'int');
        $userTaskModel = new UserTaskModel();
        if ($_POST['other'] == 'list') {
            $where             = array();
            $where['k.status'] = 2;//任务状态为2进行中
            $where['task_id']  = $taskId;

            if (I('status') > -1 && I('status') != '') {
                $where['k.status'] = I('status');
            }
            if (I('search_status', '', 'trim')) {
                $where['em_user_task.status_1'] = array('in', I('search_status', '', 'trim'));
            }
            if (I('start_time') && I('end_time')) {
                $where['em_user_task.create_time'] = array('between', array(strtotime(I('start_time', '', 'trim')), strtotime(I('end_time', '', 'trim'))));
            }
            if (I('selectName') && I('keyWord')) {
                self::searchTrans(I('selectName'), I('keyWord', '', 'trim'), $where);
            }
            $limit = I('post.offset') . ',' . I('post.limit');
            $field = '*,k.status as taskstatus,u.id as uid,em_user_task.create_time as usertaskcreatetime,em_user_task.pass_time as usertaskpasstime,em_user_task.deny_time as usertaskdenytime,em_user_task.black_time as usertaskblacktime';
            $order = ' em_user_task.pass_time!=0 desc,em_user_task.pass_time';//通过时间升序
            $list  = $userTaskModel->getUserTaskList($where, $field, $order, $limit);
            foreach ($list['rows'] as $key => $value) {
                $list['rows'][$key]['sexName']           = sex_trans($value['sex']);
                $list['rows'][$key]['userTaskStartTime'] = format_time($value['usertaskcreatetime']);//报名时间
                $list['rows'][$key]['userTaskTime']      = $value['usertaskpasstime'] ? format_time($value['usertaskpasstime']) : '-';//操作时间
                $list['rows'][$key]['userTaskStatus']    = self::userTaskStatus($value['taskstatus'], $value['status_1'], $value['status_2'], $value['status_3'], $value['usertaskdenytime'], $value['usertaskblacktime'], $value['usertaskpasstime']);
            }

            S('userTaskDoingList' . get_user_id(), $list['rows']);
            echo json_encode($list);
            exit;
        }
        $this->assign('taskId', $taskId);
        $this->display();
    }

    /**
     * 执行拒绝（任务状态为进行中的拒绝）
     * @author Red
     * @date 2016年11月11日11:24:17
     */
    public function denyDoing()
    {
        $ids    = I('ids', '', 'trim');
        $taskId = I('taskId', 0, 'trim');
        if (IS_POST && $ids && $taskId) {
            $ids              = implode(',', $ids);
            $where['user_id'] = array('in', $ids);
            $where['task_id'] = $taskId;
            $userTaskModel    = new UserTaskModel();
            trans_start();
            $res = $userTaskModel->denyDoing($where, $ids, $taskId);
            if ($res === false) {
                trans_back();
            }
            trans_commit();
        }
        exit(returnStatus(0, L('OPERATE_FAIL')));
    }

    /**
     * 任务完成后的人员名单
     * @author Red
     * @date 2016年11月11日12:00:57
     */
    public function doneList()
    {
        $taskId        = I('taskId', 0, 'int');
        $userTaskModel = new UserTaskModel();
        if ($_POST['other'] == 'list') {
            $where             = array();
            $where['k.status'] = array('in', '3,4');//任务状态为3已结束 4已结算
            $where['task_id']  = $taskId;
            if (I('status') > -1 && I('status') != '') {
                $where['k.status'] = I('status');
            }
            if (I('search_status', '', 'trim')) {
                $where['em_user_task.status_3'] = array('in', I('search_status', '', 'trim'));
            }
            if (I('start_time') && I('end_time')) {
                $where['em_user_task.create_time'] = array('between', array(strtotime(I('start_time', '', 'trim')), strtotime(I('end_time', '', 'trim'))));
            }
            if (I('selectName') && I('keyWord')) {
                self::searchTrans(I('selectName'), I('keyWord', '', 'trim'), $where);
            }
            $limit = I('post.offset') . ',' . I('post.limit');
            $field = '*,k.status as taskstatus,u.id as uid,em_user_task.create_time as usertaskcreatetime,em_user_task.pass_time as usertaskpasstime,em_user_task.deny_time as usertaskdenytime,em_user_task.black_time as usertaskblacktime';
            $order = ' em_user_task.pass_time!=0 desc,em_user_task.pass_time';//通过时间升序
            $list  = $userTaskModel->getUserTaskList($where, $field, $order, $limit);
            foreach ($list['rows'] as $key => $value) {
                $list['rows'][$key]['sexName']           = sex_trans($value['sex']);
                $list['rows'][$key]['userTaskStartTime'] = format_time($value['usertaskcreatetime']);//报名时间
                $list['rows'][$key]['userTaskTime']      = $value['usertaskpasstime'] ? format_time($value['usertaskpasstime']) : '-';//操作时间
                $list['rows'][$key]['userTaskStatus']    = self::userTaskStatus($value['taskstatus'], $value['status_1'], $value['status_2'], $value['status_3'], $value['usertaskdenytime'], $value['usertaskblacktime'], $value['usertaskpasstime']);
            }
            //print_r($list);
            S('userTaskDoneList' . get_user_id(), $list['rows']);
            echo json_encode($list);
            exit;
        }
        $this->assign('taskId', $taskId);
        $this->display();
    }

    /**
     * 任务完成后的金额计算名单
     * @author Red
     * @date 2016年11月11日12:00:57
     */
    public function moneyList()
    {
        $taskId        = I('taskId', 0, 'int');
        $userTaskModel = new UserTaskModel();
        //此处检测结算分账用户session
//        if(session('settlement_split_user')){
//            $model = M('settlement_split_user');
//            $model->where(array('status'=>1))->save(array('status'=>0));
//            session('settlement_split_user',null);
//        }
        if ($_POST['other'] == 'list') {
            $where                          = array();
            $where['k.status']              = array('in', '3,4');//任务状态为3已结束
            $where['em_user_task.status_3'] = array('in', '1,2');//任务完成或失败
            $where['task_id']               = $taskId;


            if (I('search_status', '', 'trim')) {
                $where['em_user_task.status_3'] = array('in', I('search_status', '', 'trim'));
            }
            if (I('start_time') && I('end_ti me')) {
                $where['em_user_task.create_time'] = array('between', array(strtotime(I('start_time', '', 'trim')), strtotime(I('end_time', '', 'trim'))));
            }
            if (I('selectName') && I('keyWord')) {
                self::searchTrans(I('selectName'), I('keyWord', '', 'trim'), $where);
            }
            $limit          = I('post.offset') . ',' . I('post.limit');
            $field          = '*,k.status as taskstatus,u.id as uid,em_user_task.create_time as usertaskcreatetime,em_user_task.pass_time as usertaskpasstime,em_user_task.deny_time as usertaskdenytime,em_user_task.black_time as usertaskblacktime';
            $list           = $userTaskModel->getUserTaskList($where, $field, 'em_user_task.money,em_user_task.modify_time', $limit);
            $userTaskStatus = C('userTask_status_3');
            $wageType       = C('wages');
            $settlement     = get_config_table_list('tb_settlement');
            foreach ($list['rows'] as $key => $value) {
                $list['rows'][$key]['sexName']            = sex_trans($value['sex']);
                $list['rows'][$key]['userTaskStartTime']  = format_time($value['usertaskcreatetime']);//报名时间
                $list['rows'][$key]['userTaskStatus_3']   = $userTaskStatus[$value['status_3']];
                $list['rows'][$key]['wageName']           = $value['wages'] . '/' . $wageType[$value['wages_type']]['name'];//工资
                $list['rows'][$key]['settlementTypeName'] = $settlement[$value['settlement_type']]['name'];//结算方式
            }
            echo json_encode($list);
            exit;
        }
        $this->assign('taskId', $taskId);
        $this->display();
    }

    /**
     * 确定金额
     * @author Red
     * @date 2016年11月21日14:08:14
     */
    public function moneyConfirm()
    {
        $ids    = I('ids', '', 'trim');
        $moneys = I('moneys', '', 'trim');
        $taskId = I('taskId', 0, 'trim');
        if (IS_POST && $ids && $moneys && $taskId) {
            trans_start();
            $userTaskModel = new UserTaskModel();
            foreach ($ids as $key => $value) {
                //考虑到任务可能是因为进行到一半退出的，商家会给用户结一部分的钱，所以 任务失败也可以结算 2017年3月20日11:54:01
                if (false === $userTaskModel->moneyConfirm($moneys[$key], $value, $taskId))
                    trans_back();
            }
            //ckandqianrenwucanyurenyuanshifouyjingquanbujiezhang
            //查看当前任务参与人员是否已经全部结账-_-~~

            //任务报名成功后（任务成功或者失败） 所有人至少结算过一次  项目任务状态变为已结算
            if (!$userTaskModel->getOne(array('task_id' => $taskId, 'status' => 3, 'status_4' => 0))) {
                $taskModel = new TaskModel();
                insert_task_log($taskId, '任务已结算');
                if (false === $taskModel->update(array('status' => 4), array('id' => $taskId))) {
                    trans_back();
                }
                if (false === $userTaskModel->update(array('status' => 4), array('task_id' => $taskId))) {
                    trans_back();
                }

            }
            trans_commit();
        }
        exit(returnStatus(0, L('OPERATE_FAIL')));
    }

    /**
     * 导出
     * @author Red
     * @date 2016年11月15日11:53:51
     */
    public function export()
    {
        $code            = I('key', '', 'trim');
        $list            = S($code . get_user_id());
        $excelFieldsZHCN = C($code);
        exportExcels(array($list), array($excelFieldsZHCN['filed']), $excelFieldsZHCN['fileName'], array($excelFieldsZHCN['sheetName']));
    }

    /**
     * 展示用户的信息
     * @author Red
     * @date 2016年11月21日16:16:30
     */
    public function showUserInfo()
    {
        $userId = I('id', 0, 'int');
        if ($userId) {
            W('User/showUserInfo', array($userId));
        }
    }

    /**
     * 任务结算
     * @author Red
     * @date 2017年7月11日10:51:22
     */
    public function userTaskMoney(){
        $userId = I('userId', 0, 'int');
        $taskId = I('taskId', 0, 'int');
        if($userId && $taskId){
            W('User/userTaskMoney', array($userId,$taskId));
        }
    }
}