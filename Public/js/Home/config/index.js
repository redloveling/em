/**
 * Created by Red on 2016/10/25.
 */
$(function() {
    //根据窗口调整表格高度
    var tableNames = $('#tableNames').val();
    var tableArr = tableNames.split(',');
    for(var i=0;i<tableArr.length;i++){
        tableLoad(tableArr[i]+'Tab',tableArr[i]);
        $(window).resize(function() {
            $('#'+tableArr[i]+'Tab').bootstrapTable('resetView', {
                height: tableHeight()
            })
        })
    }

})
function messageTempTab(tableId,tableName){
    $('#'+tableId).bootstrapTable({
        url: './',//数据源
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        //height: tableHeight(),//高度调整
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
            params.other = "list";
            params.tableName = tableName;

            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: false,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#button-"+tableName,//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:false,//是否启用排序
        //sortOrder:'id asc',//默认排序
        showExport:false,//导出
        clickToSelect:true,//行选择
        expoortDataType:'basic',//导出数据格式，
        columns: [
            {
                title: "<input type=\"checkbox\"  class=\"checkboxstyle\"  id=\"all"+tableName+"\" onclick=\"checkall(this)\" /><label class=\"checklabelstyle\"  for=\"all"+tableName+"\"></label>",
                field: "select",
                width: 40,//宽度
                align: "center",//水平
                valign: "middle",//垂直
				formatter: function (value, row, index) {
					return "<input type=\"checkbox\" name =\"all"+tableName+"\" class=\"checkboxstyle\"  id=\""+tableName+"-"+row.id+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+tableName+"-"+row.id+"\"></label>";
                }
            },
            {
                title: "消息通知",//标题
                field: "category_name",//键名
                align: "center"
            },
            {
                title: "消息类型",//标题
                field: "type",//键名
                align: "center",//水平
                formatter: function (value, row, index) {
                    if(row.type==1){
                        return '系统消息'
                    }
                    if(row.type==2){
                        return '任务消息'
                    }
                    if(row.type==3){
                        return '用户留言'
                    }
                }
            },
            {
                field: "message",
                title: "具体文案",
                align:'center'
            },
            //{
            //    field: "status",
            //    title: "状态",
            //    align:'center',
            //    formatter: function (value, row, index) {
            //        if(row.status==1){
            //            return '<label style="color: green">启用</label>'
            //        }else{
            //            return '<font style="color: #ff0000">禁用</font>'
            //        }
            //    }
            //},
            {
                field: "tt",
                title: "操作",
                align:'center',
                formatter: function (value, row, index) {
                    return "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"configEdit(" + row.id + ",'"+tableName+"')\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">编辑</a>";

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
function workAreaTab(tableId,tableName){
    $('#'+tableId).bootstrapTable({
        url: './',//数据源
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        //height: tableHeight(),//高度调整
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
            params.other = "list";
            params.tableName = tableName;

            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: false,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#button-"+tableName,//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:false,//是否启用排序
        //sortOrder:'id asc',//默认排序
        showExport:false,//导出
        clickToSelect:true,//行选择
        expoortDataType:'basic',//导出数据格式，
        columns: [
            {
				 title: "<input type=\"checkbox\"  class=\"checkboxstyle\"  id=\"all"+tableName+"\" onclick=\"checkall(this)\" /><label class=\"checklabelstyle\"  for=\"all"+tableName+"\"></label>",
                field: "select",
                width: 40,//宽度
                align: "center",//水平
                valign: "middle",//垂直
				formatter: function (value, row, index) {
					return "<input type=\"checkbox\" name =\"all"+tableName+"\" class=\"checkboxstyle\"  id=\""+tableName+"-"+row.id+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+tableName+"-"+row.id+"\"></label>";
                }
            },
            {
                title: "名称",//标题
                field: "name",//键名
                align: "center",//水平
                formatter: function (value, row, index) {
                    if(row.type!=3){
                        return "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"getNextArea('" + tableName + "',"+row.id+")\" >" + value + "</a>";
                    }
                    return value;
                }
            },
            {
                title: "类型",//标题
                field: "type",//键名
                align: "center",//水平
                formatter: function (value, row, index) {
                    if(row.type==1){
                        return '省'
                    }
                    if(row.type==2){
                        return '市'
                    }
                    if(row.type==3){
                        return '区'
                    }
                }
            },
            {
                field: "status",
                title: "状态",
                align:'center',
                formatter: function (value, row, index) {
                    if(row.status==1){
                        return '<label style="color: green">启用</label>'
                    }else{
                        return '<font style="color: #ff0000">禁用</font>'
                    }
                }
            },
            {
                field: "tt",
                title: "操作",
                align:'center',
                formatter: function (value, row, index) {
                    return "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"configEdit(" + row.id + ",'"+tableName+"')\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">编辑</a>";

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
function versionTab(tableId,tableName){
    $('#'+tableId).bootstrapTable({
        url: './',//数据源
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        //height: tableHeight(),//高度调整
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
            params.other = "list";
            params.tableName = tableName;

            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: false,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#button-"+tableName,//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:false,//是否启用排序
        //sortOrder:'id asc',//默认排序
        showExport:false,//导出
        clickToSelect:true,//行选择
        expoortDataType:'basic',//导出数据格式，
        columns: [
            {
                title: "<input type=\"checkbox\"  class=\"checkboxstyle\"  id=\"all"+tableName+"\" onclick=\"checkall(this)\" /><label class=\"checklabelstyle\"  for=\"all"+tableName+"\"></label>",
                field: "select",
                width: 40,//宽度
                align: "center",//水平
                valign: "middle",//垂直
                formatter: function (value, row, index) {
                    return "<input type=\"checkbox\" name =\"all"+tableName+"\" class=\"checkboxstyle\"  id=\""+tableName+"-"+row.id+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+tableName+"-"+row.id+"\"></label>";
                }
            },
            {
                title: "名称",//标题
                field: "name",//键名
                align: "center"//水平
            },
            {
                title: "关键字",//标题
                field: "val",//键名
                align: "center"//水平
            },
            {
                title: "版本号",//标题
                field: "code",//键名
                align: "center"//水平
            },
            {
                title: "路径",//标题
                field: "path",//键名
                align: "center"//水平
            },
            {
                field: "status",
                title: "状态",
                align:'center',
                formatter: function (value, row, index) {
                    if(row.status==1){
                        return '<label style="color: green">启用</label>'
                    }else{
                        return '<font style="color: #ff0000">禁用</font>'
                    }
                }
            },
            {
                field: "tt",
                title: "操作",
                align:'center',
                formatter: function (value, row, index) {
                    return "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"configEdit(" + row.id + ",'"+tableName+"')\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">编辑</a>";

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
function tableLoad(tableId,tableName){
    if(tableName=='tb_work_area'){
        workAreaTab(tableId,tableName);
        return
    }
    if(tableName=='message_template'){
        messageTempTab(tableId,tableName);
        return
    }
    if(tableName=='tb_version'){
        versionTab(tableId,tableName);
        return
    }
    $('#'+tableId).bootstrapTable({
        url: './',//数据源
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        //height: tableHeight(),//高度调整
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
            params.other = "list";
            params.tableName = tableName;
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        showColumns: false,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#button-"+tableName,//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:false,//是否启用排序
        //sortOrder:'id asc',//默认排序
        showExport:false,//导出
        clickToSelect:true,//行选择
        expoortDataType:'basic',//导出数据格式，
        columns: [
            {
                 title: "<input type=\"checkbox\"  class=\"checkboxstyle\"  id=\"all"+tableName+"\" onclick=\"checkall(this)\" /><label class=\"checklabelstyle\"  for=\"all"+tableName+"\"></label>",
                field: "select",
                width: 40,//宽度
                align: "center",//水平
                valign: "middle",//垂直
				formatter: function (value, row, index) {
					return "<input type=\"checkbox\" name =\"all"+tableName+"\" class=\"checkboxstyle\"  id=\""+tableName+"-"+row.id+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+tableName+"-"+row.id+"\"></label>";
                }
            },
            {
                title: "名称",//标题
                field: "name",//键名
                align: "center"
            },

            {
                field: "status",
                title: "状态",
                align:'center',
                formatter: function (value, row, index) {
                    if(row.status==1){
                        return '<label style="color: green">启用</label>'
                    }else{
                        return '<font style="color: #ff0000">禁用</font>'
                    }
                }
            },
            {
                field: "tt",
                title: "操作",
                align:'center',
                formatter: function (value, row, index) {
                    return "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"configEdit(" + row.id + ",'"+tableName+"')\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">编辑</a>";

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
/*function getIdSelections(tab) {
    return $.map($('#'+tab).bootstrapTable('getSelections'),function (row) {
        return row.id
    })
}*/
function getIdSelections(tab) {
	var temp = [];
    $("#"+tab+"Tab"+" input[name='all"+tab+"']:checked").each(function(i){
		 var id = ($(this)[0].id).split('-');
         temp.push(id[1]);
    });
	return temp;
}

function handleData(id,type,tab){
    $.post('./handleData/',{type:type,ids:id,tableName:tab},function (data) {
        var res=eval('('+data+')') ;
        layer.msg(res.msg);
        $('#'+tab+'Tab').bootstrapTable('refresh');
    })
}
/**
 * 添加
 * @param tab
 */
function configAdd(tab){
    var height = tab=='tb_work_area'?'550px':'500px';
    layer.open({
        type: 2,
        title: '新增',
        shadeClose: false,
        shade: 0.1,
        area: ['380px', height],
        content: '/index.php/Config/add/?tableName='+tab
    });
}
/**
 * 禁用
 * @param tab
 */
function configForbidden(tab){
    var id=getIdSelections(tab);
    handleData(id,2,tab)
}
/**
 * 启用
 * @param tab
 */
function configEnable(tab){
    var id=getIdSelections(tab);
    handleData(id,1,tab)
}
/**
 * 删除
 * @param tab
 */
function configDelete(tab){
    var id=getIdSelections(tab);
    handleData(id,0,tab)
}
/**
 * 编辑
 * @param id
 * @param tab
 */
function configEdit(id,tab){
    var height = tab=='tb_work_area'?'550px':'500px';
    layer.open({
        type: 2,
        title: '编辑',
        shadeClose: false,
        shade: 0.1,
        area: ['380px', height],
        content: '/index.php/Config/edit/id/'+id +'/tableName/'+tab//iframe的url
    });
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
function getNextArea(tabName,id) {

    $('#'+tabName+'Tab').bootstrapTable('refresh', {url: './index/?id='+id+''})
}