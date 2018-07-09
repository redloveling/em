/**
 * Created by Red on 2016/10/25.
 */
 $(function() {
     getRealStatusCount();
    var tableArr=['noTab','alreadyTab'];
    for(var i=0;i<tableArr.length;i++){
		if(tableArr[i]=='noTab'){
			noTableLoad(tableArr[i]);
		}else{
			alreadyTableLoad(tableArr[i]);
		}
        $(window).resize(function() {
            $('#'+tableArr[i]).bootstrapTable('resetView', {
                height: tableHeight()
            })
        })
    }

})
function getRealStatusCount(){
    $.ajax({
        url:'/index.php/Ajax/getRealStatusCount/',
        success: function(data){
            $('#count_real_no').html(data.real_no)
            $('#count_real_already').html(data.real_already)
        }
    })
}
function noTableLoad(tab){
    var status = 1;
    $('#'+tab).bootstrapTable({
        url: './realAudit',//数据源
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
            params.other  = "list";
            params.status = status;
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: false,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#button",//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:true,//是否启用排序
        sortOrder:'apply_time asc',//默认排序
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
					return "<input type=\"checkbox\" name =\"all"+status+"\" class=\"checkboxstyle\" id = \""+status+"-"+row.id+"-"+index+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+status+"-"+row.id+"-"+index+"\"></label>";
                }
            },
            {
                title: "昵称",//标题
                field: "nick_name",//键名
                align: "center",//水平
				valign: "middle",//垂直
                formatter: function (value, row, index) {
                    return "<a class='edit-a-color-1' href=\"javascript:void(0)\" onclick=\"getUserInfo(" + row.em_user_id + ")\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">" + value + "</a>";
                }
            },
            {
                field: "type",
                title: "性别",
                align:'center',
				valign: "middle",//垂直
                formatter: function (value, row, index) {
                    if(row.sex==1){
                        return '男';
                    }else{
                        return '女';
                    }
                }
            },
            {
                field: "age",
                title: "年龄",
                align:'center',
				valign: "middle"//垂直

            },

            {
                field: "education_name",
                title: "学历",
                align:'center',
				valign: "middle"//垂直

            },
            {
                field: "work_status",
                title: "在校/工作",
                align:'center',
				valign: "middle",//垂直
                formatter: function (value, row, index) {
                    if(row.work_status==1){
                        return '工作';
                    }else{
                        return '在校';
                    }
                }

            },
            {
                field: "tell",
                title: "手机号码",
                align:'center',
				valign: "middle"//垂直

            },
            {
                field: "reg_time_name",
                title: "注册时间",
                align:'center',
				valign: "middle"//垂直

            },
            {
                field: "true_name",
                title: "真实姓名",
                align:'center',
				cellStyle:highLight,
				valign: "middle"//垂直

            },
            {
                field: "card_num",
                title: "身份证号",
                align:'center',
				cellStyle:highLight,
				valign: "middle"//垂直

            },
			{
                field: "apply_time",
                title: "申请时间",
                align:'center',
				valign: "middle"//垂直
            },
            {
                field: "status",
                title: "操作",
                align:'center',
				valign: "middle",//垂直
                formatter: function (value, row, index) {
                    var html = '';
                    html = "<a class='edit-a-color-5' href=\"javascript:void(0)\" onclick=\"userPictureView('" + row.attach_ids + "')\" data-type=\"text\" data-pk=\"" + row.attach_ids + "\">查看照片&nbsp;&nbsp;&nbsp;</a>";
                    html += "<a class='edit-a-color-1' href=\"javascript:void(0)\" onclick=\"passRealAudit(" + row.audit_id + ")\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.audit_id + "\">通过认证&nbsp;&nbsp;&nbsp;</a>";
                    html += "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"denyRealAudit(" + row.audit_id + ")\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.audit_id + "\">拒绝认证</a>";

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

function alreadyTableLoad(tab){
    var status = 2;
    $('#'+tab).bootstrapTable({
        url: './realAudit',//数据源
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
            params.other  = "list";
            params.status = status;
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: false,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#button",//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:false,//是否启用排序
        sortOrder:'id asc',//默认排序
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
					return "<input type=\"checkbox\" name =\"all"+status+"\" class=\"checkboxstyle\" id = \""+status+"-"+row.id+"-"+index+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+status+"-"+row.id+"-"+index+"\"></label>";
                }
            },
            {
                title: "昵称",//标题
                field: "nick_name",//键名
                align: "center",//水平
				valign: "middle",//垂直
                formatter: function (value, row, index) {
                    return "<a class='edit-a-color-1' href=\"javascript:void(0)\" onclick=\"getUserInfo(" + row.em_user_id + ")\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">" + value + "</a>";
                }
            },
            {
                field: "type",
                title: "性别",
                align:'center',
				valign: "middle",//垂直
                formatter: function (value, row, index) {
                    if(row.sex==1){
                        return '男';
                    }else{
                        return '女';
                    }
                }
            },
            {
                field: "age",
                title: "年龄",
                align:'center',
				valign: "middle"//垂直

            },

            {
                field: "education_name",
                title: "学历",
                align:'center',
				valign: "middle"//垂直

            },
            {
                field: "work_status",
                title: "在校/工作",
                align:'center',
				valign: "middle",//垂直
                formatter: function (value, row, index) {
                    if(row.work_status==1){
                        return '工作';
                    }else{
                        return '在校';
                    }
                }

            },
            {
                field: "tell",
                title: "手机号码",
                align:'center',
				valign: "middle"//垂直

            },
            {
                field: "reg_time_name",
                title: "注册时间",
                align:'center',
				valign: "middle"//垂直

            },
            {
                field: "true_name",
                title: "真实姓名",
                align:'center',
				valign: "middle"//垂直

            },
            {
                field: "card_num",
                title: "身份证号",
                align:'center',
				valign: "middle"//垂直

            },
			{
                field: "audit_time",
                title: "审核时间",
                align:'center',
                valign: "middle"//垂直
            },
			{
                field: "audit_username",
                title: "审核人",
                align:'center',
                valign: "middle"//垂直
            },
			{
                field: "audit_status",
                title: "审核结果",
                align:'center',
                valign: "middle",//垂直
				formatter: function (value, row, index) {
                    if(row.audit_status==1){
                        return '认证通过';
                    }else{
                        return '认证失败';
                    }
                }
            },
            {
                field: "status",
                title: "操作",
                align:'center',
				valign: "middle",//垂直
                formatter: function (value, row, index) {
                    var html = '';
                    html = "<a class='edit-a-color-5' href=\"javascript:void(0)\" onclick=\"userPictureView('" + row.attach_ids + "')\" data-type=\"text\" data-pk=\"" + row.attach_ids + "\">查看照片&nbsp;&nbsp;&nbsp;</a>";
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
function showPic(){

}
/**
 * 通过认证
 */
function passRealAudit(id){
    $.post('./passRealAudit/',{auditId:id},function (data) {
        var res=eval('('+data+')') ;
        layer.msg(res.msg,{time:500});
        $('#noTab').bootstrapTable('refresh');
        $('#alreadyTab').bootstrapTable('refresh');
        getRealStatusCount();
    })
}
/**
 * 拒绝认证
 */
function denyRealAudit(id){
    layer.open({
        type: 2,
        title: '拒绝原因',
        shadeClose: false,
        shade: 0.1,
        area: ['460px', '441px'],
        content: '/index.php/User/denyRealAudit/?auditId='+id
    });
}


