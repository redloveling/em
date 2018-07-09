<?php if (!defined('THINK_PATH')) exit();?><div>
<?php if($thirdList){?>
    <select class="selectpicker form-inline" name="thirdList" id="thirdList" class="form-control" data-width="130"data-live-search="true">

        <option value="0">--请选择--</option>
        <?php if(is_array($thirdList)): foreach($thirdList as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id']==$nodeInfo['id']){ echo 'selected="selected"'; }?>> <?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
    </select>
<?php }else{ ?>
    <select class="selectpicker form-inline" name="firstNode" id="firstNode" class="form-control" data-live-search="true">

    <option value="0">--请选择--</option>
    <?php if(is_array($nodeList)): foreach($nodeList as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id']==$nodeInfo['pid']){ echo 'selected="selected"'; }?>> <?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
</select>
    <!--<select class="selectpicker form-inline" name="secondNode" id="secondNode" class="form-control" data-width="140"data-live-search="true">-->

    <!--<option value="0">--请选择--</option>-->
    <!--<?php if(is_array($secondList)): foreach($secondList as $key=>$vo): ?>-->
        <!--<option value="<?php echo ($vo["id"]); ?>" <?php if($vo['pid']==$nodeInfo['id']){ echo 'selected="selected"'; }?>> <?php echo ($vo["name"]); ?></option>-->
    <!--<?php endforeach; endif; ?>-->
    </select>
<?php }?>
</div>
<script>
    $(function(){
//        getSecondNode();
    })
    function getSecondNode(){
        var val = $('#firstNode').val();
        //$("#secondNode option[index!='0']").remove(); //删除Select
        $.ajax({
            url:'<?php echo U("Home/Ajax/getChildNode");?>',
            data:{nodeId:val},
            type:'post',
            success:function(data){
                if(data){
                    for(var i=0;i<data.length;i++){
                        var myOption = '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                        $("#secondNode").append(myOption);
                    }
                }else{
                    var myOption = '<option value="0">--请选择--</option>';
                    $("#secondNode").append(myOption);
                }
            }
        })
    }
</script>