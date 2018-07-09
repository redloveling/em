/**
 * Created by Red on 2016/11/22.
 */
function beforeSubmit(){

    var task_user = $('#task-user-input').val();
    if (task_user==1){
        var userId = $('#userId').selectpicker('val')
        if(!userId || userId=='undefined' || userId==null){
            layer.msg('当前任务没有用户参与',{time:1500});
            return false
        }
    }else {
        var userListId = $('#userListId').selectpicker('val')
        console.log(userListId)
        $('#userList').val(userListId)
        if(!userListId || userListId=='undefined' || userListId==null || userListId.length==0){
            layer.msg('请选择人员',{time:1500});
            return false
        }
    }
    // if($('#content').val()==''){
    //     layer.msg('请填写消息内容',{time:1500});
    //     return false
    // }
    return true
}
function changeMsgDiv(dom,id){
    // #009688
    $('.msg-input').css('background-color','grey')
    $(dom).css('background-color','#009688')
    $('.msg-div').hide()
    $('#'+id).show()
}
function fromSubmitMsg(fromId,tab,callBackFun){

    //回调函数
    try {
        if (callBackFun) {
            //var res = callBackFun();
            if(callBackFun()==false){
                return false;
            }
        }
    } catch (error) {
        return error;
    }
    var url=document.getElementById(fromId).action
    $.ajax({
        type: "post",
        url:url,
        cache:false,
        async:false,
        data:$('#'+fromId).serialize(),
        success: function(data){
            try{
                var res=eval('('+data+')') ;
                layer.msg(res.msg);console.log(res.status==1);
                if(res.status==1) {
                    parent.$('#' +tab).bootstrapTable('refresh')
                    parent.layer.closeAll('iframe');

                }

            }catch (e){
                layer.msg(data,{time:1000});
            }
        }
    });

}