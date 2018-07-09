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


    <link href="/Public/css/Home/question/add.css" rel='stylesheet' type='text/css'/>


<script src="/Public/js/bootstrap-table.min.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-zh-CN.js" type="text/javascript"></script>
<script src="/Public/js/bootstrap-table-export.js" type="text/javascript"></script>

<body>

    
    <div class="">
        <div class="col-md-2">
            <div id="myTabContent" class="tab-content">

                <form class="" id="formId" method="post" name='formId' action='<?php echo U("Question/edit");?>'>
                    <input type="hidden" name="id" value="<?=$vo['id']?>"/>

                    <div class="form-group" style="padding-top: 10px">
                        <img src="/Public/images/common/img_point1.png"/><label> &nbsp;选择题类型</label>
                        <?php $questionType= C('question_type');?>
                        <br/>
                        <?php foreach($questionType as $key=>$value){?>
                        <input type="button" class="question-btn <?=$vo['type']==$key?'question-btn-active':''?>"
                               id="question_<?=$key?>" onclick="changeQuestion(this)" value="<?=$value['name']?>"/>

                        <?php }?>
                        <input type="hidden" id="question_type" name="question_type" value="<?=$vo['type']?>"/>
                    </div>
                    <div class="form-group">
                        <img src="/Public/images/common/img_point1.png"/><label> &nbsp;标题</label>
                        <input style="width: 85%" type="text" class="form-control" id="title" name="title" value="<?=$vo['title']?>"/>
                    </div>
                    <div class="form-group">
                        <img src="/Public/images/common/img_point1.png"/><label> &nbsp;选项设置</label>
                        <input type="hidden" id="optionCount" value="<?=count($vo['content_name'])?>"/>
                        <input type="hidden" id="optionNum" name="optionNum" value="<?=count($vo['content_name'])?>"/>
                        <?php $i =1;foreach($vo['content_name'] as $k=>$val){?>
                        <div style="margin-top: 0px" class="row" id="questionDiv_<?=$i?>">
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    	<input type="checkbox"  name ="isChoose_<?=$i?>" value="1" <?php if($vo['answer_name'][$k]){ echo 'checked="true"';}?> id="<?=$i?>"  class="checkboxstyle" />
                                        <label class="checklabelstyle" for="<?=$i?>"></label>
                                    </span>
                                    <input type="text" name="options_<?=$i?>" value="<?=$val?>" style="width: 85%" class="form-control">
                                    <input style="margin-left: 5px" type="button" value="+"  class="add-option" onclick="addOption()">
                                    <?php if($i!=1){?>
                                    <input style="margin-left: 5px" type="button" value="-"  class="del-option" onclick="delOption('questionDiv_<?=$i?>')">
                                    <?php }?>
                                </div>

                            </div>
                        </div>
                        <?php $i++;}?>
                        <div id="questionSpan"></div>
                    </div>

                </form>

                <div class="form-inline" align="center" >
                    <button class="ok-btn"  onclick="fromSubmit('formId','questionTab',questionSubmitCheck)"></button>
                    <button class="cancel-btn" onclick="closeLayer()"></button>
                </div>
            </div>
            <div id="questionTemp" style="display: none">
                <div class="row" id="questionDiv">
                    <div class="col-lg-6">
                        <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox"  name ="isChoose" value="1"  id="qtemp" class="checkboxstyle" />
                                        <label class="checklabelstyle" for="qtemp"></label>
                                </span>
                            <input type="text" name="options" style="width: 85%" class="form-control">
                            <input style="margin-left: 5px" type="button" value="+"  class="add-option" onclick="addOption()">
                            <input style="margin-left: 5px" type="button" value="－"  class="del-option" onclick="delOption('questionDiv')">
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function changeQuestion(dom) {
                    for (var i = 0; i < 5; i++) {
                        $('#question_' + i).attr('class', 'question-btn')
                    }

                    $('#' + dom.id).attr('class', 'question-btn question-btn-active')
                    var q_id = dom.id.substr(9,1);
                    if(q_id==0){
                        for (var i = 2; i < 15; i++) {
                            $('#questionDiv_' + i).remove()
                        }
                    }
                    $('#question_type').val(q_id);
                }

                function addOption(){
                    if($('#question_type').val()==0){
                        layer.msg('亲，填空题只有一个答案哟！',{time:1000})
                        return
                    }
                    var html = $('#questionTemp').html();
                    var count = $('#optionCount').val();
                    var num = $('#optionNum').val();
                    count++;num++;
                    html = html.replace(/questionDiv/g, "questionDiv_"+num);
                    html = html.replace(/options/g, "options_"+num);
                    html = html.replace(/isChoose/g, "isChoose_"+num);
					html = html.replace(/qtemp/g, num);
                    $('#optionCount').val(count)
                    $('#optionNum').val(num)
                    $('#questionSpan').before(html)
                }
                function delOption(dom){
                    var count = $('#optionCount').val();
                    count-=1;
                    $('#optionCount').val(count)
                    $('#' + dom).remove()
                }
                function questionSubmitCheck(){
                    if($('#title').val()==''){
                        layer.msg('请填写标题',{time:1000})
                        return false
                    }
					var subBoxChecked = $("input[type='checkbox']:checked").length;
                    if($('#question_type').val()==2 && subBoxChecked>1){
                        layer.msg('亲，单选题只有一个答案哟！',{time:1000})
                        return false
                    }
                    return true
                }
				function checkOwnItem(dom){
					var checkname = dom.name;
					var subBox = $("input[name='"+checkname+"']").length;
					var subBoxChecked = $("input[name='"+checkname+"']:checked").length;
					$('#optionCount').val(subBoxChecked);
					if(subBox==subBoxChecked){
						$("#"+checkname).each(function(){
							$(this)[0].checked=true;
						})
					}else{
						$("#"+checkname).each(function(){
							$(this)[0].checked=false;
						})
					}
					
				}
            </script>
        </div>



</body>