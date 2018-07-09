/**
 * Created by Red on 2016/11/8.
 */

$(function() {

    $('#task-list-new-task').show();
    //根据窗口调整表格高度
    var tableNames = $('#tableNames').val();
    getTaskStatusCount();
    try{
        var tableArr = tableNames.split(',');
        for(var i=0;i<tableArr.length;i++){
            tableLoad(tableArr[i]+'Tab',tableArr[i]);
            $(window).resize(function() {
                $('#'+tableArr[i]+'Tab').bootstrapTable('resetView', {
                    height: tableHeight()
                })
            })
        }
    }catch (e){

    }

    var widgetName = 'task';

    workAreaHandle(widgetName)
    //回车事件
    document.onkeydown = function(e){
        var ev = document.all ? window.event : e;
        if(ev.keyCode==13) {

            var activeTab = $('.content >.task-title-div >.active ').attr('blogname');
            tableRefresh(activeTab)

        }
    }

})
function getTaskStatusCount(){
    $.ajax({
        url:'/index.php/Ajax/getTaskStatusCount/',
        success: function(data){
            console.log(data)
            $('#count_task').html(data.task)
            $('#count_task_0').html(data.task0)
            $('#count_task_1').html(data.task1)
            $('#count_task_2').html(data.task2)
            $('#count_task_3').html(data.task3)
        }
    })
}

