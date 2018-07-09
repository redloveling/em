<?php
return array(
	//'配置项'=>'配置值'
	'DEFAULT_MODULE'  => 'Home',//默认模块
    'MODULE_ALLOW_LIST' => array('Home','Api','Cli','Data'),	//允许访问的模块
    'LOAD_EXT_CONFIG' => 'db,shortMessage,task,pay,message', //配置文件加载

    'WEB_TITLE' => 'EM管理平台',//web标题
    'WEB_ICON' => '/images/header_title.png',//web图标

    //注册新的命名空间
    'AUTOLOAD_NAMESPACE' => array(
        'Extend'     => APP_PATH.'Extend',
        'Vendor'     => APP_PATH.'Vendor',
        'Api'        => APP_PATH.'Api',
        'Cli'        => APP_PATH.'Cli',
    ),
    'VERSION'=>'1.0',
    'WEB_NAME'=>'EM',
    'IS_PRODUCT'=>false,
    'SESSION_OPTIONS'=>array('name'=>'settlement_split_user','expire'=>60*60*10)
);