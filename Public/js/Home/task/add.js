/**
 * Created by Red on 2016/11/11.
 */
$(document).ready(function() {
    $(".task-difficult").click(function () {
        $(".task-difficult").removeClass("task-difficult-active");
        var oldClass =$(this).attr('class');
        var dataValue = $(this).attr('data-value');
        $('#task_type').val(dataValue)
        $(this).attr('class',oldClass+' task-difficult-active')
    });
    $(".sex-limit").click(function () {
        $(".sex-limit").removeClass("sex-limit-active");
        var oldClass =$(this).attr('class');
        var dataValue = $(this).attr('data-value');
        $('#person_type').val(dataValue)
        $(this).attr('class',oldClass+' sex-limit-active')
    });
    $(".wage-list").click(function () {
        $(".wage-list").removeClass("wage-list-active");
        var oldClass =$(this).attr('class');
        var dataValue = $(this).attr('data-value');
        $('#wages_type').val(dataValue)
        $(this).attr('class',oldClass+' wage-list-active')
    });
})
function beforeASubmit(tab){
    if($('#title').val().length>25){
        layer.msg('任务/职位标题:最多25个汉字',{time:1000});
        return
    }
    var re = /^[0-9]+.?[0-9]*$/;
    if (!re.test($('#wages').val())){

        layer.msg('请输入正确的工资',{time:1000});
        return
    }
    if($('#wages').val()>9999){
        layer.msg('工资不能超过9999',{time:1000});
        return
    }
    if($('#deadline').val()==''){
        layer.msg('请输入报名报名截止时间',{time:1000});
        return
    }
    if($('#work_time_description').val().length>25){
        layer.msg('工作时间描述:最多50个字符',{time:1000});
        return
    }
    if($('#contact').val().length>25){
        layer.msg('联系人:最多25个字符',{time:1000});
        return
    }
    var re = /^[0-9-]{5,20}$/
    if(!re.test($('#contact_tell').val())){
        layer.msg('请输入正确的联系电话',{time:1000});
        return
    }
    if($('#qq').val().length>11){
        layer.msg('请填写正确的QQ号码',{time:1000});
        return
    }

    var first = $("#firstArea").find("option:selected").text();
    var second = $("#secondArea").find("option:selected").text();
    var third = $("#thirdArea").find("option:selected").text();

    $('#firstAreaName').val(first);
    $('#secondAreaName').val(second);
    $('#thirdAreaName').val(third);

    taskSubmit('formId',tab);
}
function taskSubmit(fromId,tab){
    var url=document.getElementById(fromId).action
    var work_description = CKEDITOR.instances.editor1.getData();
    //console.log(work_description)
    $.ajax({
        type: "post",
        url:url,
        cache:false,
        async:false,
        data:$('#'+fromId).serialize()+'&work_description='+work_description,
        success: function(data){
            try{
                var res=eval('('+data+')') ;
                layer.msg(res.msg,{time:1000});
                if(res.status==1) {
                    // parent.window.location.reload();
                    // var index = parent.layer.getFrameIndex(window.name);
                    // layer.close(index);
                    if(tab){
                        parent.window.location.reload();
                        var index = parent.layer.getFrameIndex(window.name);
                        layer.close(index);
                    }else{
                        window.location.href='/index.php' + '/Task/index/'
                    }
                }
            }catch (e){
                layer.msg(data,{time:1000});
            }
        }
    });
}