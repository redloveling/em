<?php
namespace Home\Controller;

use Home\Model\MessageGroupModel;
use Home\Model\MessageModel;
use Home\Model\TaskModel;
use Home\Model\UserModel;
use Home\Model\UserTaskModel;

/**
 * 群发消息控制器
 * Class MessageGroupController
 * @package Home\Controller
 */
class MessageGroupController extends BaseController
{
    /**
     * 消息列表
     * @author Red
     * @date 2016年11月21日17:12:59
     */
    public function index()
    {
        if ($_POST['other'] == 'list') {
            $messageGroupModel = new MessageGroupModel();
            $limit             = I('post.offset') . ',' . I('post.limit');
            $where             = array();
            $list              = $messageGroupModel->get($where, '*', true, '', '', 'em_message_group.create_time desc', $limit);
            $total             = $messageGroupModel->get($where);
            echo json_encode(array('total' => count($total), 'rows' => $list));
            exit;
        }

        $this->display();
    }

    /**
     * 创建消息
     * @author Red
     * @date 2016年11月22日14:04:56
     */
    public function add()
    {
        if (IS_POST) {
            if (I('task-user-input') != 1) {//选择人员
                self::addForUser();
            }
            $taskId             = I('taskId', 0, 'int');
            $userId             = I('userId', '', 'trim');
            $taskModel          = new TaskModel();
            $userModel          = new UserModel();
            $messageModel       = new MessageModel();
            $messageGroupModel  = new MessageGroupModel();
            $taskInfo           = $taskModel->getById($taskId);
            $userInfo           = $userModel->getById($userId);
            $data['task_id']    = check_post('taskId', L('CHOOSE_TASK'), 3);
            $data['title']      = $taskInfo['title'];
            $data['user_ids']   = check_post('userId', L('CHOSE_PEOPLE'), 3);
            $data['user_names'] = $userInfo['true_name'];
//            $data['content']     = check_post('content', L('WRITE_MESSAGE'), 3);
            $data['create_time'] = time();
            $data['create_uid']  = get_user_id();
            if (I('template-input') == 1) {
                $templateKey = I('templateId_arr');
                $templateKey == 1 && $template_time = check_post('template_time', '请输入暂停时间', 3);
                $templateKey == 2 && $template_time = check_post('template_time', '请输入培训时间', 3);
                $templateArr     = C('template_arr');
                $templateD       = $templateArr[$templateKey]['description'];
                $content         = preg_replace("/<(\/?input.*?)>/si", $template_time, $templateD);
                $content         = str_replace("当前", $taskInfo['title'], $content);
                $data['content'] = $content;
                $sendWay         = I('sendWay');
                if (count($sendWay) < 1) {
                    echo '请至少选择一种发送方式';
                    exit();
                }
            }
            trans_start();
            if ($userId == 'all') {
                $data['user_ids']   = '';
                $data['user_names'] = L('ALL');
                $userTaskModel      = new UserTaskModel();
                $join[]             = 'inner join em_user u on u.id=em_user_task.user_id';
                $userList           = $userTaskModel->get(array('task_id' => $taskId), 'u.id,u.username', true, $join);
                foreach ($userList as $value) {
                    $data['user_ids'] .= $value['id'] . ',';
                    $data['uid'] = $value['id'];
                    $res         = $messageModel->insertCommonShortMsg($sendWay, $value['id'], $content, $templateKey, $taskInfo['title'], $template_time);
                    if ($res === false) {
                        trans_back(L('OPERATE_FAIL'));
                    }
                }
            } else {
                $data['uid'] = $userId;
                $res         = $messageModel->insertCommonShortMsg($sendWay, $userId, $content, $templateKey, $taskInfo['title'], $template_time);

                if ($res === false) {
                    trans_back(L('OPERATE_FAIL'));
                }
            }
            unset($data['uid']);

            $res = $messageGroupModel->insert($data);
            if ($res === false) {
                trans_back(L('OPERATE_FAIL'));
            }

            trans_commit(L('OPERATE_SUCCESS'));
            exit();
        }
        $this->display();
    }

    /**
     * 创建消息时选择人员
     * @author Red
     * @date 2017年7月5日16:15:20
     */
    private function addForUser()
    {
        $userList = check_post('userList', L('CHOSE_PEOPLE'), 3);
//        $content                  = ltrim(check_post('content', L('WRITE_MESSAGE'), 3), ',');
        $messageModel             = new MessageModel();
        $userModel                = new UserModel();
        $messageGroupModel        = new MessageGroupModel();
        $groupData['create_time'] = time();
        $groupData['create_uid']  = get_user_id();
        if (I('template-input') == 2) {
            $templateKey = I('templateId_brr');
            $templateKey == 4 && $template_time = check_post('template_time', '请输入培训时间', 3);
            $templateKey == 7 && $template_time = check_post('template_time', '请输入时间', 3);
            $templateArr          = C('template_brr');
            $templateD            = $templateArr[$templateKey]['description'];
            $content              = preg_replace("/<(\/?input.*?)>/si", $template_time, $templateD);
            $groupData['content'] = $content;
            $sendWay              = I('sendWay');
            if (count($sendWay) < 1) {
                echo '请至少选择一种发送方式';
                exit();
            }
        }
        trans_start();
        if ($userList == 'all') {
            $userCategoryList = C('userCategoryList');
            $userCategory     = I('userCategoryId', 0, 'int');
            if (!$userCategoryList[$userCategory]) {
                trans_back(L('OPERATE_FAIL'));
            }

            $where = [];
            if ($userCategory == 1) {
            } elseif ($userCategory == 2) {
                $where['black_status'] = 1;
            } elseif ($userCategory == 3) {
                $where['real_status'] = 2;
            } elseif ($userCategory == 4) {
                $where['pay_status'] = 2;
            }
            $userLists = $userModel->getAll($where, 'id,username,true_name');
            foreach ($userLists as $key => $value) {
                $groupData['user_ids']   = $value['id'];
                $groupData['user_names'] = $value['true_name'];
                $messageModel->insertCommonShortMsg($sendWay, $value['id'], $content, $templateKey, '', $template_time);

                $res = $messageGroupModel->insert($groupData);
            }
        } else {
            $userList = ltrim($userList, 'all,');
            $useArr   = explode(',', $userList);
            foreach ($useArr as $value) {
                $userInfo                = $userModel->getById($value, 'id,username,true_name');
                $groupData['user_ids']   = $userInfo['id'];
                $groupData['user_names'] = $userInfo['true_name'];
                $messageModel->insertCommonShortMsg($sendWay, $value, $content, $templateKey, '', $template_time);
                $res = $messageGroupModel->insert($groupData);
            }

        }
        if ($res === false) {
            trans_back(L('OPERATE_FAIL'));
        }

        trans_commit(L('OPERATE_SUCCESS'));
    }
}