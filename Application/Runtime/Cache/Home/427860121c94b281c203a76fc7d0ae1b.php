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

    <link href="/Public/css/Home/task/add.css" rel='stylesheet' type='text/css'/>


    <script src="/Public/js/home/task/add.js" type="text/javascript"></script>
    <script src="/Public/extend/ckeditor/ckeditor.js"></script>


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
        <div>任务管理>新建任务</div>
    </div>
    <form id="formId" method="post" name='formId' action='<?php echo U("Home/Task/add");?>'>
        <div class="table-div">
            <div class="table-div-title">
                <img src="/Public/images/common/img_point1.png"/> <font>任务基本信息</font>
            </div>
            <div class="table-div-content">
                <div class="form-inline">
                    <label class="left" >任务/职位标题:</label>
                    <input style="width: 395px" type="text" id='title' name="title" class="form-control"  placeholder="">
                    <label class="right" >*最多输入25个汉字</label>
                </div>
                <div class="form-inline">
                    <label class="left task-difficult-label" >任务难度等级:</label>
                    <?php $taskType=C('task_type');foreach($taskType as $value){?>
                        <label class="task-difficult diff-<?=$value['name']?> <?php if($value['checked']){echo 'task-difficult-active';$taskTypeD=$value['id'];}?>" data-value="<?=$value['id']?>"><?=$value['name']?></label>
                    <?php }?>
                    <input type="hidden" id="task_type" name="task_type" value="<?=$taskTypeD?>">
                    <label class="right" style="margin-left: -15px">*1~5,5个难度等级，5级最难</label>
                </div>
                <div class="form-inline">
                    <label class="left task-difficult-label" >招聘人数:</label>
                    <input name="person_num" style="width: 120px;" type="text"  class="form-control input-no-right">
                    <label class="input-right" >人</label>
                    <?php $person_type=C('person_type');foreach($person_type as $key=>$value){?>
                        <label class="sex-limit <?php if($value['checked']){echo 'sex-limit-active';$personTypeD=$value['id'];}?>" style="<?php if($key==2){echo 'margin-left:18px';}?>" data-value="<?=$value['id']?>"><?=$value['name']?></label>
                    <?php }?>
                    <input type="hidden" id="person_type" name="person_type" value="<?=$personTypeD?>">

                </div>
                <div class="form-inline">
                    <label class="left" >报名截止时间:</label>
                    <input type="text" class="Wdate form-control" id="deadline" name="deadline" value="<?php if($vo['deadline']){echo date('Y-m-d H:i');}else{echo date('Y-m-d H:i');}?>" style="height: 34px;width: 155px" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"/>


                </div>
            </div>
        </div>

        <div class="table-div">
            <div class="table-div-title">
                <img src="/Public/images/common/img_point1.png"/> <font>工资结算</font>
            </div>
            <div class="table-div-content">
                <div class="form-inline">
                    <label class="left task-difficult-label" >工资:</label>
                    <input  id="wages" name="wages"style="width: 120px;" type="text" class="form-control input-no-right">
                    <label  class="input-right" >元</label>
                    <?php $wages = C('wages');?>
                    <?php foreach($wages as $key=>$value){?>
                        <label class="wage-list <?php if($value['checked']){ echo 'wage-list-active';$wagesTypeD=$value['id'];}?>" style="<?php if($key==1){echo 'margin-left:18px';}?>" data-value="<?=$value['id']?>"><?=$value['name']?></label>
                    <?php }?>
                    <input type="hidden" id="wages_type" name="wages_type" value="<?=$wagesTypeD?>">

                </div>
                <div class="form-inline">
                    <label class="left" >结算方式:</label>
                    <?php echo W('Config/select',array('tb_settlement','settlement_type',6));?>
                </div>
            </div>
        </div>
        <div class="table-div">
            <div class="table-div-title">
                <img src="/Public/images/common/img_point1.png"/> <font>工作描述</font>
            </div>
            <div class="table-div-content">
                <div class="form-inline">
                    <label class="left" >工作时间描述:</label>
                    <input style="width: 395px" type="text" id='work_time_description' name="work_time_description" class="form-control"  placeholder="">
                    <label class="right" >*最多输入50个字符</label>
                </div>
                <div class="form-inline">
                    <label class="left" >工作时间:</label>
                    <input type="text" class="Wdate form-control" name="start_time" value="<?php if($vo['deadline']){echo date('Y-m-d H:i');}else{echo date('Y-m-d H:i');}?>" style="height: 34px;width: 155px" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"/>
                    --
                    <input type="text" class="Wdate form-control" name="end_time" value="<?php if($vo['deadline']){echo date('Y-m-d H:i');}else{echo date('Y-m-d H:i');}?>" style="height: 34px;width: 155px" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"/>
                </div>

                <?php echo W('Map/index');?>
                <div class="form-inline">
                    <label class="left" >地点描述:</label>
                    <input style="width: 395px" type="text" name="place_description" class="form-control"  placeholder="">
                   <!-- <label class="right" ><img style="cursor: pointer" src="/Public/images/task/ic_gps.png"></label>-->
                </div>
                <div class="form-inline">
                    <label class="left" style="vertical-align:top;">岗位描述:</label>
                    <label>
                     <textarea name="editor1" id="editor1" rows="10" cols="80" >
                    </textarea>
                    </label>
                    <script>
                        // Replace the <textarea id="editor1"> with a CKEditor
                        // instance, using default configuration.
                        CKEDITOR.replace('editor1', {
                            skin : 'moono-lisa',   //'kama', 'v2', 'office2003'
                            height : 200,
                            width : 600
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="table-div">
            <div class="table-div-title">
                <img src="/Public/images/common/img_point1.png"/> <font>联系方式</font>
            </div>
            <div class="table-div-content">
                <div class="form-inline">
                    <label class="left" >联系人:</label>
                    <input  name="contact" type="text" id="contact" class="form-control">
                    <label class="right" >*最多输入25个字符</label>
                </div>
                <div class="form-inline">
                    <label class="left" >联系电话:</label>
                    <input  name="contact_tell" id="contact_tell" type="text" class="form-control">
                </div>
                <div class="form-inline">
                    <label class="left" >咨询QQ:</label>
                    <input  name="qq" type="text"  id="qq" class="form-control">
                </div>
            </div>
        </div>
        <input type="hidden" name="task_status" value="0" id="task_status"/>
        <div class="table-div" style="height:80px;padding-top: 20px;">
            <div id="saveTask" onclick="beforeASubmit();"></div>
            <div id="releaseTask" onclick="$('#task_status').val(1);beforeASubmit();"></div>
        </div>
    </form>

        </div>
    </div>
</div>
 	<div class="copy-right-ss" style=" width:100%; height:70px; overflow:hidden; line-height:70px; margin-top:4px; border-top:1px solid #ddd; text-align:center;">
    <div style=" margin:0px auto;">Copyright &copy; <a href="http://www.sunbirddata.com.cn/" target="_blank" title="神鸟数据" style="color:#3bc0f1">Sunbird</a> All rights reserved.

    </div>
</div>




</body>
</html>