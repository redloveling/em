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



    <script type="application/javascript" src="/Public/js/Home/messagegroup/add.js"></script>

<script src="/Public/js/bootstrap-table.min.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-zh-CN.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-export.js" type="text/javascript"></script>

<body>

    

    <div class="">
        <div class="col-md-2">
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="home">
                    <form id="formId" method="post" name='formId' action='<?php echo U("Home/MessageGroup/add");?>'>
                        <br/>
                        <?php echo W('task/taskChoose');?>
                        <div class="form-group">
                            <img src="/Public/images/common/img_point1.png"/>&nbsp;<label>消息内容</label>
                            <div style="height: 12px"></div>
                            <textarea name="content"  id="content" rows="5" class="form-control" placeholder="在此填写....."></textarea>
                        </div>


                    </form>
                </div>


            </div>
            <input type="hidden" id="callBackFun" value="beforeSubmit"/>
            <div style="margin-top:30px;width:100%;border-bottom:#c7c7c7 1px dashed;"></div>
            <br>
            <div class="form-inline" >
                <button class="ok-btn" onclick="fromSubmit('formId','',beforeSubmit)"></button>
                <button class="cancel-btn " onclick="closeLayer()"></button>

            </div>
        </div>
    </div>



</body>