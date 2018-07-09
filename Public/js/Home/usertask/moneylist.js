/**
 * Created by Red on 2016/10/25.
 */
$(function() {
    //根据窗口调整表格高度
    $(window).resize(function() {
        $('#tab').bootstrapTable('resetView', {
            height: tableHeight()
        })
    })

    $('#tab').bootstrapTable({
        url: './moneyList',//数据源
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        //height: 450,//高度调整
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
            params.taskId=$('#taskId').val();
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
        singleSelect:false,//
        columns: [
            {
                title: "<input type=\"checkbox\"  class=\"checkboxstyle\"  id=\"all\" onclick=\"checkall(this)\" /><label class=\"checklabelstyle\"  for=\"all\"></label>",
                field: "select",
                width: 40,//宽度
                align: "center",//水平
                valign: "middle",//垂直
				formatter: function (value, row, index) {
					return "<input type=\"checkbox\"  name =\"all\" class=\"checkboxstyle\"  id=\""+row.uid+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+row.uid+"\"></label>";
              }
            },
            {
                title: "昵称",//标题
                field: "nick_name",//键名
                align: "center",//水平
                formatter: function (value, row, index) {
                    return "<a style='color:#418fc6' href=\"javascript:void(0)\" onclick=\"getUserInfo(" + row.uid + ")\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">" + value + "</a>";
                }
            },
            {
                field: "sex",
                title: "性别",
                align:'center',
                formatter: function (value, row, index) {
                    if(row.sex==0){
                        return '女';
                    }else{
                        return '男';
                    }
                }
            },
            {
                field: "age",
                title: "年龄",
                align: 'center'
            },
            {
                field: "tell",
                title: "手机号码",
                align: 'center'
            },
            {
                field: "card_num",
                title: "身份证号码",
                align: 'center'
            },
            {
                field: "userTaskStartTime",
                title: "报名时间",
                align:'center'
            },
            {
                field: "userTaskStatus_3",
                title: "工作状态",
                align:'center',
                formatter: function (value, row, index) {
                    if(row.status_3==2){
                        return '<label style="color: #97c646">任务完成</label>'
                    }
                    if(row.status_3==1){
                        return '<label style="color: #878787">任务失败</label>'
                    }
                    if(row.status_1==2){
                        return '<label style="color: #878787">报名失败</label>'
                    }
                    if(row.status_1==4){
                        return '<label style="color: #878787">取消报名</label>'
                    }
                    // if(value=='任务完成'){
                    //     return '<font style="color: #97c646">'+value+'</font>'
                    // }else{
                    //     return '<font style="color: #878787">'+value+'</font>'
                    // }
                }

            },
            {
                field: "money",
                title: "工资合计",
                align:'center'
            },
            // {
            //     field: "remark",
            //     title: "备注",
            //     align:'center'
            // },
            // {
            //     field: "wages",
            //     title: "金额计算",
            //     align:'center',
            //     formatter: function (value, row, index) {
            //         var html ='';
            //
            //         if(row.status_3==2){
            //             html="<input style='color:#1cace1' type='text' id=money_"+row.uid+" name='money' value="+row.money+" class='form-control' placeholder='请输入正整数'/>";
            //         }
            //         if(row.status_3==1){
            //             html="<input style='color:#a8a8a8' type='text' readonly='true' class='form-control' id=money_"+row.uid+" name='money' value='0'/>";
            //         }
            //         return html
            //     }
            // },
            {
                field: "wages",
                title: "操作",
                align:'center',
                formatter: function (value, row, index) {

                    if(row.money>0){
                        return '<a style="color: #97c646" href="javascript:void(0)" onclick="showUserTaskMoney('+row.user_id+','+row.task_id+')">查看</a>'
                    } else {
                        return '<a style="color: #97c646" href="javascript:void(0)" onclick="showUserTaskMoney('+row.user_id+','+row.task_id+')">录入</a>'
                    }
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

//获取选择数据id(新样式)
function getIdSelections() {
	var temp = [];
    $("input[name='all']:checked").each(function(i){
          temp.push($(this)[0].id);
    });
	return temp;
}
/**
 * 拒绝执行审核
 */
function moneyConfirm(){
    var ids = getIdSelections()
    if(ids==''){
        layer.msg('请选择数据',{time:1000})
        return
    }
    var money=[];
    for(var i=0;i<ids.length;i++){
        var moneyVal = ''
        moneyVal = $('#money_'+ids[i]).val();
        if(moneyVal=='' || moneyVal=='undefined'){
            layer.msg('请填写金额',{time:1000})
            return
        }
        money.push(moneyVal)
    }

    var taskId = $('#taskId').val();
    $.post('/index.php/UserTask/moneyConfirm/',{ids:ids,moneys:money,taskId:taskId},function (data) {
        var res=eval('('+data+')') ;
        layer.msg(res.msg,{time:1000});
        $('#tab').bootstrapTable('refresh')
    })
    parent.refreshTab();


}