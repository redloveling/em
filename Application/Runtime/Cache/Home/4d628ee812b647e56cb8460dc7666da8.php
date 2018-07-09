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


    <link href="/Public/css/Home/user/deny.css" rel='stylesheet' type='text/css'/>


<script src="/Public/js/bootstrap-table.min.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-zh-CN.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-export.js" type="text/javascript"></script>

<body>

    

    <div class="">
            <div class="col-md-2">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="home">
                        <form id="formId" method="post" name='formId' action='<?php echo U("Home/User/denyPayAudit");?>'>
                            <input type="hidden" name="userId" value="<?=$userId?>"/>
                            <input type="hidden" name="cardId" value="<?=$cardId?>"/>

                            <div class="form-group">
                                <div class="choose-label">错误类型</div>
                                <?php echo W('Config/Select',array('tb_payaudit_refuse_type','refuse_type'));?>
                            </div>
                            <div class="form-group">
                                <div class="choose-label">具体备注</div>
                                 <textarea name="description"  rows="6" class="form-control"></textarea>
                            </div>


                        </form>
                    </div>
					<div class="line"></div>
                   <div class="choose-btn">
                    <button  class="btn btn-primary yes" onclick="fromSubmit('formId','noTab,alreadyTab')"></button>
                    <button class="btn btn-primary no " onclick="var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    parent.layer.close(index); //再执行关闭"></button>
                   </div>
        </div>
    </div>



</body>