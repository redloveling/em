<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/10/14
 * Time: 14:52
 */
namespace Home\Widget;

use Home\Model\TaskModel;
use Home\Model\UserCardListModel;
use Home\Model\UserModel;
use Home\Model\UserTaskModel;
use Think\Controller;

class UserWidget extends Controller
{
    /**
     * 用户的信息
     * @author Red
     * @date 2016年11月21日16:15:56
     * @param $userId
     */
    public function showUserInfo($userId)
    {
        $userModel             = new UserModel();
        $userCardModel         = new UserCardListModel();
        $userInfo              = $userModel->getUserInfo($userId);
        $userInfo['sex_name']  = sex_trans($userInfo['sex']);
        $userInfo['serialize'] = unserialize($userInfo['serialize']);
        $cardList              = $userCardModel->getUserCardList($userId, array('em_user_card_list.status' => 1, 'em_user_card_list.status_1' => 1), 'is_default desc');
        $userInfo['cardList']  = $cardList;
        $this->assign('vo', $userInfo);
        $this->display('Widget:user/userInfo');
    }

    /**
     * 选择人员
     * @author Red
     * @date 2016年11月21日17:55:07
     */
    public function userChoose()
    {
        $userModel = new UserModel();
        $userList  = $userModel->getAll();
        $this->assign('userList', $userList);
        $this->display('Widget:user/userChoose');
    }

    /**
     * 根据类别选择人员
     * @author Red
     * @date 2017年7月5日16:05:09
     */
    public function userCategoryChoose()
    {
        $userCategoryList = C('userCategoryList');
        $userModel        = new  UserModel();
        $userList         = $userModel->getAll('', 'id,username,true_name,sex,age');

        $this->assign('userCategoryList', $userCategoryList);
        $this->assign('userList', $userList);
        $this->display('Widget:user/userConditionChoose');
    }

    /**
     * 用户任务历史
     * @author Red
     * @date 2016年11月24日11:18:28
     * @param $userId
     */
    public function userTaskHistory($userId)
    {
        $userModel         = new UserModel();
        $userTaskModel     = new UserTaskModel();
        $userInfo          = $userModel->getUserInfo($userId);
        $userInfo['count'] = $userTaskModel->getUserTaskCount($userId);
        $this->assign('userInfo', $userInfo);
        $this->display('Widget:user/userTaskHistory');
    }

    /**
     * 用户照片
     * @author Red
     * @date 2016年12月5日14:42:49
     * @param $userId
     */
    public function userPicture($userId)
    {
        $userModel = new UserModel();
        $userInfo  = $userModel->getUserInfo($userId);
        $this->assign('vo', $userInfo);
        $this->display('Widget:user/userPicture');
    }

    /**
     * 用户照片改写
     * @author xiaoyu
     * @date 2016年12月5日14:42:49
     * @param $ids
     */
    public function userPictureView($ids)
    {
        $userModel = new UserModel();
        $userInfo  = $userModel->getUserPicture($ids);
        $this->assign('vo', $userInfo);
        $this->display('Widget:user/userPicture');
    }

    /**
     * 用户任务结算
     * @author Red
     * @date 2017年7月11日17:07:11
     * @param $userId
     * @param $taskId
     */
    public function userTaskMoney($userId, $taskId)
    {
        $model                  = M('user_task_settlement');
        $taskModel              = new TaskModel();
        $settlement             = get_config_table_list('tb_settlement');
        $wages                  = C('wages');
        $taskInfo               = $taskModel->getById($taskId, 'wages_type,settlement_type');
        $taskInfo['settlement'] = $settlement[$taskInfo['settlement_type']]['name'];
        $taskInfo['wages']      = $wages[$taskInfo['wages_type']]['name'];
        $info                   = $model->where(array('user_id' => $userId, 'task_id' => $taskId))->find();
        $info['serialize']      = unserialize($info['serialize']);
        $this->assign('userId', $userId);
        $this->assign('taskId', $taskId);
        $this->assign('taskInfo', $taskInfo);
        $this->assign('vo', $info['serialize'] ? $info : array('serialize' => array('price' => array(''))));
        $this->display('Widget:user/userTaskMoney');
    }
}