$(function() {
    //根据窗口调整表格高度
    $(window).resize(function() {
        $('#mytab').bootstrapTable('resetView', {
            height: tableHeight()
        })
    })

    $('#mytab').bootstrapTable({
        url: './index/',//数据源
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        height: tableHeight(),//高度调整
        search: true,//是否搜索
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
            //params obj
            params.other = "otherInfo";
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: true,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#button",//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:true,//是否启用排序
        sortOrder:'id asc',//默认排序
        showExport:false,//导出
        expoortDataType:'basic',//导出数据格式
        columns: [
            {
                title: "全选",
                field: "select",
                checkbox: true,
                width: 20,//宽度
                align: "center",//水平
                valign: "middle"//垂直
            },
            {
                title: "编号",//标题
                field: "id",//键名
                sortable: true,//是否可排序
                order: "desc"//默认排序方式
            },
            {
                field: "user_name",
                title: "用户名",
                sortable: true,
                titleTooltip: "this is name"
            },
            {
                field: "true_name",
                title: "真实姓名",
                sortable: true,
                titleTooltip: "this is name"
            },
            {
                field: "last_login_time",
                title: "最新登录",
                sortable: true,
            },
            {
                field: "status",
                title: "启用状态",
                sortable: true,
                //formatter: '',//处理方法
            }
        ],
        onClickRow: function(row, $element) {
            //$element是当前tr的jquery对象
            //$element.css("background-color", "green");
        },//单击row事件
        onDblClickRow:function (row, $element) {
            layer.open({
                type: 2,
                title: '编辑用户',
                shadeClose: true,
                shade: 0.1,
                area: ['380px', '520px'],
                content: './addUser/id/'+row.id //iframe的url
            });
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
    $('#forbidden').click(function () {
        var id=getIdSelections();
        forbidden(id);
    });

    $('#enable').click(function () {
        var id = getIdSelections();
        enableUsers(id);
    });

    $('#add').click(function () {
        layer.open({
            type: 2,
            title: '新增用户',
            shadeClose: true,
            shade: 0.1,
            area: ['380px', '480px'],
            content: './addUser/' //iframe的url
        });

    });
})
//表格高度
function tableHeight() {
    return $(window).height() - 250;
}
//获取选择数据id
function getIdSelections() {
    return $.map($('#mytab').bootstrapTable('getSelections'),function (row) {
        return row.id
    })
}

function forbidden(id) {
    $.post('./setWebForbidden/',{ids:id},function (data) {
        var re=eval('('+data+')') ;
        layer.msg(re.msg);
        $('#mytab').bootstrapTable('refresh');
    })
}

function enableUsers(ids) {
    $.post('./setWebEnable/',{ids:ids},function (data) {
        var re = eval('('+data+')') ;
        layer.msg(re.msg);
        $('#mytab').bootstrapTable('refresh');
    })
}