<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/css/left.css" rel='stylesheet' type='text/css'/>

<div>
    <img class="logo-img" src="/Public/images/home/logo.png"  >
</div>
<div class="left-div-ul">
    <?php foreach($nodeList[0] as $value){?>
        <ul>
            <?php if($nodeList[$value['id']]){?>
            <li class="first-li"><a href="javascript:void(0)"> <?=$value['name']?>  </a></li>

            <?php foreach($nodeList[$value['id']] as $val){?>

                <li onclick="location='/index.php<?=$val['code']?>'" <?php if($urlInfo['url']==$val['code']){ echo 'class="active"';}?>><img src="/Public/images/common/<?=$val['img']?>"/><a href="javascript:void(0)"> <?=$val['name']?> <span  style="margin-left: 2px" class="label label-danger" id="taskCount_<?=$val['id']?>"></span></a></li>
                <?php }?>
            <?php }else{?>
            <li onclick="location='/index.php/<?=$value['code']?>/index/'" <?php if(strtolower($urlInfo['url'])=='/'.strtolower($value['code']).'/index/'){ echo 'class="active"';}?>><a href="javascript:void(0)" > <img src="/Public/images/common/<?=$value['img']?>"/>&nbsp;<?=$value['name']?> &nbsp;<span class="label label-danger" id="taskCount_<?=$value['id']?>"></span> </a></li>
            <?php }?>
        </ul>
    <?php }?>
</div>