<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <Link href="/Public<?php echo ($web_icon); ?>" rel="Shortcut Icon">
    <meta content="IE=EmulateIE9" http-equiv="X-UA-Compatible">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta name="description" content="">
    <meta name="author" content="superredman">
    <title><?php echo ($web_title); ?></title>
    <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/bootstrap.css" />

    <script type="text/javascript" src="/Public/js/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="/Public/js/jquery.form.js"></script>


    <link href="/Public/css/public/login1.css" rel='stylesheet' type='text/css'/>

</head>
<body>
<div id="login_left">
    <img src="/Public/images/home/img_login.png">
</div>

<div id="login_right">

    <div id="login_div">
        <div class="login_title">
            <label class="">EM后台管理系统</label>
        </div>
        <div class="col-md-12" id="myTabContent" >
            <form id="login_form" style="margin-top: 20px;margin-left: 7px" action="<?php echo U('Home/Public/login/');?>" method="post">
                <div class="form-group">
                    <label>用户名</label>
                    <input type="text" name="user_name" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label>密&nbsp;&nbsp;码</label>
                    <input type="password" name="password" value="" class="form-control">
                </div>

            </form>
            <div class="col-xs-7">
                <?php if($_GET['error']==1){?>
                <span style="color: #ff0000">用户名或密码错误</span>
                <?php }?>
                <?php if($_GET['error']==2){?>
                <span style="color: #ff0000">该用户已经被禁用</span>
                <?php }?>
            </div>
            <img style="margin-top: 20px;margin-left: 7px" width="268" id="login_submit" src="/Public/images/login/btn_normal.png" onclick="$('#login_form').submit()"/>
        </div>
    </div>
</div>
<div id='footer-div'>
    <p>Copyright &copy; <a href="http://www.sunbirddata.com.cn/" target="_blank" title="神鸟数据" style="color:#3bc0f1">Sunbird</a> All rights reserved.
    </p>
</div>

<script>
    $(document).ready(function(){
        document.onkeydown = function(e){
            var ev = document.all ? window.event : e;
            if(ev.keyCode==13) {
                $('#login_submit').click();
            }
        }
    })
</script>
</body>
</html>