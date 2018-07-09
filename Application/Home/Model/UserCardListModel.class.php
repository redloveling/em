<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/8/9
 * Time: 15:28
 */
namespace Home\Model;
class UserCardListModel extends CommonModel
{
    /**
     * 获取用户银行卡列表
     * @author Red
     * @date 2016年12月21日17:36:20
     * @param $userId
     * @param $map
     * @param string $order
     * @return mixed
     */
    public function getUserCardList($userId, $map = array(), $order = '')
    {
        $join[] = 'inner join em_tb_bank b on b.id=em_user_card_list.bank_id';
        $map    = array_merge(array('em_user_card_list.user_id' => $userId), $map);
        $list   = $this->get($map, 'em_user_card_list.*,b.name as bank_name', true, $join, '', $order);

        return $list;
    }

    /**
     * 通过支付认证
     * @author Red
     * @date 2017年3月3日17:34:33
     * @param $cardId
     * @return bool
     */
    public function passPayAudit($cardId)
    {
        $cardInfo = $this->getById($cardId);
        $userInfo = get_user_info();
        //只有有一张卡通过支付认证则更改用户的支付状态为已通过
        $userModel = new UserModel();
        //如果是第一张卡则把审核时间作为通过时间
        if(!$this->getOne(array('status'=>1,'status_1'=>1))){
            $dataU['pay_time'] = time();
        }
        $dataU['pay_status'] = 2 ;
        if (false === $userModel->update($dataU, array('id' => $cardInfo['user_id']))) {
            return false;
        }
        //更改当前卡的状态为通过认证
        //如果没有默认卡则设为默认卡
        if (!$this->getOne(array('user_id' => $cardInfo['user_id'], 'status' => 1, 'status_1' => 1))) {
            $data['is_default'] = 1;
        }
        $data['status']         = 1;
        $data['audit_uid']      = $userInfo['id'];
        $data['audit_username'] = $userInfo['username'];
        $data['audit_time']     = time();

        if (false === $this->update($data, array('id' => $cardId))) {
            return false;
        }
        insert_user_log($cardInfo['user_id'], '通过支付认证', $userInfo['id']);

        return true;
    }

    /**
     * 拒绝支付认证
     * @author Red
     * @date 2017年3月3日17:29:12
     * @param $cardId
     * @param $data
     * @return bool
     */
    public function denyPayAudit($cardId, $data)
    {
        $userInfo               = get_user_info();
        $cardInfo               = $this->getById($cardId);
        $data['status']         = 2;
        $data['audit_uid']      = $userInfo['id'];
        $data['audit_username'] = $userInfo['username'];
        $data['audit_time']     = time();
        if (false === $this->update($data, array('id' => $cardId))) {
            return false;
        }

        //如果当前人员名下所有卡都为拒绝认证，则更改user表的支付状态为未认证
        $userModel     = new UserModel();
        $userCardCount = $this->getCount(array('user_id' => $cardInfo['user_id'], 'status' => array('in', '0,1')));
        if ($userCardCount <= 0 && false === $userModel->update(array('pay_status' => 0), array('id' => $cardInfo['user_id']))) {
            return false;
        }
        //写入消息表
        $messageModel = new MessageModel();
        if (false === $messageModel->insertMessageFromTemplate($cardInfo['user_id'], 3, 0, $data['refuse_type'])) {
            return false;
        }
        insert_user_log($cardInfo['user_id'], '拒绝支付认证', $userInfo['id']);

        return true;
    }
}