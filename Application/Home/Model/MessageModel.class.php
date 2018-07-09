<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/11/22
 * Time: 14:28
 */
namespace Home\Model;

use Extend\SendShortMessage;

class MessageModel extends CommonModel
{

    /**
     * 获取用户给系统的留言
     * @author Red
     * @date 2016年11月22日14:53:44
     * @param $map
     * @param $field
     * @param $order
     * @param $limit
     * @return array
     */
    public function getLeaveMessage($map, $field = '*', $order = '', $limit = '0,10')
    {
        $join[] = 'inner join em_user u on u.id=em_message.send_uid';
        $map    = array_merge($map, array('em_message.type' => 3));
        $field  = $field . ' ,u.id as uid,em_message.status as message_status,em_message.create_time as message_time';
        $list   = $this->get($map, $field, true, $join, 'left', $order, $limit);
        $total  = $this->get($map, $field, true, $join, 'left');

//        print_r($this->getLastSql());
        return array('total' => count($total), 'rows' => $list);
    }

    /**
     * 写入任务消息
     * @author Red
     * @date 2016年11月22日16:28:24
     * @param $arr
     * @return mixed
     */
    public function insertGroupMessage($arr)
    {
        $data['type']        = 2;
        $data['send_uid']    = get_user_id();
        $data['get_uid']     = $arr['uid'];
        $data['content']     = $arr['content'];
        $data['task_id']     = $arr['task_id'];
        $data['title']       = $arr['title'];
        $data['create_time'] = time();
        $data['create_uid']  = get_user_id();

        return $this->insert($data);
    }

    /**
     * 通用短信消息
     * @author Red
     * @date 2017年7月5日15:51:37
     * @param $userId
     * @param $content
     * @return bool
     */
    public function insertCommonShortMsg($sendWay, $userId, $content, $templateKey, $taskName = '', $templateTime = '')
    {
        if (in_array(1, $sendWay)) {
            $data['type']        = 1;//默认为系统消息
            $data['send_uid']    = get_user_id();
            $data['get_uid']     = $userId;
            $data['content']     = $content;
            $data['create_time'] = time();
            $data['create_uid']  = get_user_id();
            if (false === $this->insert($data)) {
                return false;
            }
        }
        if (in_array(2, $sendWay)) {
            //判断该用户是否设置了发送短信
            $userModel = new UserModel();
            $userInfo  = $userModel->getById($userId);
            if ($userInfo['is_shortmessage'] == 1 && $userInfo['black_status'] == 0) {
                $shortMessage = new SendShortMessage();
                $template     = C('message_template_code');
                $tempCode     = $template[$templateKey]['code'];
                $params       = [];
                if ($templateKey == 1) {
                    //变更执行时间
                    $params['task'] = $taskName;
                    $params['date'] = $templateTime;
                }
                if ($templateKey == 2) {
                    //项目培训时间提醒
                    $params['task'] = $taskName;
                    $params['date'] = $templateTime;
                }
                if ($templateKey == 3) {
                    //新项目通知
                    $params['task'] = $taskName;
                }
                if ($templateKey == 4) {
                    //基础培训通知
                    $params['date'] = $templateTime;
                }
                if ($templateKey == 5) {
                    //工资发放通知
                    $params = array('error' => '奇葩不传参数居然不行');
                }
                if ($templateKey == 6) {
                    //身份信息填报通知
                    $params = array('error' => '奇葩不传参数居然不行');
                }
                if ($templateKey == 7) {
                    //安全通知
                    $params['date'] = $templateTime;
                }
                $shortMessage->alisend($userInfo['tell'], $tempCode, $params);
            }
        }

        return true;
    }

    /**
     * 从消息模板中写入消息
     * @author Red
     * @date 2016年12月6日16:14:57
     * @param $userId
     * @param $category
     * @param int $realTypeId
     * @param int $payTypeId
     * @param int $taskId
     * @param string $msg
     * @return mixed
     */
    public function insertMessageFromTemplate($userId, $category, $realTypeId = 0, $payTypeId = 0, $taskId = 0, $msg = '')
    {
        $messageTempModel    = new MessageTemplateModel();
        $userModel           = new UserModel();
        $userInfo            = $userModel->getById($userId);
        $templateInfo        = $messageTempModel->getOne(array('category' => $category));
        $data                = array();
        $data['type']        = $templateInfo['type'];
        $data['send_uid']    = get_user_id();
        $data['get_uid']     = $userId;
        $data['content']     = $messageTempModel->transformMessageParams($templateInfo['message'], $realTypeId, $payTypeId, $taskId, $msg);
        $data['create_time'] = time();
        $data['create_uid']  = get_user_id();
        if ($templateInfo['is_short_message']) {
            //发送短信
            $shortMessage = new SendShortMessage();

            //黑名单
            if ($category == 1) {
                $params = array('error' => '奇葩不传参数居然不行');
            }
            //实名认证拒绝
            if ($category == 2) {
                $model  = M('tb_realaudit_refuse_type');
                $info   = $model->where(array('id' => $realTypeId))->find();
                $params = array('type' => $info['name']);
            }
            //支付认证拒绝
            if ($category == 3) {
                $model  = M('tb_payaudit_refuse_type');
                $info   = $model->where(array('id' => $payTypeId))->find();
                $params = array('type' => $info['name']);
            }
            //报名通过  任务开始 结束
            if (in_array($category, array(4, 6, 7))) {
                $taskModel       = new TaskModel();
                $taskInfo        = $taskModel->getById($taskId);
                $params          = array('task' => $taskInfo['title']);
                $data['task_id'] = $taskInfo['id'];
                $data['title']   = $taskInfo['title'];
            }
            //报名不通过
            if (in_array($category, array(5))) {
                $taskModel       = new TaskModel();
                $taskInfo        = $taskModel->getById($taskId);
                $params          = array('task' => $taskInfo['title'], 'reason' => $msg);
                $data['task_id'] = $taskInfo['id'];
                $data['title']   = $taskInfo['title'];
            }
            //判断该用户是否设置了发送短信 只针对任务
            if ($templateInfo['is_short_message'] == 1 && $userInfo['is_shortmessage'] == 1) {
                $shortMessage->alisend($userInfo['tell'], $templateInfo['template_code'], $params);
            }

        }
        if (false === $this->insert($data)) {
            return false;
        }

        return true;
    }
}