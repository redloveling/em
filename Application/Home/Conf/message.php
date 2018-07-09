<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/9/27
 * Time: 11:19
 */
return array(
    'message_category' => array(
        1=>'黑名单',
        2=>'实名认证失败',
        3=>'支付认证失败',
        4=>'报名通过',
        5=>'报名不通过',
        6=>'任务开始',
        7=>'任务结束',
        8=>'临时通知',
    ),
    'message_type'=>array(
        1=>'系统消息',
        2=>'任务消息',
        3=>'用户留言',
    ),
    'message_params'=>array(
        '{$realType}'=>'实名认证拒绝类型',
        '{$payType}'=>'支付认证拒绝类型',
        '{$taskName}'=>'任务标题',
    ),
);