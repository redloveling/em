/**
 * Created by Red on 2016/10/25.
 */
$(function() {
    $('#task-list-new-all').show();

    var tableNames = $('#tableNames').val();
    getUserStatusCount();
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
    //回车事件
    document.onkeydown = function(e){
        var ev = document.all ? window.event : e;
        if(ev.keyCode==13) {

            var activeTab = $('#tab li[class="active"] a').attr('blogname');
            tableRefresh(activeTab)

        }
    }

})
function getUserStatusCount(){
    $.ajax({
        url:'/index.php/Ajax/getUserStatusCount/',
        success: function(data){
            $('#count_user_all').html(data.user_all)
            $('#count_user_black').html(data.user_black)
            $('#count_user_real').html(data.user_real)
            $('#count_user_pay').html(data.user_pay)
        }
    })
}

function backTableLoad(tableId,tableName){
    $('#'+tableId).bootstrapTable({
        url: './',//数据源
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        //height: tableHeight(),//高度调整
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
            params.status = tableName;
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: false,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#task-list-new-"+tableName,//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:false,//是否启用排序
        //sortOrder:'id asc',//默认排序
        showExport:false,//导出
        clickToSelect:true,//行选择
        expoortDataType:'basic',//导出数据格式，
        columns: [
            {
                title: "<input type=\"checkbox\"  class=\"checkboxstyle\"  id=\"all"+status+"\" onclick=\"checkall(this)\" /><label class=\"checklabelstyle\"  for=\"all"+status+"\"></label>",
                field: "select",
                width: 40,//宽度
                align: "center",//水平
                valign: "middle",//垂直
				formatter: function (value, row, index) {
					return "<input type=\"checkbox\" name =\"all"+status+"\" class=\"checkboxstyle\"  id=\""+status+"-"+row.uid+"-"+index+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+status+"-"+row.uid+"-"+index+"\"></label>";
                }
            },
            {
                title: "昵称",//标题
                field: "nick_name",//键名
                align: "center",//水平
                formatter: function (value, row, index) {
                    return "<a href=\"javascript:void(0)\" onclick=\"getUserInfo(" + row.uid + ")\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">" + value + "</a>";
                }
            },
            {
                field: "sex_name",
                title: "性别",
                align:'center'
            },
            {
                field: "age",
                title: "年龄",
                align:'center'

            },
            {
                field: "card_num",
                title: "身份证号",
                align:'center'

            },
            {
                field: "education_name",
                title: "学历",
                align:'center'

            },
            {
                field: "tell",
                title: "手机号码",
                align:'center'

            },
            {
                field: "reg_time_name",
                title: "注册时间",
                align:'center'

            },
            {
                field: "black_time_name",
                title: "拉黑时间",
                align:'center'

            },
            {
                field: "black_status_name",
                title: "用户状态",
                align:'center'

            },
            //{
            //    field: "real_status_name",
            //    title: "实名认证",
            //    align:'center'
            //
            //},
            //{
            //    field: "pay_status_name",
            //    title: "支付认证",
            //    align:'center'
            //
            //},
            {
                field: "status",
                title: "操作",
                align:'center',
                formatter: function (value, row, index) {
                    var html = '';
                    html = "<a class='edit-a-color-1' href=\"javascript:void(0)\" onclick=\"taskHistory(" + row.uid + ")\" >查看任务&nbsp;&nbsp;&nbsp;</a>";

                    if(row.black_status==1){
                        html += "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"blackTrans(" + row.uid + ",0)\" >移出黑名单</a>";
                    }else{
                        html += "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"blackTrans(" + row.uid + ",1)\" >拉黑</a>";
                    }
                    return html;
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
function realTableLoad(tableId,tableName){
    $('#'+tableId).bootstrapTable({
        url: './',//数据源
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        //height: tableHeight(),//高度调整
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
            params.status = tableName;
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: false,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#task-list-new-"+tableName,//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:false,//是否启用排序
        //sortOrder:'id asc',//默认排序
        showExport:false,//导出
        clickToSelect:true,//行选择
        expoortDataType:'basic',//导出数据格式，
        columns: [
            {
                title: "<input type=\"checkbox\"  class=\"checkboxstyle\"  id=\"all"+status+"\" onclick=\"checkall(this)\" /><label class=\"checklabelstyle\"  for=\"all"+status+"\"></label>",
                field: "select",
                width: 40,//宽度
                align: "center",//水平
                valign: "middle",//垂直
                formatter: function (value, row, index) {
                    return "<input type=\"checkbox\" name =\"all"+status+"\" class=\"checkboxstyle\"  id=\""+status+"-"+row.uid+"-"+index+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+status+"-"+row.uid+"-"+index+"\"></label>";
                }
            },
            {
                title: "昵称",//标题
                field: "nick_name",//键名
                align: "center",//水平
                formatter: function (value, row, index) {
                    return "<a class='edit-a-color-4' href=\"javascript:void(0)\" onclick=\"getUserInfo(" + row.uid + ")\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">" + value + "</a>";
                }
            },
            {
                field: "sex_name",
                title: "性别",
                align:'center'
            },
            {
                field: "age",
                title: "年龄",
                align:'center'

            },
            {
                field: "card_num",
                title: "身份证号",
                align:'center'

            },
            {
                field: "education_name",
                title: "学历",
                align:'center'

            },
            {
                field: "tell",
                title: "手机号码",
                align:'center'

            },
            {
                field: "reg_time_name",
                title: "注册时间",
                align:'center'

            },
            {
                field: "black_status_name",
                title: "黑名单状态",
                align:'center'

            },
            {
               field: "real_status_time",
               title: "认证时间",
               align:'center'

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
function payTableLoad(tableId,tableName){
    $('#'+tableId).bootstrapTable({
        url: './',//数据源
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        //height: tableHeight(),//高度调整
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
            params.status = tableName;
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: false,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#task-list-new-"+tableName,//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:false,//是否启用排序
        //sortOrder:'id asc',//默认排序
        showExport:false,//导出
        clickToSelect:true,//行选择
        expoortDataType:'basic',//导出数据格式，
        columns: [
            {
                title: "<input type=\"checkbox\"  class=\"checkboxstyle\"  id=\"all"+status+"\" onclick=\"checkall(this)\" /><label class=\"checklabelstyle\"  for=\"all"+status+"\"></label>",
                field: "select",
                width: 40,//宽度
                align: "center",//水平
                valign: "middle",//垂直
                formatter: function (value, row, index) {
                    return "<input type=\"checkbox\" name =\"all"+status+"\" class=\"checkboxstyle\"  id=\""+status+"-"+row.uid+"-"+index+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+status+"-"+row.uid+"-"+index+"\"></label>";
                }
            },
            {
                title: "昵称",//标题
                field: "nick_name",//键名
                align: "center",//水平
                formatter: function (value, row, index) {
                    return "<a class='edit-a-color-4' href=\"javascript:void(0)\" onclick=\"getUserInfo(" + row.uid + ")\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">" + value + "</a>";

                }
            },
            {
                field: "sex_name",
                title: "性别",
                align:'center'
            },
            {
                field: "age",
                title: "年龄",
                align:'center'

            },
            {
                field: "card_num",
                title: "身份证号",
                align:'center'

            },
            {
                field: "education_name",
                title: "学历",
                align:'center'

            },
            {
                field: "tell",
                title: "手机号码",
                align:'center'

            },
            {
                field: "reg_time_name",
                title: "注册时间",
                align:'center'

            },
            {
                field: "black_status_name",
                title: "黑名单状态",
                align:'center'

            },
            {
                field: "pay_status_time",
                title: "认证时间",
                align:'center'

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
function tableLoad(tableId,tableName){
    // var status = tableName=='all'?'':1;
    if(tableName=='black'){
        backTableLoad(tableId,tableName)
    }
    if(tableName=='real'){
        realTableLoad(tableId,tableName)
    }
    if(tableName=='pay' ){
        payTableLoad(tableId,tableName)
    }
    $('#'+tableId).bootstrapTable({
        url: './',//数据源
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        //height: tableHeight(),//高度调整
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
            params.status = tableName;
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: false,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#task-list-new-"+tableName,//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:false,//是否启用排序
        //sortOrder:'id asc',//默认排序
        showExport:false,//导出
        clickToSelect:true,//行选择
        expoortDataType:'basic',//导出数据格式，
        columns: [
            {
                title: "<input type=\"checkbox\"  class=\"checkboxstyle\"  id=\"all"+status+"\" onclick=\"checkall(this)\" /><label class=\"checklabelstyle\"  for=\"all"+status+"\"></label>",
                field: "select",
                width: 40,//宽度
                align: "center",//水平
                valign: "middle",//垂直
				formatter: function (value, row, index) {
					return "<input type=\"checkbox\" name =\"all"+status+"\" class=\"checkboxstyle\"  id=\""+status+"-"+row.uid+"-"+index+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+status+"-"+row.uid+"-"+index+"\"></label>";
                }
            },
            {
                title: "昵称",//标题
                field: "nick_name",//键名
                align: "center",//水平
                formatter: function (value, row, index) {
                    return "<a class='edit-a-color-4' href=\"javascript:void(0)\" onclick=\"getUserInfo(" + row.uid + ")\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">" + value + "</a>";
                }
            },
            {
                field: "sex_name",
                title: "性别",
                align:'center'
            },
            {
                field: "age",
                title: "年龄",
                align:'center'

            },
            {
                field: "card_num",
                title: "身份证号",
                align:'center'

            },
            {
                field: "education_name",
                title: "学历",
                align:'center'

            },
            {
                field: "tell",
                title: "手机号码",
                align:'center'

            },
            {
                field: "reg_time_name",
                title: "注册时间",
                align:'center'

            },
            {
                field: "black_status_name",
                title: "黑名单状态",
                align:'center'

            },
            {
                field: "real_status_name",
                title: "实名认证",
                align:'center'

            },
            {
                field: "pay_status_name",
                title: "支付认证",
                align:'center'

            },
            {
                field: "status",
                title: "操作",
                align:'center',
                formatter: function (value, row, index) {
                    var html = '';
                    html = "<a class='edit-a-color-1' href=\"javascript:void(0)\" onclick=\"taskHistory(" + row.uid + ")\" >查看任务&nbsp;&nbsp;&nbsp;</a>";

                    if(row.black_status==1){
                        html += "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"blackTrans(" + row.uid + ",0)\" >移出黑名单</a>";
                    }else{
                        html += "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"blackTrans(" + row.uid + ",1)\" >拉黑</a>";
                    }
                    return html;
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
    return $(window).height() - 200;
}
//获取选择数据id
function getIdSelections() {
    return $.map($('#mytab').bootstrapTable('getSelections'),function (row) {
        return row.id
    })
}

/**
 * 通过认证
 */
function passPayAudit(id,userId){
    $.post('./passPayAudit/',{userId:userId,id:id},function (data) {
        var res=eval('('+data+')') ;
        layer.msg(res.msg);
        $('#noTab').bootstrapTable('refresh');
        $('#alreadyTab').bootstrapTable('refresh');
    })
}
/**
 * 拒绝认证
 */
function denyPayAudit(userId,id){
    layer.open({
        type: 2,
        title: '拒绝原因',
        shadeClose: false,
        shade: 0.1,
        area: ['380px', '400px'],
        content: '/index.php/User/denyPayAudit/?userId='+userId+'&cardId='+id
    });
}

/**
 * 任务历史
 */
function taskHistory(userId){
    var height = (tableHeight()+150)+'px';
    layer.open({
        type: 2,
        title: '任务历史',
        shadeClose: false,
        shade: 0.1,
        area: ['1150px', height],
        content: '/index.php/User/userTaskHistory/?userId='+userId
    });
}
/**
 * 黑名单
 * @param userId
 * @param type
 */
function blackTrans(userId,type){
    $.post('/index.php/User/blackTrans/',{userId:userId,type:type},function (data) {
        var res=eval('('+data+')') ;
        layer.msg(res.msg,{time:500});
        $('#allTab').bootstrapTable('refresh');
        $('#blackTab').bootstrapTable('refresh');
        getUserStatusCount();
    })
}
/**
 * 搜索
 * @param tableName
 */
function tableRefresh(tableName){

    var join_status = $('#join_status_'+tableName).val();
    var start_time = $('#start_time_'+tableName).val();
    var end_time = $('#end_time_'+tableName).val();
    var selectName=$('#selectList_'+tableName).val();
    var keyWord = $('#keyWord_'+tableName).val();
    $('#'+tableName+'Tab').bootstrapTable('refresh',{query:{status:tableName,join_status:join_status,start_time:start_time,end_time:end_time,selectName:selectName,keyWord:keyWord}})
}
function exportUser(tableName){
    window.location.href='/index.php/User/exportUser/status/'+tableName
}
function activeThis(dom){
    $('.status-title').attr('class','status-title status')
    var domId = dom.id;
    $('#'+domId+' .status').attr("class", "status-title status active");
}
function resetButton(tableName){
    $("#button-"+tableName +' select:first').selectpicker('val', '1,2');
    $("#button-"+tableName +' select:last').selectpicker('val', 'username');
    $('#start_time_'+tableName).val('');
    $('#end_time_'+tableName).val('');
    $('#title_'+tableName).val('');
    $('#keyWord_'+tableName).val('');
}