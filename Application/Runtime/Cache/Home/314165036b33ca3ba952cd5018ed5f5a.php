<?php if (!defined('THINK_PATH')) exit();?><link rel="stylesheet" type="text/css" href="/Public/css/home/accessnode/access.css" />
    <div>
       
        <input type="hidden" name="roleNodeStr" value="<?=rtrim(implode(',',$roleNodeArr),',')?>"/>
         <table id="tb<?php echo $value['id'] ?>" class="mytab" style="margin-top:20px;" >
         	<tr>
            	<th>选择使用菜单</th>
                <th>&nbsp;&nbsp;&nbsp;&nbsp;选择配置</th>
            </tr>
         </table>
        <?php foreach($list[0] as $value){?>
        <table id="tb<?php echo $value['id'] ?>" class="mytab" >
            <tr>
                <td>
                 <input type="checkbox" onclick="change('<?=$value['id']?>')"  name ="select_node[]" value="<?=$value['id']?>" <?php if(in_array($value['id'],$roleNodeArr)){ echo 'checked';}?> id="<?=$value['id']?>"  class="checkboxstyle" />
                 <label class="checklabelstyle" for="<?=$value['id']?>"></label><?=$value['name']?>
                </td>
               
                    <?php foreach($list[$value['id']] as $val){?>
					<td>
                    <input type="checkbox"  name ="select_node[]" value="<?=$val['id']?>" onclick="childchange()" <?php if(in_array($val['id'],$roleNodeArr)){ echo 'checked';}?> id="<?=$val['id']?>"  class="checkboxstyle" />
                 <label class="checklabelstyle" for="<?=$val['id']?>" ></label><?=$val['name']?>
                    <?php if($list[$val['id']]){ foreach($list[$val['id']] as $v) {?>
                    <input type="checkbox"  name ="select_node[]" value="<?=$v['id']?>" <?php if(in_array($v['id'],$roleNodeArr)){ echo 'checked';}?> id="<?=$v['id']?>"  class="checkboxstyle" />
                 <label class="checklabelstyle" for="<?=$v['id']?>"></label><?=$v['name']?>
                    <?php }}?>
					</td>
                    <?php }?>
            </tr>
        </table>

        <?php }?>
    </div>
<script>  
    function change(id){
		var childlabel = $("table#tb"+id+" td:first-child").nextAll().find(".checklabelstyle");
        if($("table input#"+id).is(":checked")){
			childlabel.each(function(){
				var labelid = $(this).attr('for');
				if($("input#"+labelid).is(":checked")){
					$(this).css("background","url('/Public/images/common/checkBox_checked.png')");
				}else{
					$(this).css("background","url('/Public/images/common/checkBox_unchecked.png')");
				}
			});
			$("table#tb"+id+" td:first-child").nextAll().find("input").removeAttr('disabled');
        }else{
			childlabel.each(function(){
				var labelid = $(this).attr('for');
				if($("input#"+labelid).is(":checked")){
					$(this).css("background","url('/Public/images/common/checkBox_disable1.png')");
				}else{
					$(this).css("background","url('/Public/images/common/checkBox_disable2.png')");
				}
			});
			$("table#tb"+id+" td:first-child").nextAll().find("input").attr('disabled','true');
        }
    }
	function childchange(){
	   $(".checklabelstyle").css("background","url('/Public/images/common/checkBox_unchecked.png')");
       $(".checkboxstyle:checked+.checklabelstyle").css("background","url('/Public/images/common/checkBox_checked.png')");
	}
	
</script>