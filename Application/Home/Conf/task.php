<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/9/27
 * Time: 11:19
 */
return array(
    //任务列表
    'task_list'         => array(
        100 => array('id' => 'task', 'status' => array(0, 1, 2, 3), 'name' => '全部任务', 'checked' => 1, 'img' => 'ic_task_1.png'),
        0   => array('id' => 'task_0', 'status' => array(0), 'name' => '待发布', 'img' => 'ic_task_2.png'),
        1   => array('id' => 'task_1', 'status' => array(1), 'name' => '准备中', 'img' => 'ic_task_3.png'),
        2   => array('id' => 'task_2', 'status' => array(2), 'name' => '进行中', 'img' => 'ic_task_4.png'),
        3   => array('id' => 'task_3', 'status' => array(3, 4), 'name' => '已结束', 'img' => 'ic_task_5.png'),

    ),
    //任务难度
    'task_type'         => array(
        1 => array('id' => 1, 'name' => 1, 'checked' => 1),
        2 => array('id' => 2, 'name' => 2),
        3 => array('id' => 3, 'name' => 3),
        4 => array('id' => 4, 'name' => 4),
        5 => array('id' => 5, 'name' => 5),

    ),
    //性别限制
    'person_type'       => array(
        2 => array('id' => 2, 'name' => '男女不限', 'checked' => 1),
        1 => array('id' => 1, 'name' => '只招男'),
        0 => array('id' => 0, 'name' => '只招女'),
    ),
    //工资计算方式
    'wages'             => array(
        1 => array('id' => 1, 'name' => '月'),
        2 => array('id' => 2, 'name' => '天', 'checked' => 1),
        3 => array('id' => 3, 'name' => '小时'),
        4 => array('id' => 4, 'name' => '单'),
        5 => array('id' => 5, 'name' => '个'),
    ),
    //任务状态
    'task_status'       => array(
        1 => '准备中',
        2 => '进行中',
        3 => '已结束',
        4 => '已结算'
    ),
    //用户任务：准备中状态
    'userTask_status_1' => array(
        1 => '已报名/带录用',
        2 => '报名失败',
        3 => '报名成功'
    ),
    //用户任务：进行中状态
    'userTask_status_2' => array(
        1 => '任务外',
        2 => '任务中',
    ),
    //用户任务：已结束状态
    'userTask_status_3' => array(
        1 => '任务失败',
        2 => '任务完成',
    ),
    //报名审核导出列表
    'userTaskApplyList' => array(
        'filed'     => array(
            'nick_name'         => '昵称',
            'sexName'           => '性别',
            'age'               => '年龄',
            'tell'              => '手机号码',
            'card_num'          => '身份证号码',
            'userTaskStartTime' => '报名时间',
            'userTaskTime'      => '操作时间',
            'userTaskStatus'    => '用户的任务状态',
        ),
        'fileName'  => '报名审核',
        'sheetName' => '报名审核',
    ),
    //执行名单导出列表
    'userTaskDoingList' => array(
        'filed'     => array(
            'nick_name'         => '昵称',
            'sexName'           => '性别',
            'age'               => '年龄',
            'tell'              => '手机号码',
            'card_num'          => '身份证号码',
            'userTaskStartTime' => '报名时间',
            'userTaskTime'      => '最近操作时间',
            'userTaskStatus'    => '用户的任务状态',
        ),
        'fileName'  => '执行名单',
        'sheetName' => '执行名单',
    ),

    //人员名单导出列表
    'userTaskDoneList'  => array(
        'filed'     => array(
            'nick_name'         => '昵称',
            'sexName'           => '性别',
            'age'               => '年龄',
            'tell'              => '手机号码',
            'card_num'          => '身份证号码',
            'userTaskStartTime' => '报名时间',
            'userTaskTime'      => '报名时间',
            'userTaskStatus'    => '用户的任务状态',
        ),
        'fileName'  => '人员名单',
        'sheetName' => '人员名单',
    )
);