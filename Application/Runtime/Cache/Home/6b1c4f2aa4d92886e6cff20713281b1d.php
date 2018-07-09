<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <Link href="/Public<?php echo ($web_icon); ?>" rel="Shortcut Icon">
    <meta content="IE=EmulateIE9" http-equiv="X-UA-Compatible">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta http-equiv="pragma" content="no-cache">-->
    <!--<meta http-equiv="cache-control" content="no-cache">-->
    <meta name="description" content="">
    <meta name="author" content="superredman">
    <title><?php echo ($web_title); ?></title>
    <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/common.css" />

    <link href="/Public/css/bootstrap-table.min.css" rel="stylesheet" type="text/css"/>
    <link href="/Public/layui/css/layui.css" rel="stylesheet" type="text/css"/>
    <link href="/Public/extend/bootstrap-select-1.12.0/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>


    <script type="text/javascript" src="/Public/js/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="/Public/js/jquery.form.js"></script>
    <script type="text/javascript" src="/Public/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="/Public/js/layer-v2.4/layer/layer.js"></script>
    <script src="/Public/layui/layui.js" type="text/javascript"></script>
    <script type="text/javascript" src="/Public/extend/My97DatePicker/WdatePicker.js"></script>
    <script src="/Public/extend/bootstrap-select-1.12.0/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
    
    <script type="text/javascript" src="/Public/js/common.js"></script>
	
</head>


<!--css-->
<link rel="stylesheet" href="/Public/css/index/font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="/Public/css/index/stylesheets/theme.css">
<link rel="stylesheet" type="text/css" href="/Public/css/index/stylesheets/premium.css">


    <link href="/Public/css/Home/widget/usertaskhistory.css" rel='stylesheet' type='text/css'/>


    <script src="/Public/js/home/widget/user/usertaskhistory.js" type="text/javascript"></script>

<script src="/Public/js/bootstrap-table.min.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-zh-CN.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-export.js" type="text/javascript"></script>

<body>

    

        <input type="hidden" name="userId" id="userId" value="<?=$userInfo['id']?>"/>
        <div class="table-div top" >
            <div class="table-div-content" >
                <div style="height: 100%;float: left ;width: 45%;" >
                    <div style="float: left ;width: 40%">
                        <img style="margin-left: 55px" src="<?=$userInfo['avatar_file']?$userInfo['avatar_file']:'/Public/images/common/ic_avator.png'?>" onerror="this.src='/Public/images/common/ic_avator.png'" height="100" width="100">
                        <div style="height: 20px"></div>
                        <button class="common-button user-detail" onclick="getUserInfo(<?=$userInfo['id']?>)">用户详情</button>
                    </div>
                    <div>
                        <ul class="list-unstyled">
                            <li class="task-history-li" ><?=$userInfo['true_name']?>&nbsp;&nbsp;性别：<?=$userInfo['sex_name']?>&nbsp;&nbsp;学历：<?=$userInfo['education_name']?></li>
                            <li class="task-history-li">手机：<?=$userInfo['tell']?></li>
                            <li class="task-history-li" >身份证：<?=$userInfo['card_num']?></li>
                            <li class="task-history-li" >注册时间：<?=$userInfo['reg_time']?date('Y-m-d H:i',$userInfo['reg_time']):''?></li>
                        </ul>
                    </div>
                </div>
                <div class="task-history-left">
                    <img src="/Public/images/common/img_point1.png"/><font>&nbsp;兼职报名任务记录</font>
                    <ul class="list-unstyled" style="margin-top: 15px;margin-left: 10px">
                        <li><font style="line-height: 30px;font-size: 16px;color: #555555;font-weight: bold">报名任务</font>&nbsp;&nbsp;&nbsp;<font style="font-size: 16px;color: #eb6877;font-weight: bold"><?=$userInfo['count']['totalCount']?></font></li>
                        <li><font style="line-height: 30px;font-size: 16px;color: #555555;font-weight: bold">参加任务</font>&nbsp;&nbsp;&nbsp;<font style="font-size: 16px;color: #eb6877;font-weight: bold"><?=$userInfo['count']['joinCount']?></font></li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="table-list" style="margin-left: 10px;width: 98%;">
            <div class="main-content ">
                <div class="tab-div-pan <?php if($value['checked']==1){ echo 'active-pan';}?>" id="tab-div-pan-<?=$value['id']?>"  >


                    <div class="form-inline" style="margin-top: 20px">
                        <span class="span-title">任务历史列表</span>
                    </div>
                    <table id="userTaskHistoryTab" data-toggle="table">

                    </table>
                </div>
            </div>
        </div>




</body>