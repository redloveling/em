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


    <link rel="stylesheet" type="text/css" href="/Public/css/Home/widget/taskdetail.css">


    <script src="/Public/extend/ckeditor/ckeditor.js"></script>
    <script src="/Public/extend/clipboard.min.js"></script>

<script src="/Public/js/bootstrap-table.min.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-zh-CN.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-export.js" type="text/javascript"></script>

<body>

    
    <div>
        <div class="task-detail" style="border-top:1px solid #99cde1; ">
            <div style="margin-top: 2px;margin-bottom: -10px">
                <a href="javascript:void(0)"  id="copy-button" data-clipboard-text="<?=$copyContent?>" style="color:#009ACD;font-weight: normal; margin-left: 700px">复制链接</a>
                <!--<button class="btn" data-clipboard-action="copy" data-clipboard-target="div">Copy</button>-->
            </div>
            <div class="left">
                <div class="table-div-title">
                    <img src="/Public/images/common/img_point1.png"/> <font>任务基本信息</font>
                </div>
                <table>
                    <tr>
                        <td class="text-right">任务/职务标题：</td>
                        <td><?=$vo['title']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">任务难度：</td>
                        <td><?=$vo['task_type_name']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">招聘人数：</td>
                        <td><?=$vo['person_num']?>，<?=$vo['person_type_name']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">报名截止时间：</td>
                        <td><?=$vo['deadline']?date('Y-m-d H:i',$vo['deadline']):''?></td>
                    </tr>
                </table>
            </div>
            <div class="right">
                <div class="table-div-title">
                    <img src="/Public/images/common/img_point1.png"/> <font>工资结算</font>
                </div>
                <table>
                    <tr>
                        <td class="text-right">工资：</td>
                        <td><?=$vo['wages_type_name']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">结算方式：</td>
                        <td><?=$vo['settlement_type_name']?></td>
                    </tr>

                </table>
            </div>

        </div>
        <div class="task-detail">
            <div class="left">
                <div class="table-div-title">
                    <img src="/Public/images/common/img_point1.png"/> <font>工作描述</font>
                </div>
                <table>
                    <tr>
                        <td class="text-right">工作时间描述：</td>
                        <td><?=$vo['work_time_description']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">工作时间：</td>
                        <td><?=date('Y-m-d H:i',$vo['start_time'])?> - <?=date('Y-m-d H:i',$vo['end_time'])?></td>
                    </tr>
                    <tr>
                        <td class="text-right">工作区域：</td>
                        <td><?=$vo['work_area']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">详细地址：</td>
                        <td><?=$vo['place_description']?></td>
                    </tr>
                </table>
            </div>
            <div class="right">
                <div class="table-div-title">
                    <img src="/Public/images/common/img_point1.png"/> <font>联系方式</font>
                </div>
                <table>
                    <tr>
                        <td class="text-right">联系人：</td>
                        <td><?=$vo['contact']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">联系电话：</td>
                        <td><?=$vo['contact_tell']?></td>
                    </tr>
                    <tr>
                        <td class="text-right">咨询QQ：</td>
                        <td><?=$vo['qq']?></td>
                    </tr>
                </table>
            </div>

        </div>
        <div class="table-div-title">
            <img src="/Public/images/common/img_point1.png"/> <font>岗位描述</font>
        </div>
        <label style="margin-left: 30px">
                     <textarea readonly name="editor1" id="editor1" rows="10" cols="80">
                         <?=$vo['work_description']?>
                    </textarea>
        </label>
        <script>
            CKEDITOR.replace('editor1', {
                //skin : 'moono-lisa',   //'kama', 'v2', 'office2003'
                toolbarCanCollapse: true,
                toolbarStartupExpanded: false,
                height: 200,
                width: 600
            });
            //CKEDITOR.replace('editor1', { toolbarCanCollapse: true, toolbarStartupExpanded: false, toolbar: [['Smiley']], height: '200px', width: '552px' });

        </script>

    </div>
    <script>

        var clipboard = new Clipboard('#copy-button');
        clipboard.on('success', function(e) {
            layer.msg('复制成功',{time:1000})
        });
    </script>



</body>