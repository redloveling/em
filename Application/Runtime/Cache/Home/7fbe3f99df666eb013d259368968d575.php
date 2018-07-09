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



<script src="/Public/js/bootstrap-table.min.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-zh-CN.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-export.js" type="text/javascript"></script>

<body>

    

    <div class="">
            <div class="col-md-2">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="home">
                        <form id="formId" method="post" name='formId' action='<?php echo U("Home/Extension/editChannel");?>'>
                            <input type="hidden" name="cId" value="<?=$vo['id']?>"/>
                            <div class="form-group" style="margin-top:15px;">
                                <label>渠道商名称</label>
                                <input type="text" name="name" value="<?=$vo['name']?>"  class="form-control">
                            </div>
                            <div class="form-group">
                                <label>渠道账号</label>
                                <input type="text" name="username" value="<?=$vo['username']?>" readonly="true" class="form-control" placeholder="一经注册，不能更改">
                            </div>
                            <div class="form-group">
								<input type="checkbox" onclick="var p = $('#password');if(p.is(':hidden')){p.show();}else{p.hide()}"  name ="isModify" value="1"  id="isModify"  class="checkboxstyle" /><label class="checklabelstyle" for="isModify" style="float: left; margin-right:10px; margin-top:2px; margin-bottom:10px;"></label>修改密码
                                <input type="password" name="password" value="" id="password" class="form-control" style="display: none">
                            </div>
                            <div class="form-group">
                                <label>手机号码</label>
                                <input type="text" name="tell" value="<?=$vo['tell']?>" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label>状态</label>
                                <span class="form-control">
                                <label style="width: 100px"><input type="radio" name="status" value="1" <?php if($vo['status']==1){echo 'checked="true"';}?>/>正常</label>
                                <label><input type="radio" name="status" value="0" <?php if($nodeInfo['status']==0){echo 'checked="true"';}?>/>禁用</label>
                                </span>
                            </div>

                        </form>
                    </div>


                </div>

                <button class="ok-btn center-block" onclick="fromSubmit('formId','channelTab')"></button>
        </div>
    </div>



</body>