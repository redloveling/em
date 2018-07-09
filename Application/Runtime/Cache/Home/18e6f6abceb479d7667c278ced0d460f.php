<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/css/left.css" rel='stylesheet' type='text/css'/>

<div class="right-top-div">
    <span>EM后台管理系统</span>
    <div style="float: right">
        <a href="javascript:void(0)" ><img src="/Public/images/common/ic_admin.png" style="vertical-align:bottom;">&nbsp;<?=$user_info['username']?></a>
        <a href="#" onclick='modifyPassword()'><img src="/Public/images/common/ic_password.png" style="vertical-align:bottom;">&nbsp;修改密码</a>
        <a href="#" onclick='window.location.href="<?php echo U('Home/Public/loginOut/');?>"'><img src="/Public/images/common/ic_logout.png" style="vertical-align:bottom;">&nbsp;退出</a>
    </div>
</div>