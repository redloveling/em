<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2017年3月24日
 * Time: 11:42:30
 */
namespace Home\Model;
class UserAccountLogModel extends CommonModel
{
    /**
     * 商家付款产生的用户打款记录
     * @author Red
     * @date 2017年3月28日16:20:29
     * @param $orderNo
     * @return int
     */
    public function insertFromBusiness($orderNo)
    {
        $payLogModel         = new PayLogModel();
        $payInfo             = $payLogModel->getOne(array('order_no' => $orderNo));
        $data                = array();
        $data['order_no']    = $orderNo;
        $data['user_id']     = $payInfo['user_id'];
        $data['task_id']     = $payInfo['task_id'];
        $data['business_id'] = $payInfo['business_id'];
        $data['category']    = $payInfo['category'];
        $data['pay_way']     = $payInfo['pay_way'];
        $data['status']      = 2;
        $data['money']       = $payInfo['money'];
        $data['operator_id'] = $payInfo['operator_id'];
        $data['create_time'] = time();
        return $this->insert($data);
    }

    /**
     * 用户提现产生的记录
     * @author Red
     * @date 2017年3月28日16:20:29
     * @param $orderNo
     * @return int
     */
    public function insertFromUser($orderNo)
    {
        $payLogModel         = new PayLogModel();
        $payInfo             = $payLogModel->getOne(array('order_no' => $orderNo));
        $data                = array();
        $data['user_id']     = $payInfo['user_id'];
        $data['order_no']    = $orderNo;
        $data['category']    = $payInfo['category'];
        $data['pay_way']     = $payInfo['pay_way'];
        $data['status']      = 0;
        $data['money']       = $payInfo['money'];
        $data['operator_id'] = $payInfo['operator_id'];
        $data['create_time'] = time();
        return $this->insert($data);
    }
}