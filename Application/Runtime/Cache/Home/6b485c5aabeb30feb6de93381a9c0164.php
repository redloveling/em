<?php if (!defined('THINK_PATH')) exit();?><div >
    <select class="selectpicker form-inline" <?php if($disabled){ echo 'disabled="disabled"';}?> name="message_type" id="message_type" class="form-control" data-live-search="true">>
        <?php foreach($list as $key=>$value){?>
        <option value="<?=$key?>" <?php if($key==$selected){echo 'selected="true"';}?>><?=$value?></option>
        <?php }?>
    </select>

</div>