<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/9/27
 * Time: 11:19
 */
return array(
    //付款类别
    'pay_category'=>array(1,2),//1=>商户付款 2=>用户提现
    //付款方式
    'pay_way'=>array(1,2),//1=>支付宝 2=>微信




    //阿里APP支付
    'mobilepay_config' => array(
        'partner'          => '2088421215843628',
        'seller_id'        => 'sbq2015@hotmail.com',
//        'partner'=>'2088102169539536',
//        'seller_id'=>'ppqiro3606@sandbox.com',
        'sign_type'        => 'RSA',
        'notify_url'       => 'http://120.76.191.102:8093/index.php/Public/aliPayNotify',//回调地址
        'input_charset'    => 'UTF-8',
        'private_key_path' => APP_PATH . 'Vendor/Pay/rsa_private_key.pem',
//        'private_key_path'=>APP_PATH.'Vendor/Pay/rsa_private_key1.pem'
    ),
    'wx_app_config'     => array(
        'notify_url' => 'http://120.76.191.102:8093/index.php/Public/aliPayNotify',//回调地址
    ),
);