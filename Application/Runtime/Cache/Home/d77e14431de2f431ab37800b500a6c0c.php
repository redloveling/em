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


    <link rel="stylesheet" type="text/css" href="/Public/css/Home/task/usertask.css">


    <script type="application/javascript" src="/Public/js/Home/usertask/doinglist.js"></script>
    <script type="application/javascript" src="/Public/js/Home/usertask/usertask.js"></script>

<script src="/Public/js/bootstrap-table.min.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-zh-CN.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-export.js" type="text/javascript"></script>

<body>

    
    <div class="div-pan" >
            <input type="hidden" name="taskId" id="taskId" value="<?=$taskId?>"/>
        <?php echo W('Task/taskHeader',array($taskId));?>

        <div id="myTabContent" class="tab-content">
            <div class="tab-div-pan" >
            <div class="form-inline" class="search-tool" id="search-tool">

                <select data-width="150" class="selectpicker form-inline" name="" id="status" class="form-control">
                    <option value="2,3">全部名单</option>
                    <option value="3">报名成功</option>
                    <option value="2">报名失败</option>
                </select>
                &nbsp;&nbsp;<label>报名时间:</label>
                <input type="text" class="Wdate form-control" id="start_time" name="start_time" value="" style="height: 32px;width: 150px;display: inline-flex" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"/>
                --<input type="text" class="Wdate form-control" id="end_time" name="start_time" value="" style="height: 32px;width: 150px;display: inline-flex" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"/>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <select data-width="150"name="" class="selectpicker form-inline" id="selectList" class="form-control">
                    <option value="username">姓名</option>
                    <option value="card_num">身份证号</option>
                    <option value="age">年龄</option>
                    <option value="sex">性别</option>
                    <option value="education">学历</option>
                </select>
                &nbsp;&nbsp;
                <input type="text" name="keyWord" id="keyWord" class="form-control"  value="" placeholder="输入关键字词查询" style="width: auto">

                <input class="ic-query" type="button" onclick="tableRefresh('tab')"/>
                <input class="ic-reset" type="button" onclick="resetButton('2,3')"/>
            </div>
            <div style="height: 20px;border-bottom: 1px dashed #dfdfdf"></div>
            <div id="toolbar">
                <button onclick="userTaskExport('userTaskDoingList')" type="button" class="common-button export-button-large">导出报名名单</button>
                <button onclick="denyDoing()" type="button" class="common-button del-button">拒绝</button>
            </div>
            <table id="tab" data-toggle="table">

            </table>
            </div>
        </div>
    </div>



</body>