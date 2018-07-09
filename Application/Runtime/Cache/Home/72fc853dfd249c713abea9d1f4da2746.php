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




    <script src="/Public/js/home/settlement/tasksettlement.js" type="text/javascript"></script>


<script src="/Public/js/bootstrap-table.min.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-zh-CN.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-export.js" type="text/javascript"></script>

<body>

    
    <style>
        #tab tr td{
           text-align: center;
            min-width: 50px;
            height: 36px;
        }
        #title td{
            color: grey;
        }

    </style>
    <div>
        <div class="task-detail" style="border-top:1px solid #99cde1; ">
            <table id="tab" border="1" style="margin: 2px">
                <tr id="title">
                    <td>姓名</td>
                    <td>电话</td>
                    <td>身份证</td>
                    <td>银行卡号</td>
                    <td>银行</td>
                    <?php for($i=1;$i<=$count;$i++){?>
                        <td>单价<?=$i?></td>
                        <td>数量<?=$i?></td>
                        <td>小计<?=$i?></td>
                    <?php }?>
                    <td>奖励</td>
                    <td>扣款</td>
                    <td>提成</td>
                    <td style="width: 100px">实得金额</td>
                    <td>备注</td>
                </tr>
                <?php foreach($list as $value){?>
                <tr>
                    <td><?=$value['username']?></td>
                    <td><?=$value['tell']?></td>
                    <td><?=$value['card_num']?></td>
                    <td><?=$value['bank_num']?></td>
                    <td><?=$value['bank_name']?></td>

                    <?php $arr = $value['serialize']; foreach($arr['price'] as $k=>$v){?>
                    <td><?=$v?></td>
                    <td><?=$arr['count'][$k]?></td>
                    <td><?=$arr['money'][$k]?></td>
                    <?php }?>


                    <td><?=$value['reward']?></td>
                    <td><?=$value['debit']?></td>
                    <td><?=$value['commission']?></td>
                    <td><?=$value['current_money']?></td>
                    <td><input style="height: 36px" type="text" value="<?=$value['remark']?>" onchange="settlementRemark(<?=$value['id']?>,this)"/></td>

                </tr>
                <?php }?>
            </table>
        </div>
    </div>



</body>