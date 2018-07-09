<?php
/**
 * Created by PhpStorm.
 * User: red
 * Date: 2016/11/21
 * Time: 14:53
 */
return array(
    //用户列表
    'user_tab'  => array(
        100 => array('id' => 'all', 'status' => array(0, 1), 'name' => '全部人员', 'checked' => 1),
        1   => array('id' => 'black', 'status' => array(1), 'name' => '黑名单'),


    ),

    //黑名单状态
    'black_status'   => array(
        0 => '否',
        1 => '是',
    ),
    'black_status1'  => array(
        0 => '',
        1 => '黑名单',
    ),
    //实名认证
    'real_status'    => array(
        0 => '',
        1 => '审核中',
        2 => '已认证',
    ),
    //支付认证
    'pay_status'     => array(
        0 => '',
        1 => '审核中',
        2 => '已认证',
    ),

    //工作状态
    'work_status'    => array(
        1 => '工作',
        2 => '在校',
    ),
    //用户列表导出列表
    'user_tab_list0'  => array(
        'filed'     => array(
            'nick_name'         => '昵称',
            'sex_name'           => '性别',
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
    //用户黑名单导出列表
    'user_tab_list1' => array(
        'filed'     => array(
            'nick_name'         => '昵称',
            'sex_name'           => '性别',
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
);