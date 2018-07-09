/**
 * Created by Red on 2016/10/25.
 */
$(function() {
    //根据窗口调整表格高度
    $(window).resize(function() {
        $('#mytab').bootstrapTable('resetView', {
            height: tableHeight()
        })
    })

    $('#mytab').bootstrapTable({
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
        method: "post",//请求方式,
        striped: true,//间行变色
        queryParamsType: "limit",//查询参数组织方式
        queryParams: function getParams(params) {
            params.other = "list";
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: false,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#button",//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:false,//是否启用排序
        //sortOrder:'id asc',//默认排序
        showExport:false,//导出
        clickToSelect:true,//行选择
        expoortDataType:'basic',//导出数据格式，
        columns: [
            {
                title: "<input type=\"checkbox\"  class=\"checkboxstyle\"  id=\"all\" onclick=\"checkall(this)\" /><label class=\"checklabelstyle\"  for=\"all\"></label>",
                field: "select",
                width: 40,//宽度
                align: "center",//水平
                valign: "middle",//垂直
				formatter: function (value, row, index) {
					return "<input type=\"checkbox\"  name =\"all\" class=\"checkboxstyle\"  id=\""+row.message_id+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+row.message_id+"\"></label>";
              }
            },
            {
                title: "昵称",//标题
                field: "nick_name",//键名
                align: "center",//水平
                order: "desc",//默认排序方式
                formatter: function (value, row, index) {
                    return "<a style='color:#418fc6'href=\"javascript:void(0)\" onclick=\"getUserInfo(" + row.send_uid + ")\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">" + value + "</a>";

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
                field: "education_name",
                title: "学历",
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
                field: "message_time",
                title: "提交时间",
                align:'center'
            },
            {
                field: "star_label_name",
                title: "评星",
                align:'center'
            },
            {
                field: "content",
                title: "留言内容",
                align:'center'
            },
            {
                field: "tt1",
                title: "查看照片",
                align:'center',
                formatter: function (value, row, index) {
                    return   "<a style='color: #2eafbb' href=\"javascript:void(0)\" onclick=\"messagePicture(" + row.message_id + ")\" data-type=\"text\" data-pk=\"" + row.id + "\">查看</a>";

                }
            },
            {
                field: "status_name",
                title: "状态",
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

})
//表格高度
function tableHeight() {
    return $(window).height() - 200;
}
/**
 * 搜索
 */
function searchMessage() {
    var start_time = $('#start_time').val();
    var end_time = $('#end_time').val();
    if(start_time){
        if(end_time=='' || dateToTimestamp(start_time)>=dateToTimestamp(end_time)){
            layer.msg('请选择正确的时间段')
        }
    }
    var content = $('#content').val();
    $('#mytab').bootstrapTable('refresh',{query:{start_time:start_time,end_time:end_time,content:content}})
}

function messagePicture(id){
    var height = (tableHeight()+20)+'px';
    layer.open({
        type: 2,
        title: '查看照片',
        shadeClose: false,
        shade: 0.1,
        area: ['750px',height],
        content: '/index.php/Message/showMessagePicture/messageId/'+id

    });
}
function getIdSelections() {
	var temp = [];
    $("input[name='all']:checked").each(function(i){
          temp.push($(this)[0].id);
    });
	return temp;
}
function messageHandle(status){
    var ids = getIdSelections();
    if(ids==''){
        layer.msg('请选择数据',{time:1000})
        return
    }
    $.post('/index.php/Message/messageHandle/',{ids:ids,status:status},function (data) {
        var res=eval('('+data+')') ;
        layer.msg(res.msg,{time:1000});
        $('#mytab').bootstrapTable('refresh')
    })
}
function resetButtonMessage(){
    $('#start_time').val('');
    $('#end_time').val('');
    $('#content').val('');
}