function tableLoad(tableId,tableName){
    var status = tableName=='task'?'all':tableName.substring(5);//区分状态
    $('#'+tableId).bootstrapTable({
        url: './',//数据源
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        //height: tableHeight(),//高度调整
        //width:'1900px',
        search: false,//是否搜索
        searchAlign:'right',//搜索框位置
        pagination: true,//是否分页
        pageSize: 20,//单页记录数
        pageList: [5, 10, 20, 50],//分页步进值
        sidePagination: "server",//服务端分页
        contentType: "application/x-www-form-urlencoded",//请求数据内容格式 默认是 application/json 自己根据格式自行服务端处理
        dataType: "json",//期待返回数据类型
        method: "post",//请求方式
        queryParamsType: "limit",//查询参数组织方式
        queryParams: function getParams(params) {
            params.other = "list";
            params.status = status
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: true,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#task-list-new-"+tableName,//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:false,//是否启用排序
        //sortOrder:'id asc',//默认排序
        showExport:false,//导出
        clickToSelect:false,//行选择
        expoortDataType:'basic',//导出数据格式，
        columns: [

            {
                title: "任务标题",//标题
                field: "title",//键名
                align: "center",//水平
                formatter: function (value, row, index) {
                    return "<a class='edit-a-color-1' href=\"javascript:void(0)\" onclick=\"taskDetail(" + row.id + ")\">" + value + "</a>";
                }
            },
            {
                field: "person_num",
                title: "招聘人数",
                align:'center'
            },
            {
                field: "wages_type_name",
                title: "工资",
                align:'center',
                formatter:function(value,row,index){
                    return row.wages+'/'+row.wages_type_name;
                }
            },
            {
                field: "deadline_name",
                title: "报名截止时间",
                align:'center'
                //formatter:function(value,row,index){
                //    return timestampToDate(row.deadline);
                //}
            },
            {
                field: "start_end",
                title: "工作时间",
                align:'center'
                //formatter:function(value,row,index){
                //    var start = timestampToDate(row.start_time);
                //    var end   = timestampToDate(row.end_time);
                //    return start+'~'+end;
                //}
            },
            {
                field: "work_area",
                title: "工作区域",
                align:'center'

            },
            {
                field: "place_description",
                title: "地点描述",
                align:'center'
            },
            {
                field: 'issued_time_name',
                title: "发布时间",
                align:'center'
                //formatter:function(value,row,index){
                //    return timestampToDate(row.issued_time);
                //}
            },
            {
                field: 'issued_uid_name',
                title: "发布人",
                align:'center'

            },
            {
                field: "status",
                title: "任务状态",
                align:'center',
                formatter: function (value, row, index) {
                    if(row.status==0){
                        return '<label style="color: #df5a48;">待发布</label>'
                    }
                    if(row.status==1){
                        return '<label style="color: #97c646">准备中</label>'
                    }
                    if(row.status==2){
                        return '<label style="color:#2eafbb">进行中</label>'
                    }
                    if(row.status==3 || row.status==4){
                        return '<label style="color:#878787">已结束</label>'
                    }

                }
            },
            {
                field: "apply_count",
                title: "报名申请",
                align:'center'
            },
            {
                field: "entered_count",
                title: "报名成功",
                align:'center'
            },
            {
                field: "finished_count",
                title: "任务完成",
                align:'center'
            },
            {
                field: "tt",
                title: "操作",
                align:'center',
                width:150,
                formatter: function (value, row, index) {
                    var html = '';
                    //未发布的可以删除
                    if(row.issued_uid==0 && row.status==0){
                        html += "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"delTask(" + row.id + ")\">删除&nbsp;&nbsp;</a>";
                    }
                    //待发布
                    if(row.status==0){
                        html += "<a class='edit-a-color-1' href=\"javascript:void(0)\" onclick=\"taskEdit(" + row.id + ")\">编辑&nbsp;&nbsp;</a>";
                        html += "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"taskIssued(" + row.id + ")\" >发布&nbsp;&nbsp;</a>";

                    }
                    //准备中
                    if(row.status==1){
                        html += "<a class='edit-a-color-5' href=\"javascript:void(0)\" onclick=\"showApplyList(" + row.id + ")\">报名名单&nbsp;&nbsp;</a>";
                        if(row.no_confirm>0){
                            html +='<font style="color: red">('+row.no_confirm+')</font>';
                        }
                    }
                    //进行中
                    if(row.status==2){
                        html += "<a class='edit-a-color-5' href=\"javascript:void(0)\" onclick=\"showDoingList(" + row.id + ")\">执行名单&nbsp;&nbsp;</a>";
                    }
                    //已结束
                    if(row.status==3 || row.status==4){
                        html += "<a class='edit-a-color-5' href=\"javascript:void(0)\" onclick=\"showDoneList(" + row.id + ")\">人员名单&nbsp;&nbsp;</a>";
                        html += "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"showMoneyList(" + row.id + ")\">金额结算&nbsp;&nbsp;</a>";
                        if(row.no_pay>0){
                            html +='<font style="color: red">('+row.no_pay+')</font>';
                        }
                    }
                    return html
                }
            },

        ],
        onClickRow: function(row, $element) {
            //$element是当前tr的jquery对象
            //$element.css("background-color", "green");
        },//单击row事件
        onDblClickRow:function (row, $element) {

        },//双击时间
        locale: "zh-CN",//中文支持,
        detailView: false, //是否显示详情折叠
        detailFormatter: function(index, row, element) {
            var html = '';
            $.each(row, function(key, val){
                html += "<p>" + key + ":" + val +  "</p>"
            });
            return html;
        }
    });
}
//表格高度
function tableHeight() {
    return $(window).height() + 200;
}
//获取选择数据id
function getIdSelections(tab) {
    return $.map($('#'+tab).bootstrapTable('getSelections'),function (row) {
        return row.id
    })
}


/**
 * 编辑
 * @param id
 * @param tab
 */
function taskEdit(id){
    var height = (tableHeight()-300)+'px';
    layer.open({
        type: 2,
        title: '编辑任务',
        shadeClose: false,
        shade: 0.1,
        area: ['800px',height],
        content: '/index.php/Task/edit/id/'+id

    });
}
/**
 * 发布任务
 * @param id
 */
function taskIssued(id){
    $.post('/index.php/Task/issued/',{id:id},function (data) {
        var res=eval('('+data+')') ;
        layer.msg(res.msg,{time:1000});
        refreshTab();
    })
}
/**
 * 删除任务
 * @param id
 */
function delTask(id){
    layer.msg('确定删除么？', {
        time: 0 //不自动关闭
        ,btn: ['非常确定', '考虑一下']
        ,yes: function(index){
            layer.close(index);
            $.post('/index.php/Task/delTask/',{id:id},function (data) {
                var res=eval('('+data+')') ;
                layer.msg(res.msg,{time:1000});
                refreshTab();
            })
        }
    });

}
/**
 * 报名名单
 * @param id
 */
function showApplyList(id){
    var height = (tableHeight()-300)+'px';
    layer.open({
        type: 2,
        title: '报名审核',
        shadeClose: false,
        shade: 0.1,
        area: ['1200px',height],
        content: '/index.php/UserTask/applyList/taskId/'+id

    });
}
/**
 * 执行名单
 * @param id
 */
function showDoingList(id){
    var height = (tableHeight()-300)+'px';
    layer.open({
        type: 2,
        title: '执行名单',
        shadeClose: false,
        shade: 0.1,
        area: ['1200px',height],
        content: '/index.php/UserTask/DoingList/taskId/'+id

    });
}
/**
 * 任务完成后的人员名单
 * @param id
 */
function showDoneList(id){
    var height = (tableHeight()-300)+'px';
    layer.open({
        type: 2,
        title: '人员名单',
        shadeClose: false,
        shade: 0.1,
        area: ['1200px',height],
        content: '/index.php/UserTask/doneList/taskId/'+id

    });
}
/**
 * 任务完成后的金额计算名单
 * @param id
 */
function showMoneyList(id){
    var height = (tableHeight()-300)+'px';
    layer.open({
        type: 2,
        title: '金额结算',
        shadeClose: false,
        shade: 0.1,
        area: ['1200px',height],
        content: '/index.php/UserTask/moneyList/taskId/'+id

    });
}
/**
 * 刷新所有的tab
 */
function refreshTab(){
    //所有的tab刷新
    try{
        var tableNames ='task,task_0,task_1,task_2,task_3,';
        var tableArr = tableNames.split(',');
        for(var i=0;i<tableArr.length;i++){
            parent.$('#'+tableArr[i]+'Tab').bootstrapTable('refresh')

        }
        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
        parent.layer.close(index); //再执行关闭
        getTaskStatusCount();
    }catch (e){

    }

}
function showTab(tab){
    $('#tableName').val(tab);
    var tableId  = tab+'Tab';
    $(window).resize(function() {
        $('#'+tableId).bootstrapTable('resetView', {
            height: tableHeight()
        })
    })
}

function taskSubmit(fromId,tab){
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
                layer.msg(res.msg,{time:1000});
                if(res.status==1) {
                    if(tab){
                        refreshTab();
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

function beforeASubmit(tab){
    var first = $("#firstArea").find("option:selected").text();
    var second = $("#secondArea").find("option:selected").text();
    var third = $("#thirdArea").find("option:selected").text();

    $('#firstAreaName').val(first);
    $('#secondAreaName').val(second);
    $('#thirdAreaName').val(third);

    taskSubmit('formId',tab);
}

function tableRefresh(tableName){
    var first = $("#button-"+tableName +' select:first').find("option:selected");
    var second = $("#button-"+tableName +' select:eq(1)').find("option:selected");
    var third = $("#button-"+tableName +' select:last').find("option:selected");
    var status = tableName=='task'?'all':tableName.substring(5);//区分状态
    var area = '';
    if(first.text() && first.val()!=0 && first.val()!=''){
        area += first.text()+',';
    }
    if(second.text() && second.val()!=0 && second.val()!=''){
        area += second.text()+',';
    }
    if(  (third.text() && third.val()!=0 && third.val()!='')){
        area += third.text();
    }
    var start_time = $('#start_time_'+tableName).val();
    var end_time = $('#end_time_'+tableName).val();
    var title = $('#title_'+tableName).val();
    $('#'+tableName+'Tab').bootstrapTable('refresh',{query:{status:status,area:area,start_time:start_time,end_time:end_time,title:title}})
}
function activeThis(dom){
    $('.status-title').attr('class','status-title status')
    var domId = dom.id;
    $('#'+domId+' .status').attr("class", "status-title status active");
}
function resetButton(tableName){
    $("#button-"+tableName +' select:first').selectpicker('val', 0);
    $("#button-"+tableName +' select:eq(1)').selectpicker('val', 0);
    $("#button-"+tableName +' select:last').selectpicker('val', 0);
    $('#start_time_'+tableName).val('');
    $('#end_time_'+tableName).val('');
    $('#title_'+tableName).val('');
}




function getNextArea(pid,dom){
    $.ajax({
        url:'/index.php/Home/Ajax/getNextArea/',
        data:{pid:pid},
        async:false,
        success:function(data){
            $("#"+dom).find("option").remove();
            $('#'+dom).selectpicker('refresh');
            if(data.length>0){
                var myOption = '<option value="0">请选择</option>';
                for(var i=0;i<data.length;i++){

                    myOption += '<option value="'+data[i].id+'">'+data[i].name+'</option>';

                }
                $("#"+dom).append(myOption);
            }
            $('#'+dom).selectpicker('refresh');
        }
    })
}
function workAreaHandle(widgetName){
    $('#firstArea'+widgetName).on('changed.bs.select', function (e) {
        var val_1 = $('#firstArea'+widgetName).selectpicker('val')
        getNextArea(val_1,'secondArea'+widgetName)
        var val_1 = $('#secondArea'+widgetName).selectpicker('val')
        getNextArea(val_1,'thirdArea'+widgetName)
    });

    $('#secondArea'+widgetName).on('changed.bs.select', function (e) {
        var val_1 = $('#secondArea'+widgetName).selectpicker('val')
        getNextArea(val_1,'thirdArea'+widgetName)

    });
}
