/**
 * Created by Red on 2017/7/13.
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
                title: "结算时间",//标题
                field: "settlement_time_name",//键名
                align: "center",//水平
            },
            {
                field: "settlement_uid_name",
                title: "结算人",
                align:'center'
            },
            {
                field: "person_count",
                title: "结算人数",
                align:'center'
            },
            {
                field: "money",
                title: "结算总金额",
                align:'center'
            },
            {
                field: "pay_time_name",
                title: "打款时间",
                align:'center'
            },
            {
                field: "status_name",
                title: "结算状态",
                align:'center'
            },
            {
                field: "tt1",
                title: "操作",
                align:'center',
                formatter: function (value, row, index) {
                    var html=''
                    if(row.status==0){
                        html += "<a style='color: #2eafbb' href=\"javascript:void(0)\" onclick=\"batchSettlement(" + row.id + ")\" >批量结算</a>";
                    }else if(row.status==1){
                        html += "<a style='color: #2eafbb' href=\"javascript:void(0)\" onclick=\"confirmPay(" + row.id + ")\" >确认打款</a>";
                        html += "<a style='color: #2eafbb' href=\"javascript:void(0)\" onclick=\"batchSettlement(" + row.id + ")\" >&nbsp;查看详情</a>";
                        html += "<a style='color: #2eafbb' href=\"javascript:void(0)\" onclick=\"exportSettlement(" + row.id + ")\" >&nbsp;导出项目表</a>";
                    }else {
                        html += "<a style='color: #2eafbb' href=\"javascript:void(0)\" onclick=\"batchSettlement(" + row.id + ")\" >查看详情</a>";
                        html += "<a style='color: #2eafbb' href=\"javascript:void(0)\" onclick=\"exportSettlement(" + row.id + ")\" >&nbsp;导出项目表</a>";
                    }
                    return   html

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

})
//表格高度
function tableHeight() {
    return $(window).height() - 200;
}
function batchSettlement(id) {
    layer.open({
        type: 2,
        title: '任务结算详情',
        shadeClose: false,
        shade: 0.1,
        area: ['800px','588px'],
        content: '/index.php/Settlement/taskSettlement/settlementId/'+id

    });
}
function exportSettlement(id) {
    window.location.href='/index.php/Settlement/exportSettlement/settlementId/'+id
}

function confirmPay(id) {
    $.ajax({
        type:'post',
        data:{settlementId:id},
        url:'/index.php/Ajax/confirmPay/',
        success:function(res){
            if(res.status==1) {
                layer.msg('操作成功',{time:1000});
                parent.$('#mytab').bootstrapTable('refresh')
            }else {
                layer.msg(res.msg,{time:1000});
            }
        }
    })
}