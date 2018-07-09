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
    'template_arr'=>array(
        1=>array('name'=>'变更执行时间','description'=>'您好，根据项目最新要求，当前项目<input type="text" name="template_time" placeholder="请输入暂停时间" >暂停执行，请悉知。人事电话：028-87688843'),
        2=>array('name'=>'项目培训时间提醒','description'=>'您报名参加的当前项目培训于<input type="text" name="template_time" placeholder="请输入培训时间" >开始，请准时参加！人事电话：028-87688843'),
        3=>array('name'=>'新项目通知','description'=>'平台已发布当前项目信息，请登陆APP及时查看，名额有限，悉知项目实际情况后请尽快报名。人事电话：028-87688843'),

    ),
    'template_brr'=>array(
        4=>array('name'=>'基础培训通知','description'=>'您好，请您于<input type="text" name="template_time" placeholder="请输入培训时间" >，参加基础培训。人事电话：028-87688843'),
        5=>array('name'=>'工资发放通知','description'=>'工资已发放，您可登陆平台进行查询。人事电话：028-87688843'),
        6=>array('name'=>'身份信息填报通知','description'=>'你的身份信息未填报完整，将尽快登陆平台进行填报！人事电话：028-87688843'),
        7=>array('name'=>'安全通知','description'=>'<input type="text" name="template_time" placeholder="请输入时间" value="今天" >天气状况较差，请在户外执行项目的访问员，注意人身安全！'),
    ),
    'message_template_code'=>array(
        1=>array('code'=>'SMS_79445005'),
        2=>array('code'=>'SMS_79320009'),
        3=>array('code'=>'SMS_79645017'),
        4=>array('code'=>'SMS_79495016'),
        5=>array('code'=>'SMS_79430001'),
        6=>array('code'=>'SMS_79310008'),
        7=>array('code'=>'SMS_79695042'),
    ),
);