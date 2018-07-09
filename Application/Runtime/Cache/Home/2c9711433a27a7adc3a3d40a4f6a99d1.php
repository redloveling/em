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



    <script src="/Public/js/home/config/index.js" type="text/javascript"></script>

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
        <div>用户管理>后台配置</div>
    </div>

    <div class="table-list">
        <div class="main-content ">
            <input type="hidden" name="tableName" id="tableName" value="tb_bank"/>
            <ul id="tab" class="nav nav-tabs">
                <?php foreach($configList as $key=>$value){ $tableNames .= $value['table'].','?>

                <li class="<?php if($key==0){ echo 'active';}?>">
                    <a  href="#<?=$value['table']?>" onclick="showTab('<?=$value['table']?>')" data-toggle="tab"><?=$value['name']?></a>
                </li>
                <?php }?>

            </ul>
            <input type="hidden" name="tableNames" id="tableNames" value="<?=rtrim($tableNames)?>"/>
            <div style="margin-left: 10px;" id="myTabContent" class="tab-content">
                <?php foreach($configList as $key=>$value){?>
                <div class="tab-pane fade in <?php if($key==0){ echo 'active';}?>" id="<?=$value['table']?>">
                    <div class="layui-tab-item layui-show">
                        <div class="main-content">
                            <div class="web_user_table" style="margin-top: 0px">
                                <div class="button" id="button-<?=$value['table']?>" >
                                    <button onclick="configAdd('<?=$value['table']?>')" type="button" class="common-button add-button">新增</button>
                                    <?php if(!in_array($value['table'],array('message_template'))){?>
                                    <button onclick="configForbidden('<?=$value['table']?>')" type="button" class="common-button forbidden-button">禁用</button>
                                    <button onclick="configEnable('<?=$value['table']?>')" type="button" class="common-button pass-button">启用</button>
                                    <button onclick="configDelete('<?=$value['table']?>')" type="button" class="common-button del-button">删除</button>
                                    <?php }?>
                                </div>
                            </div>
                            <table id="<?=$value['table'].'Tab'?>" data-toggle="table">

                            </table>
                        </div>
                    </div>
                </div>
                <?php }?>
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