<?php

/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2017/3/8
 * Time: 10:13
 */
include_once("./Application/Vendor/Pay/Pay.class.php");
class PayInterface extends \Api\Controller\BaseApiController
{
    public function aliPay()
    {
        $pay = new \Pay();
        $order['order_num'] = '2017t'.time();
        $order['type_desc'] = 'test';
        $order['money'] = '0.01';
        //
        parent::formatSuccessData($pay->alipay($order));
    }
    public function wxPay()
    {
        $pay = new \Pay();
        $order['body'] = 'test';
        $order['money'] = '0.01';
        parent::formatSuccessData($pay->wxpay($order));
    }
    public function payResult(){

    }
}