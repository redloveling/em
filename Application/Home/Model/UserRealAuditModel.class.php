<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/8/9
 * Time: 15:28
 */
namespace Home\Model;
class UserRealAuditModel extends CommonModel
{
    /**
     * 实名认证列表
     * @author Red
     * @date 2017年3月2日11:11:34
     * @param array $map
     * @param string $field
     * @param string $order
     * @param string $limit
     * @return mixed
     */
    public function getUserRealList($map = array(), $field = '*', $order = '', $limit = '0,10')
    {
        $join[] = ' em_user u on u.id=em_user_real_audit.uid';
        $list   = $this->get($map, $field, true, $join, 'inner', $order, $limit);
        $total  = $this->get($map, $field, true, $join);

        return array('rows' => $list, 'total' => count($total));
    }

    /**
     * 通过支付认证
     * @author Red
     * @date  2017年3月3日17:04:52
     * @param $auditId
     * @return bool
     */
    public function passRealAudit($auditId)
    {
        $auditInfo = $this->getById($auditId);
        $userInfo  = get_user_info();
        $serialize = unserialize($auditInfo['serialize']);
        //更改状态
        $data['status']         = 1;
        $data['audit_uid']      = $userInfo['id'];
        $data['audit_username'] = $userInfo['username'];
        $data['audit_time']     = time();
        if (false === $this->update($data, array('id' => $auditId))) {
            return false;
        }
        //把性别真实姓名等更新到user表
        $dataUser['true_name']         = $serialize['true_name'];
        $dataUser['sex']               = $serialize['sex'];
        $dataUser['age']               = $serialize['age'];
        $dataUser['card_num']          = $serialize['card_num'];
        $dataUser['birthday']          = $serialize['birthday'];
        $dataUser['card_num_positive'] = $serialize['card_num_positive'];
        $dataUser['card_num_opposite'] = $serialize['card_num_opposite'];
        $dataUser['real_status']       = 2;
        $dataUser['real_time']         = $data['audit_time'];//审核时间就通过时间
        $userModel = new UserModel();
        if (false === $userModel->update($dataUser,array('id'=>$auditInfo['uid']))) {
            return false;
        }
        insert_user_log($auditInfo['uid'], '通过实名认证', $userInfo['id']);

        return true;
    }

    /**
     * 拒绝支付认证
     * @author Red
     * @date 2017年3月3日17:13:57
     * @param $auditId
     * @param $data
     * @return bool
     */
    public function denyRealAudit($auditId, $data)
    {
        $userInfo               = get_user_info();
        $auditInfo              = $this->getById($auditId);
        $data['status']         = 2;
        $data['audit_uid']      = $userInfo['id'];
        $data['audit_username'] = $userInfo['username'];
        $data['audit_time']     = time();
        if (false === $this->update($data, array('id' => $auditId))) {
            return false;
        }

        //修改user表real_status为未认证
        $userModel = new UserModel();
        if (false === $userModel->update(array('real_status' => 0), array('id' => $auditInfo['uid']))) {
            return false;
        }

        //写入消息表
        $messageModel = new MessageModel();
        if (false === $messageModel->insertMessageFromTemplate($auditInfo['uid'], 2, $data['refuse_type'])) {
            return false;
        }
        insert_user_log($auditInfo['uid'], '拒绝实名认证', $userInfo['id']);
        return true;
    }
}