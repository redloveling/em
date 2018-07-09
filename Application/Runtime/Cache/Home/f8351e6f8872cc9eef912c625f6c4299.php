<?php if (!defined('THINK_PATH')) exit();?>

    <link href="/Public/css/Home/widget/taskheader.css" rel='stylesheet' type='text/css'/>

<div class="panel panel-default" style="height: 198px">
    <div class="task-header-left">
        <div class="center">
            <label style="font-size: 14px;color: #555555">任务名称:</label>
            <br>
            <label class="task-tile"><?=$vo['title']?></label>
            <label style="font-size: 16px;font-weight: bold;color: #97c646"><?=$vo['status_name']?></label>
        </div>
    </div>

    <div class="task-header-right">
        <div class="deadline">
            <?php if($vo['status']==3 ||$vo['status']==4){?>
                <div class="deadline-content-1" >
                 <label class="title-1"><?=$vo['deadline_title']?></label>
                 <br><br>
                 <label class="title-2"><?=$vo['deadline_time']?></label>
                </div>
            <?php }else{?>
            <div class="deadline-title"><?=$vo['deadline_title']?></div>
            <div class="deadline-content">
                <label class="day"><?=$vo['deadline_day']?></label><label class="day-font">天</label>
                <br>
                <label class="minute"><?=$vo['deadline_minute']?></label><label class="deadline-font">小时</label>
                <label class="minute"><?=$vo['deadline_second']?></label><label class="deadline-font">分钟</label>
            </div>
            <?php }?>
        </div>
    </div>
</div>