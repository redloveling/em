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

    <link href="/Public/css/Home/banner/index.css" rel='stylesheet' type='text/css'/>



    <script src="/Public/js/home/banner/index.js" type="text/javascript"></script>

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
        <div>Banner管理</div>
    </div>
    <div class="table-div">
        <div class="table-div-content" style="margin-bottom: -20px">
            <div class="form-inline" >
                <button class="common-button add-button-large" onclick="addBanner();">Banner添加</button>
                <button style="margin-left: 450px" class="common-button pass-button" onclick="fromSubmit('formId','',confirmBanner);">确定</button>
            </div>
        </div>
    </div>
    <form id="formId" method="post" name='formId' action='<?php echo U("Home/Banner/index");?>'>

    <?php foreach($bannerList as $key=>$value){?>
    <div id="bannerImage<?=$key+1?>" class="table-div banner<?=$value['id']?>" >
         <div class="table-div-content">
            <!--{:W('fileUpload/bannerUpload',array('bannerImage'))}-->

            <?php echo W('fileUpload/bannerUpload',array($value['name']?$value['name']:'bannerImage1'));?>

             <div class="form-inline" style="margin-bottom: 10px">
             <label style="font-weight: bold;font-size:14px;">Banner详情</label> &nbsp;&nbsp;
             <label><input type="radio" name="type_<?=trim($value['name'],'bannerImage')?>" value="2" title="外部H5地址" <?php if($value['type']==2){echo 'checked';}?>>外部</label>
             <label><input type="radio" name="type_<?=trim($value['name'],'bannerImage')?>" value="1" title="APP内部页面地址" <?php if($value['type']==1){echo 'checked';}?>>内部</label>
            </div>
            <textarea style="width: 55%" class="form-control" name="description_<?=trim($value['name'],'bannerImage')?>" id="description<?=$key+1?>" placeholder="输入地址：外部H5地址或APP内部页面地址" cols="3"><?=$value['description']?></textarea>
        </div>
    </div>
    <?php }?>
    <input type="hidden" id="bannerCount" name="bannerCount" value="<?=count($bannerList)?>"/>
    <input type="hidden" id="bannerMaxId" name="bannerMaxId" value="<?=$maxId?>"/>
    </form>
    <div id="banner_temp" style="display: none;">
    <div  class="table-div">
        <div class="table-div-content">
            <?php echo W('fileUpload/bannerUpload',array('bannerImage'));?>
            <h3 style="font-weight: bold;font-size:14px; margin-bottom:10px;">Banner详情</h3>
            <textarea style="width: 55%"class="form-control" name="description" id="description" placeholder="输入地址：外部H5地址或APP内部页面地址" cols="3"></textarea>
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