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

    

    <div class="frame-first-div">
            <div class="col-md-2">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="home">
                        <form id="formId" method="post" name='formId' action='<?php echo U("Home/Config/edit");?>'>
                            <input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>"/>
                            <input type="hidden" name="tableName" value="<?=$tableName?>"/>
                            <input type="hidden" name="name" value="1"/>
                            <div class="form-group">
                                <label>消息通知</label>
                                <?php echo W('Config/messageCategorySelect',array($vo['category'],true));?>
                            </div>
                            <div class="form-group">
                                <label>消息类型</label>
                                <?php echo W('Config/messageTypeSelect',array($vo['type'],true));?>
                            </div>
                            <div class="form-group">
                                <label>是否发送短信</label>
                                <span class="form-control">
                                <label style="width: 100px"><input type="radio" name="is_short_message" value="1"  <?php if($vo['is_short_message']==1){ echo 'checked="true"';} ?> onclick="$('#short_message_span').show()">是</label>
                                <label><input type="radio" name="is_short_message" value="0" <?php if($vo['is_short_message']==0){ echo 'checked="true"';} ?> onclick="$('#short_message_span').hide()"/>否</label>
                                </span>
                            </div>
                            <span id="short_message_span" style="<?php if($vo['is_short_message']==0){ echo 'display: none';}?>">
                            <div class="form-group">
                                <label>短信模板code</label>
                                <input type="text" name="template_code" class="form-control" value="<?=$vo['template_code']?>"/>
                            </div>

                            <div class="form-group">
                                <label>短信参数</label>
                                <input name="short_message_params"  class="form-control" value="<?=$vo['short_message_params']?>"/>
                            </div>
                            </span>
                            <div class="form-group">
                                <label>消息提醒文案</label>
                                 <textarea name="message"  rows="2" class="form-control"><?=$vo['message']?></textarea>
                            </div>


                        </form>
                    </div>


                </div>
                <br>
                <button class="ok-btn center-block" onclick="fromSubmit('formId','<?=$tableName?>Tab')"></button>
        </div>
    </div>



</body>