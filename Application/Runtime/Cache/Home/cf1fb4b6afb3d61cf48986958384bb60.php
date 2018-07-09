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
                        <form id="formId" method="post" name='formId' action='<?php echo U("Config/edit");?>'>
                            <input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>"/>
                            <input type="hidden" name="tableName" value="<?php echo ($tableName); ?>"/>
                            <div class="form-group">
                                <label>名称</label>
                                <input type="text" name="name" value="<?php echo ($vo["name"]); ?>" class="form-control">
                            </div>
                            <?php if($tableName=='tb_work_area'){?>
                            <div class="form-group">
                                <label>所属层级</label>
                                <div>
                                    <?php $workAreaLevel = C('work_area_level');?>
                                    <?php foreach($workAreaLevel as $value){?>
                                    <label class="checkbox-inline">
                                        <input type="radio" name="type" id="inlineCheckbox<?=$value['id']?>" <?php if($value['id']==$vo['type']){echo 'checked="true"';}?>value="<?=$value['id']?>"><?=$value['name']?>
                                    </label>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>所属省份</label>
                                <!--<?php echo W('ConfigSelect/Index',array('tb_work_area','pid',0,array('pid'=>0)));?>-->

                                <?php echo W('ConfigSelect/Index',array('tb_work_area','province',$vo['pid'],array('type'=>1)));?>

                            </div>
                            <div class="form-group">
                                <label>所属城市</label>
                                <!--<?php echo W('ConfigSelect/Index',array('tb_work_area','pid',0,array('pid'=>0)));?>-->

                                <?php echo W('ConfigSelect/Index',array('tb_work_area','city',$vo['pid'],array('type'=>2)));?>

                            </div>
                            <?php }?>

                            <div class="form-group">
                                <label>描述</label>
                                 <textarea name="description"  rows="3" class="form-control"><?php echo ($vo["description"]); ?></textarea>
                            </div>


                        </form>
                    </div>
                </div>
                <br>
                <button class="ok-btn center-block" onclick="fromSubmit('formId','<?=$tableName?>Tab')"></button>
            </div>
    </div>



</body>