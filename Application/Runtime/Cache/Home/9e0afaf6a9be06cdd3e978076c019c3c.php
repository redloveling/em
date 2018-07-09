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
<link rel="stylesheet" type="text/css" href="/Public/css/index/stylesheets/theme.css">
<link rel="stylesheet" type="text/css" href="/Public/css/index/stylesheets/premium.css">

<!--js-->
<script type="text/javascript">
    $(function() {
        var uls = $('.sidebar-nav > ul > *').clone();
        uls.addClass('visible-xs');
        $('#main-menu').append(uls.clone());
    });
</script>

    <link href="/Public/css/Home/messagegroup/index.css" rel='stylesheet' type='text/css'/>



    <script src="/Public/js/home/messagegroup/index.js" type="text/javascript"></script>

<script src="/Public/js/bootstrap-table.min.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-zh-CN.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-export.js" type="text/javascript"></script>

<body>


<div class="wrap">
    <div class="left-div">
        <!--左边-->
        <?php echo W('Navigation/left');?>
    </div>
    <div class="right-div" >
        <div class="top-div">
            <?php echo W('Navigation/top');?>
        </div>
        <!--内容-->
        <div class="content">
            
    <div class="title-span">
        <div>群发消息</div>
    </div>
    <div class="table-list">
        <div class="main-content" style="padding-left: 20px">
            <div class="web_user_table">
                <div class="button" id="button">
                    <button id="add" class="message-add-btn"></button>
                </div>
                <table id="mytab" data-toggle="table">
                </table>
            </div>
        </div>
    </div>


        </div>
    </div>
</div>
 	<div class="copy-right-ss" style=" width:100%; height:70px; overflow:hidden; line-height:70px; margin-top:4px; border-top:1px solid #ddd; text-align:center;">
    <div style=" margin:0px auto;">Copyright &copy; <a href="http://www.sunbirddata.com.cn/" target="_blank" title="神鸟数据" style="color:#3bc0f1">Sunbird</a> All rights reserved.

    </div>
</div>




</body>
</html>