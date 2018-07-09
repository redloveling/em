/**
 * Created by Red on 2016/10/25.
 */
$(function() {
    //根据窗口调整表格高度
    $(window).resize(function() {
        $('#questionTab').bootstrapTable('resetView', {
            height: tableHeight()
        })
    })

    $('#questionTab').bootstrapTable({
        url: './index/',//数据源
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
                title: "序号",
                field: "kid",
                width:'40',
                align: "center"//水平
            },
            {
                title: "题干",//标题
                field: "title",//键名
                align: "center"//水平
            },
            {
                field: "type_name",
                title: "题型",
                align:'center'
            },
            {
                field: "tt",
                title: "操作",
                align:'center',
                formatter: function (value, row, index) {
                    var html='';
                    html+= "<a href=\"javascript:void(0)\" style='color:#4f99cd' onclick=\"editQuestion(" + row.id + ")\" >编辑</a>";
                    html+= "&nbsp;&nbsp;<a href=\"javascript:void(0)\" style='color:#df5a48' onclick=\"deleteQuestion(" + row.id + ")\" >删除</a>";
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
    $('#add').click(function () {
    layer.open({
        type: 2,
        title: '<font style="color: #494949;font-weight: bold">新增</font>',
        shadeClose: false,
        shade: 0.1,
        area: ['590px', '500px'],
        content: '/index.php/Question/add/' //iframe的url
    });

    });
})

function editQuestion(id){
    layer.open({
        type: 2,
        title: '<font style="color: #494949;font-weight: bold">编辑</font>',
        shadeClose: false,
        shade: 0.1,
        area: ['590px', '500px'],
        content: '/index.php/Question/edit/id/'+id //iframe的url
    });
}
function deleteQuestion(id){
    $.post('/index.php/Question/delete/',{id:id},function (data) {
        var res=eval('('+data+')') ;
        layer.msg(res.msg);
        $('#questionTab').bootstrapTable('refresh');
    })
}