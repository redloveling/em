$(function() {
    var __APP__ ='index.php/';
    getCurrentTaskCount();
});

function getCurrentTaskCount(){
    $.ajax({
        async:false,
        url:'/index.php/Ajax/getMessageCount/',
        success:function(data){
            var html = '<span style="color: #d9534f;font-size:0.7cm">.</span>';
            //用户管理
            (data.realCount>0 || data.payCount>0)&& $("#listCount_3").html(html);
            //任务管理
            (data.taskCount>0)&&  $("#listCount_4").html(html);

            //任务列表
            data.taskCount>0?$("#taskCount_5").text(data.taskCount):$("#taskCount_5").remove();
            //实名审核
            data.realCount>0 ? $("#taskCount_15").text(data.realCount):$("#taskCount_15").remove();
            //支付审核
            data.payCount>0 ? $("#taskCount_16").html(data.payCount):$("#taskCount_16").remove();

            $("#sstaskCount_16").val(data.payCount)
            //留言查看
            data.messageCount>0 ? $("#taskCount_18").text(data.messageCount):$("#taskCount_18").remove();

        }
    })

}
function beforeSubmit1(){
    var userId = $('#user_ids').selectpicker('val')
    console.log(userId)
    if(!userId || userId=='undefined' || userId==null){
        console.log(userId)
        layer.msg('当前任务没有用户参与',{time:1000});
        return false
    }
}

/**
 * 提交表单
 * @param fromId
 */
function fromSubmit(fromId,tab,callBackFun){

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
                layer.msg(res.msg);
                if(res.status==1) {
                    try{
                        var table = tab ? tab : 'mytab';
                        var tables = table.split(",");
                        for(var i=0;i<tables.length;i++){
                            parent.$('#' + tables[i]).bootstrapTable('refresh')
                        }

                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index); //再执行关闭
                        }catch (e){
                        }
                }
            }catch (e){
                layer.msg(data,{time:1000});
            }
        }
    });

}
function fromSubmits(fromId,tab,callBackFun){

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
                layer.closeAll();
            }catch (e){
                layer.msg(data,{time:1000});
            }
        }
    });

}
function closeLayer(){
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index); //再执行关闭
}
function deleteModelShow(url){
    $('#deleteModal').modal('show');
    $('#deleteModalBtn').attr('data-url',url)
}
function ajaxDelete(url){
    var url = url?url:$('#deleteModalBtn').attr('data-url');
    $.ajax({
        type: "get",
        url:url,
        cache:false,
        async:false,
        success: function(data){
            if(!data.url){
                layer.msg(data);
            }else{
                window.location.href=data.url;
            }
        }
    });
}
/**
 * 日期时间戳转换成字符格式
 * @param nS
 * @returns {string}
 */
function timestampToDate(nS) {
    if(nS==0) return '';
    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ').replace(/\//g, "-").replace(/上午|下午/g, " ");
}
/**
 * 日期字符串转时间戳
 * @param str
 * @returns {number}
 */
function dateToTimestamp(str){
    var date = new Date(str);
    return date.getTime()/1000;
}
//获取选择数据id
/*function getIdSelections(tab,idName) {
    var tabId = tab?tab:'mytab';
    return $.map($('#'+tabId).bootstrapTable('getSelections'),function (row) {
        return idName?row[idName]:row.id
    })
}*/
/**
 * 用户任务表的数据导出
 * @param key
 */
function userTaskExport(key){

    window.location.href='/index.php/Home/UserTask/export/key/'+key
}
function tableHeight() {
    return $(window).height() - 200;
}

/**
 * 用户信息展示
 * @param uid
 */
function getUserInfo(uid){
    layer.open({
        type: 2,
        title: '用户详情',
        shadeClose: false,
        shade: 0.1,
        area: ['1000px','588px'],
        content: '/index.php/UserTask/showUserInfo/id/'+uid

    });
}

/**
 * 任务详情
 * @param id
 * @param tab
 */
function taskDetail(id,h){
    var height = (tableHeight()-270)+'px';
    layer.open({
        type: 2,
        title: '任务详情',
        shadeClose: false,
        shade: 0.1,
        area: ['800px',h?h:height],
        content: '/index.php/Task/detail/id/'+id

    });
}

function userPicture(uid){
    var height = (tableHeight()+20)+'px';
    layer.open({
        type: 2,
        title: '查看照片',
        shadeClose: false,
        shade: 0.1,
        area: ['720px',height],
        content: '/index.php/User/showUserPicture/userId/'+uid

    });
}
//userPicture方法改进
function userPictureView(ids){
    var height = (tableHeight()+20)+'px';
    layer.open({
        type: 2,
        title: '查看照片',
        shadeClose: false,
        shade: 0.1,
        area: ['720px',height],
        content: '/index.php/User/viewUserPicture/ids/'+ids

    });
}

function changeTabDiv(id){
    $('.tab-div-pan').hide();
    $('#'+id).show();
    //var leftHeight = $(document).height();
    //$('.left-div').height(leftHeight)
}
function activeThis(dom){
    $('.status-title').attr('class','status-title status')
    var domId = dom.id;
    $('#'+domId+' .status').attr("class", "status-title status active");
}

//全选/全不选
function checkall(dom){
	var checkname = dom.id;
	var flag = dom.checked;
	if(flag==true){
		$("input[name='"+checkname+"']").each(function(){
			$(this)[0].checked=true;
		})
	}else{
		$("input[name='"+checkname+"']").each(function(){
			$(this)[0].checked=false;
		})
	}
}
function checkitem(dom){
	var checkname = dom.name;
    var subBox = $("input[name='"+checkname+"']").length;
	var subBoxChecked = $("input[name='"+checkname+"']:checked").length;
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
function modifyPassword(){
    var height = (tableHeight()+20)+'px';
    layer.open({
        type: 2,
        title: '修改密码',
        shadeClose: false,
        shade: 0.1,
        area: ['320px','450px'],
        content: '/index.php/adminUser/modifyPassword/'

    });
}
//高亮
function highLight(value, row, index) {
    return {
        css: {
            "background-color": '#e1f1ff'
        }
    }
}
/**
 * 用户任务结算
 * @param userId
 * @param taskId
 */
function showUserTaskMoney(userId,taskId) {
    layer.open({
        type: 2,
        title: '详细工资',
        shadeClose: false,
        shade: 0.1,
        cancel: function(index, layero){
            if(confirm('关闭将丢失支付信息，确定关闭？')){ //只有当点击confirm框的确定时，该层才会关闭
                layer.close(index)
            }
            return false;
        },
        area: ['800px','400px'],
        content: '/index.php/UserTask/userTaskMoney/?userId='+userId+'&taskId='+taskId

    });
}