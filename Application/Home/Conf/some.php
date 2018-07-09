<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/9/27
 * Time: 11:19
 */
return array(
    //超级管理员操作的节点
    'super_node'      => '2,17',//节点管理，后台配置
    'super_business'      => '1,8',//神鸟、神鸟运作部
    //后台配置表
    'config'          => array(
        array('table' => 'tb_bank', 'name' => '银行卡类型'),
        array('table' => 'tb_education', 'name' => '学历'),
        //array('table' => 'tb_wages', 'name' => '工资类型'),
        array('table' => 'tb_settlement', 'name' => '工资结算方式'),
        //array('table' => 'tb_work_area', 'name' => '工作区域'),
        array('table' => 'tb_realaudit_refuse_type', 'name' => '实名认证拒绝类型'),
        array('table' => 'tb_payaudit_refuse_type', 'name' => '支付认证拒绝类型'),
        array('table' => 'message_template', 'name' => '消息类型'),
        array('table' => 'tb_business', 'name' => '公司'),
        array('table' => 'tb_version', 'name' => '系统版本'),
        array('table' => 'user_level', 'name' => '用户层级'),
    ),
    //工作区域
    'work_area_level' => array(
        array('id' => 1, 'name' => '省'),
        array('id' => 2, 'name' => '市'),
        array('id' => 3, 'name' => '区'),
    ),
    //消息类型
    'message_type'    => array(
        1 => '系统消息',
        2 => '任务消息',
        3 => '用户留言',
    ),
    //附件配置
    'attachment'      => array(
        'banner' => array(
            'file_type' => array('jpg', 'png'),
            'file_path' => 'uploads/banner/',
            'is_random' => true
        ),
        'file'   => array(
            'file_type' => array('jpg', 'png'),
            'file_path' => 'uploads/file/',
            'is_random' => true
        )
    ),
    //题型
    'question_type'   => array(
        1 => array(
            'name'    => '多选题',
            'default' => 1,
        ),
        2 => array(
            'name' => '单选题',

        ),

        0 => array(
            'name' => '填空题',
        )

    ),
    //交通工具
    'transport_type'  => array(
        1 => '电瓶车',
        2 => '自行车',
        3 => '汽车',
    )
);