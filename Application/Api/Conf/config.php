<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/12/7
 * Time: 9:46
 */
return array(
    'LANG_SWITCH_ON' => true,   // 开启语言包功能
    'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
    'LOAD_EXT_CONFIG' => 'user,task', //配置文件加载

    //接口方法
    'API' => array(
        'api_key' => 'db_em',
        'config'  => array(
            //发送短信验证码
            'sendShortMessageCode'=>array(
                'path'      => './Application/Api/Controller/Common.php', //类的路径
                'objName'   => 'Common',//类名
                'function'  => 'sendShortMessageCode',//方法名，如果没有则默认为key
                'type'      => 1,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //短信验证码验证
            'getShortMessageCode'=>array(
                'path'      => './Application/Api/Controller/Common.php', //类的路径
                'objName'   => 'Common',//类名
                'function'  => 'getShortMessageCode',//方法名，如果没有则默认为key
                'type'      => 1,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),

//---------------------------------------普通类----------------------------------------------------------
            //学历列表
            'getEducationList'=>array(
                'path'      => './Application/Api/Controller/Common.php', //类的路径
                'objName'   => 'Common',//类名
                'function'  => 'getEducationList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //银行卡列表
            'getBankList'=>array(
                'path'      => './Application/Api/Controller/Common.php', //类的路径
                'objName'   => 'Common',//类名
                'function'  => 'getBankList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //题库列表
            'getQuestionList'=>array(
                'path'      => './Application/Api/Controller/Common.php', //类的路径
                'objName'   => 'Common',//类名
                'function'  => 'getQuestionList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //阅读消息
            'readMessage'=>array(
                'path'      => './Application/Api/Controller/Common.php', //类的路径
                'objName'   => 'Common',//类名
                'function'  => 'readMessage',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //BANNER
            'getBannerList'=>array(
                'path'      => './Application/Api/Controller/Common.php', //类的路径
                'objName'   => 'Common',//类名
                'function'  => 'getBannerList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //ANDROID版本
            'getNewVersion'=>array(
                'path'      => './Application/Api/Controller/Common.php', //类的路径
                'objName'   => 'Common',//类名
                'function'  => 'getNewVersion',//方法名，如果没有则默认为key
                'type'      => 1,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
//---------------------------------------用户类----------------------------------------------------------


            //用户注册
            'userRegister'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'userRegister',//方法名，如果没有则默认为key
                'type'      => 1,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户登陆
            'userLogin'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'userLogin',//方法名，如果没有则默认为key
                'type'      => 1,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户重置密码
            'userPasswordReset'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'userPasswordReset',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户忘记密码
            'userPasswordForget'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'userPasswordForget',//方法名，如果没有则默认为key
                'type'      => 1,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户基本信息
            'getUserInfo'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'getUserInfo',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户简历
            'userResume'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'userResume',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户实名认证
            'userRealAudit'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'userRealAudit',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //添加用户银行卡
            'userPayAudit'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'userPayAudit',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //删除用户银行卡
            'userDeleteBank'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'userDeleteBank',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //获取用户的银行卡
            'getUserCardList'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'getUserCardList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //设置用户默认银行卡
            'setUserDefaultBank'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'setUserDefaultBank',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //检查培训结果
            'checkQuestionResult'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'checkQuestionResult',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户留言
            'userLeaveMessage'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'userLeaveMessage',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户推广
            'getUserExtension'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'getUserExtension',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户系统消息
            'getUserSystemMessage'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'getUserSystemMessage',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //获取用户是否有留言
            'getUserHaveMessage'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'getUserHaveMessage',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户是否发送短信
            'isSendShortMessage'=>array(
                'path'      => './Application/Api/Controller/User.php', //类的路径
                'objName'   => 'User',//类名
                'function'  => 'isSendShortMessage',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),


//---------------------------------------任务类----------------------------------------------------------


            //所有可以报名的任务列表
            'getTaskList'=>array(
                'path'      => './Application/Api/Controller/Task.php', //类的路径
                'objName'   => 'Task',//类名
                'function'  => 'getTaskList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //待录用（我的工作）
            'getUserPrepareTaskList'=>array(
                'path'      => './Application/Api/Controller/Task.php', //类的路径
                'objName'   => 'Task',//类名
                'function'  => 'getUserPrepareTaskList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //进行中（我的工作）
            'getUserDoingTaskList'=>array(
                'path'      => './Application/Api/Controller/Task.php', //类的路径
                'objName'   => 'Task',//类名
                'function'  => 'getUserDoingTaskList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //全部（我的工作）
            'getUserAllTaskList'=>array(
                'path'      => './Application/Api/Controller/Task.php', //类的路径
                'objName'   => 'Task',//类名
                'function'  => 'getUserAllTaskList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户任务列表
            'getUserTaskList'=>array(
                'path'      => './Application/Api/Controller/Task.php', //类的路径
                'objName'   => 'Task',//类名
                'function'  => 'getUserTaskList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //任务信息
            'getTaskInfo'=>array(
                'path'      => './Application/Api/Controller/Task.php', //类的路径
                'objName'   => 'Task',//类名
                'function'  => 'getTaskInfo',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //报名
            'joinTask'=>array(
                'path'      => './Application/Api/Controller/Task.php', //类的路径
                'objName'   => 'Task',//类名
                'function'  => 'joinTask',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //取消报名
            'cancelTask'=>array(
                'path'      => './Application/Api/Controller/Task.php', //类的路径
                'objName'   => 'Task',//类名
                'function'  => 'cancelTask',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户任务消息
            'getUserTaskMessage'=>array(
                'path'      => './Application/Api/Controller/Task.php', //类的路径
                'objName'   => 'Task',//类名
                'function'  => 'getUserTaskMessage',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户任务消息列表
            'getUserTaskMessageList'=>array(
                'path'      => './Application/Api/Controller/Task.php', //类的路径
                'objName'   => 'Task',//类名
                'function'  => 'getUserTaskMessageList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            //用户任务消息列表
            'getUserNewTaskList'=>array(
                'path'      => './Application/Api/Controller/Task.php', //类的路径
                'objName'   => 'Task',//类名
                'function'  => 'getUserNewTaskList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
//---------------------------------------支付类----------------------------------------------------------
            'aliPay'=>array(
                'path'      => './Application/Api/Controller/PayInterface.php', //类的路径
                'objName'   => 'PayInterface',//类名
                'function'  => 'aliPay',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            'wxPay'=>array(
                'path'      => './Application/Api/Controller/PayInterface.php', //类的路径
                'objName'   => 'PayInterface',//类名
                'function'  => 'wxPay',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
//---------------------------------------结算类----------------------------------------------------------
            'notSettlement'=>array(
                'path'      => './Application/Api/Controller/Settlement.php', //类的路径
                'objName'   => 'Settlement',//类名
                'function'  => 'notSettlement',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            'notSettlementDetail'=>array(
                'path'      => './Application/Api/Controller/Settlement.php', //类的路径
                'objName'   => 'Settlement',//类名
                'function'  => 'notSettlementDetail',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            'notPay'=>array(
                'path'      => './Application/Api/Controller/Settlement.php', //类的路径
                'objName'   => 'Settlement',//类名
                'function'  => 'notPay',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            'notPayDetail'=>array(
                'path'      => './Application/Api/Controller/Settlement.php', //类的路径
                'objName'   => 'Settlement',//类名
                'function'  => 'notPayDetail',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            'arrivedAccountList'=>array(
                'path'      => './Application/Api/Controller/Settlement.php', //类的路径
                'objName'   => 'Settlement',//类名
                'function'  => 'arrivedAccountList',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
            'arrivedAccountDetail'=>array(
                'path'      => './Application/Api/Controller/Settlement.php', //类的路径
                'objName'   => 'Settlement',//类名
                'function'  => 'arrivedAccountDetail',//方法名，如果没有则默认为key
                'type'      => 2,//type为1表示公用接口不需要验证，2则要用userId查找user表中的key进行对比，默认为2
            ),
        ),
    ),


    //设备类型
    'DEVICE_TYPE' => array('web', 'android','ios'),


);