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
        url: '/index.php/Settlement/taskSettlement/',//数据源
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
            params.settlementId = $('#settlementId').val();
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
                title: "任务名称",//标题
                field: "task_names",//键名
                align: "center",//水平
                formatter:function (value, row, index) {

                    return "<a style='color: #2eafbb' href=\"javascript:void(0)\" onclick=\"taskDetail(" + row.task_id + ",'500px')\" >"+row.task_name+"</a>";

                }
            },
            {
                field: "wages_name",
                title: "工资",
                align:'center'
            },

            {
                field: "tt1",
                title: "操作",
                align:'center',
                formatter: function (value, row, index) {
                    var html=''

                    html += "<a style='color: #2eafbb' href=\"javascript:void(0)\" onclick=\"taskSettlementDetail(" + row.settlement_id+",'"+row.task_name+"',"+row.task_id+")\" >分账详情</a>";
                    html += "<a style='color: #2eafbb' href=\"javascript:void(0)\" onclick=\"exportTaskSplit(" + row.settlement_id + ","+row.task_id+")\" >&nbsp;导出项目表</a>";

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
function taskSettlementDetail(id,name,taskId) {
    layer.open({
        type: 2,
        title: '【'+name+'】分账详情',
        shadeClose: false,
        shade: 0.1,
        area: ['700px','488px'],
        content: '/index.php/Settlement/taskSettlementDetail/?&settlementId='+id+'&taskId='+taskId

    });
}
function settlementRemark(id,dom) {
    $.ajax({
        type:'post',
        data:{splitCardId:id,remark:$(dom).val()},
        url:'/index.php/Ajax/splitCardRemark/'
    })
}
function exportTaskSplit(id,taskId) {
    window.location.href='/index.php/Settlement/exportTaskSplit?&settlementId='+id+'&taskId='+taskId
}
function confirmSettlement(id) {
    $.ajax({
        type:'post',
        data:{settlementId:id},
        url:'/index.php/Ajax/confirmSettlement/',
        success:function(res){
            if(res.status==1) {
                layer.msg('操作成功',{time:1000});
                parent.$('#mytab').bootstrapTable('refresh')
                parent.layer.closeAll('iframe');
            }else {
                layer.msg(res.msg,{time:1000});
            }
        }
    })
}
function exportWages(id) {
    window.location.href='/index.php/Settlement/exportSplitWages/settlementId/'+id

}