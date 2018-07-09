<?php
/**
 * Created by PhpStorm.
 * User: red
 * Date: 2016/11/21
 * Time: 14:53
 */
return array(
    //用户列表
    'user_tab'            => array(
        100 => array('id' => 'all', 'img' => 'ic_allPeople.png', 'status' => 'all', 'name' => '全部人员', 'checked' => 1),
        2   => array('id' => 'real', 'img' => 'ic_name.png', 'status' => 'real', 'name' => '实名认证'),
        3   => array('id' => 'pay', 'img' => 'ic_trueName.png', 'status' => 'pay', 'name' => '支付认证'),
        1   => array('id' => 'black', 'img' => 'ic_blacklist.png', 'status' => 'black', 'name' => '黑名单'),

    ),

    //实名审核
    'realaudit_tab'       => array(
        1 => array('id' => 'no', 'img' => 'ic_blacklist.png', 'status' => array(1), 'name' => '待审核', 'checked' => 1),
        2 => array('id' => 'already', 'img' => 'ic_audited.png', 'status' => array(2), 'name' => '已审核'),
    ),
    //支付审核
    'payaudit_tab'        => array(
        0 => array('id' => 'no', 'img' => 'ic_blacklist.png', 'status' => array(0), 'name' => '待审核', 'checked' => 1),
        1 => array('id' => 'already', 'img' => 'ic_audited.png', 'status' => array(1), 'name' => '已审核'),
    ),
    //黑名单状态
    'black_status'        => array(
        0 => '否',
        1 => '是',
    ),
    'black_status1'       => array(
        0 => '',
        1 => '黑名单',
    ),
    //实名认证
    'real_status'         => array(
        0 => '',
        1 => '审核中',
        2 => '已认证',
    ),
    //支付认证
    'pay_status'          => array(
        0 => '',
        1 => '审核中',
        2 => '已认证',
    ),

    //工作状态
    'work_status'         => array(
        1 => '工作',
        2 => '在校',
    ),
    //用户列表导出列表
    'user_tab_list_all'   => array(
        'filed'     => array(
            'nick_name'         => '昵称',
            'sex_name'          => '性别',
            'age'               => '年龄',
            'card_num'          => '身份证号',
            'education_name'    => '学历',
            'tell'              => '手机号码',
            'reg_time_name'     => '注册时间',
            'black_status_name' => '黑名单状态',
            'real_status_name'  => '实名认证',
            'pay_status_name'   => '支付认证',
        ),
        'fileName'  => '用户名单',
        'sheetName' => '用户名单',
    ),
    //实名认证导出列表
    'user_tab_list_real'  => array(
        'filed'     => array(
            'nick_name'         => '昵称',
            'sex_name'          => '性别',
            'age'               => '年龄',
            'card_num'          => '身份证号',
            'education_name'    => '学历',
            'tell'              => '手机号码',
            'reg_time_name'     => '注册时间',
            'black_status_name' => '黑名单状态',
            'real_status_time'  => '认证时间',
        ),
        'fileName'  => '用户实名认证',
        'sheetName' => '用户实名认证',
    ),
    //用户支付认证导出列表
    'user_tab_list_pay'   => array(
        'filed'     => array(
            'nick_name'         => '昵称',
            'sex_name'          => '性别',
            'age'               => '年龄',
            'card_num'          => '身份证号',
            'education_name'    => '学历',
            'tell'              => '手机号码',
            'reg_time_name'     => '注册时间',
            'black_status_name' => '黑名单状态',
            'real_status_time'  => '认证时间',
        ),
        'fileName'  => '用户支付认证',
        'sheetName' => '用户支付认证',
    ),
    //用户黑名单导出列表
    'user_tab_list_black' => array(
        'filed'     => array(
            'nick_name'         => '昵称',
            'sex_name'          => '性别',
            'age'               => '年龄',
            'card_num'          => '身份证号',
            'education_name'    => '学历',
            'tell'              => '手机号码',
            'reg_time_name'     => '注册时间',
            'black_time_name'   => '拉黑时间',
            'black_status_name' => '用户状态',
        ),
        'fileName'  => '黑名单',
        'sheetName' => '黑名单',
    ),

    'userCategoryList' => array(
        1=>'全部用户',
        2=>'黑名单',
        3=>'实名认证',
        4=>'支付认证',
    )
);