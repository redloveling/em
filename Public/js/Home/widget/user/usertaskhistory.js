/**
 * Created by Red on 2016/11/24.
 */
$(function() {
    //根据窗口调整表格高度
    $(window).resize(function() {
        $('#userTaskHistoryTab').bootstrapTable('resetView', {
            height: tableHeight()
        })
    })

    $('#userTaskHistoryTab').bootstrapTable({
        url: '/index.php/Ajax/getUserTaskHistoryList/',//数据源
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
            params.userId = $('#userId').val();
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: false,//刷新按钮
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
                title: "任务标题",//标题
                field: "title",//键名
                align: "center",//水平
                order: "desc",//默认排序方式
                formatter: function (value, row, index) {
                    return "<a style='color:#4f99cd' href=\"javascript:void(0)\" onclick=\"taskDetails(" + row.task_id + ")\" >" + value + "</a>";
                }
            },
            {
                field: "person_num",
                title: "招聘人数",
                align: 'center'
            },
            {
                field: "deadline_name",
                title: "报名截止时间",
                align: 'center'
            },
            {
                field: "wage_name",
                title: "工资",
                align: 'center'
            },
            {
                field: "settlement_name",
                title: "工资",
                align: 'center'
            },
            {
                field: "work_time_name",
                title: "工作时间",
                align: 'center'
            },
            {
                field: "work_area",
                title: "工作地址",
                align: 'center'
            },
            {
                field: "apply_time_name",
                title: "报名时间",
                align: 'center'
            },
            {
                field: "task_status_name",
                title: "任务状态",
                align: 'center',
                formatter: function (value, row, index) {
                    if(value=='进行中') {
                        return "<font style='color: #2eafbb;' >" + value + "</a>";
                    }else if(value=='已结束') {
                        return "<font style='color: #878787;' >" + value + "</a>";
                    }else{
                        if(row.taskstatus==4){
                            return "<font style='color: #878787;' >已结束</a>";
                        }else{
                            return "<font style='color: #97c646;' >" + value + "</a>";;
                        }

                    }

                }
            },
            {
                field: "is_join",
                title: "是否参与任务",
                align: 'center'
            }

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
/**
 * 任务详情
 * @param id
 * @param tab
 */
function taskDetails(id){
    var height = (tableHeight()+100)+'px';
    layer.open({
        type: 2,
        title: '任务详情',
        shadeClose: false,
        shade: 0.1,
        area: ['800px',height],
        content: '/index.php/Task/detail/id/'+id

    });
}