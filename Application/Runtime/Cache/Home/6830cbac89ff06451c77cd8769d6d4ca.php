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

    <link href="/Public/css/Home/task/index.css" rel='stylesheet' type='text/css'/>



    <script src="/Public/js/home/user/index.js" type="text/javascript"></script>

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
        <div>用户管理>用户列表</div>
    </div>
    <?php foreach($userTabList as $key=>$value){ $tableNames .= $value['id'].','?>
    <div  class="task-title-div tab-div" id="task-title-id-<?=$value['id']?>" onclick="activeThis(this);changeTabDiv('tab-div-pan-<?=$value['id']?>')">
        <div class="status-title status <?php if($value['checked']==1){ echo 'active';}?>"><font><?=$value['name']?></font></div>
        <div class="lab">
            <img src="/Public/images/user/<?=$value['img']?>">
            <span id="count_user_<?=$value['id']?>"></span><font>人</font>
        </div>
    </div>
    <?php }?>
    <input type="hidden" name="tableNames" id="tableNames" value="<?=rtrim($tableNames,',')?>"/>

    <div class="table-list">
        <div class="main-content ">
            <?php foreach($userTabList as $key=>$value){?>
            <div class="tab-div-pan <?php if($value['checked']==1){ echo 'active-pan';}?>" id="tab-div-pan-<?=$value['id']?>"  >
                <div class="form-inline" id="button-<?=$value['id']?>">
                    <select data-width="150" class="selectpicker form-inline" name="" id="join_status_<?=$value['id']?>" class="form-control">
                        <option value="1,2">全部名单</option>
                        <option value="1">未参加过任务</option>
                    </select>
                    &nbsp;&nbsp;<label>注册时间:</label>
                    <input type="text" class="Wdate form-control" id="start_time_<?=$value['id']?>" name="start_time" value="" style="height: 32px;width: 155px;display: inline-flex" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"/>
                    --<input type="text" class="Wdate form-control" id="end_time_<?=$value['id']?>" name="start_time" value="" style="height: 32px;width: 155px;display: inline-flex" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"/>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <select data-width="150"name="" class="selectpicker form-inline" id="selectList_<?=$value['id']?>" class="form-control">
                        <option value="username">姓名</option>
                        <option value="card_num">身份证号</option>
                        <option value="age">年龄</option>
                        <option value="sex">性别</option>
                        <option value="education">学历</option>
                    </select>
                    &nbsp;&nbsp;
                    <input type="text" name="keyWord" id="keyWord_<?=$value['id']?>" class="form-control"  value="" placeholder="输入关键字词查询" style="width: auto">

                    <input class="ic-query" type="button" onclick="tableRefresh('<?=$value['id']?>')"/>
                    <input class="ic-reset" type="button" onclick="resetButton('<?=$value['id']?>')"/>
                </div>


                <div id="task-list-new-<?=$value['id']?>" class="form-inline">
                    <span class="span-title"><?=$value['name']?>列表</span>
                    <button class="common-button" onclick="exportUser('<?=$value['id']?>')">&nbsp;<img src="/Public/images/common/ic_download.png">&nbsp;&nbsp;&nbsp;导出用户名单</button>
                </div>
                <table id="<?=$value['id'].'Tab'?>" data-toggle="table">

                </table>
            </div>
            <?php }?>
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