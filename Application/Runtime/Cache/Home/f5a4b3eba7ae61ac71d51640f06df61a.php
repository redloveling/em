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


    <link rel="stylesheet" type="text/css" href="/Public/css/Home/widget/userinfo.css">
    <link href="/Public/css/Home/picture/main.css" rel='stylesheet' type='text/css'/>
    <link href="/Public/css/Home/picture/normalize.css" rel='stylesheet' type='text/css'/>
    <link href="/Public/css/Home/picture/viewer.css" rel='stylesheet' type='text/css'/>


    <!--<script type="application/javascript" src="/Public/js/Home/task/index.js"></script>-->
    <script src="/Public/js/home/picture/main.js" type="text/javascript"></script>
    <script src="/Public/js/home/picture/viewer.js" type="text/javascript"></script>

<script src="/Public/js/bootstrap-table.min.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-zh-CN.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-export.js" type="text/javascript"></script>

<body>

    

    <div class="user-info" style="width:1000px; ">
        <div class="register-info">
            <span class="user-title">注册信息</span>
            <div class="table-div-title">
                <img src="/Public/images/common/img_point1.png"/> <font>任务基本信息</font>
            </div>
            <div class="form-inline" >
                <table >
                    <tr>
                        <td class="left">昵称</td>
                        <td class="right"><?=$vo['nick_name']?></td>
                    </tr>
                    <tr>
                        <td class="left">性别</td>
                        <td class="right"><?=$vo['sex_name']?></td>
                    </tr>
                    <tr>
                        <td class="left">出生年月</td>
                        <td class="right"><?=$vo['birthday']?$vo['birthday']:''?></td>
                    </tr>
                </table>
            </div>
            <div class="table-div-title">
                <img src="/Public/images/common/img_point1.png"/> <font>教育经历</font>
            </div>
            <div class="form-inline" >
                <table >
                    <tr>
                        <td class="left">在校/工作</td>
                        <td class="right"><?=$vo['work_status_name']?></td>
                    </tr>
                    <tr>
                        <td class="left">我的学历</td>
                        <td class="right"><?=$vo['education_name']?></td>
                    </tr>

                </table>
            </div>
            <div class="table-div-title">
                <img src="/Public/images/common/img_point1.png"/> <font>工作状况</font>
            </div>
            <div class="form-inline" >
                <table >
                    <tr>
                        <td class="left">交通工具</td>
                        <td class="right"><?=$vo['serialize']['transport']?></td>
                    </tr>
                    <tr>
                        <td class="left">一周空闲几天</td>
                        <td class="right"><?=$vo['serialize']['freeDay']?></td>
                    </tr>

                </table>
            </div>
        </div>
        <div class="id-info">
            <span class="user-title">身份认证</span>

            <div class="form-inline"  >
                <table border="0">
                    <tr>
                        <td class="left">真实姓名</td>
                        <td class="right"><?=$vo['true_name']?></td>
                    </tr>
                    <tr>
                        <td class="left">身份证号</td>
                        <td class="right"><?=$vo['card_num']?></td>
                    </tr>
                    <tr>
                        <td class="left">身份证正面</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="left">
                         <div class="photo-limit-div" style="width:355px; height:152px;">
                            <ul class="docs-pictures clearfix">
                                <li>
                                <img data-original="<?=$vo['card_num_positive']?>" src="<?=$vo['card_num_positive']?>" onerror="this.src='/Public/images/no_image.png'" width="335" height="152">
                                </li>
                            </ul>
                          </div>
                       <!-- <img src="<?=$vo['card_num_positive']?>" onerror="this.src='/Public/images/no_image.png'" width="355" height="152">-->
                        </td>
                    </tr>
                    <tr>
                        <td class="left">身份证背面</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2"class="left">
                        <div class="photo-limit-div" style="width:355px; height:152px;">
                            <ul class="docs-pictures clearfix">
                                <li>
                                <img data-original="<?=$vo['card_num_opposite']?>" src="<?=$vo['card_num_opposite']?>" onerror="this.src='/Public/images/no_image.png'" width="335" height="152">
                                </li>
                            </ul>
                         </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="pay-info">
            <span class="user-title">支付认证</span>
            <?php if($vo['cardList']){foreach($vo['cardList'] as $value){?>
            <div class="form-inline " >
                <table border="0">
                    <tr>
                        <td class="left" width="37%">持卡人</td>
                        <td class="left"><?=$value['owner']?>
                            <?php if($value['is_default']){?>
                                <font style="background-color:mediumseagreen;color: #FFFFFF;margin-left: 85px ">默认</font>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td class="left">卡号</td>
                        <td class="left"><?=$value['card_no']?></td>
                    </tr>
                    <tr>
                        <td class="left">卡类型</td>
                        <td class="left"><?=$value['bank_name']?></td>
                    </tr>
                    <tr>
                        <td class="left">预留手机号</td>
                        <td class="left"><?=$value['reserve_mobile']?></td>
                    </tr>
                    <tr>
                        <td class="left">预留身份证</td>
                        <td class="left"><?=$value['reserve_num']?></td>
                    </tr>
                </table>
                <hr/>
            </div>
            <?php }}?>
        </div>
    </div>



</body>