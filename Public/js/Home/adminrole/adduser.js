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

    $('#mytab_frame').bootstrapTable({
        url: '/index.php/AdminRole/addUser/',//数据源
        dataField: "rows",//服务端返回数据键值 就是说记录放的键值是rows，分页时使用总记录数的键值为total
        height: 550,//高度调整
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
            params.roleId = $('#roleId').val();
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
        singleSelect:false,//是否单选
        maintainSelected:true,//翻页后保留选择
        expoortDataType:'basic',//导出数据格式，
        selectItemName:'user',
        //checkboxHeader:true,
            columns: [
            {
				title: "<input type=\"checkbox\"  class=\"checkboxstyle\"  id=\"all\" onclick=\"checkall(this)\" /><label class=\"checklabelstyle\"  for=\"all\"></label>",
                field: "select",
                width: 40,//宽度
                align: "center",//水平
                valign: "middle",//垂直
				formatter: function (value, row, index) {
					if(row.selects){
						return "<input type=\"checkbox\"  name =\"all\" class=\"checkboxstyle\"  id=\""+row.id+"\" checked=\"checked\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+row.id+"\"></label>";
					}else{
						return "<input type=\"checkbox\"  name =\"all\" class=\"checkboxstyle\"  id=\""+row.id+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+row.id+"\"></label>";
					}
                }

            },
            {
                title: "用户名",//标题
                field: "username",//键名
                align: "center"//水平
            },
            {
                field: "business_name",
                title: "所属公司",
                align:'center'
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
//获取选择数据id
/*function getIdSelections() {
    return $.map($('#mytab_frame').bootstrapTable('getSelections'),function (row) {
        return row.id
    })
}*/
//获取选择数据id(新样式)
function getIdSelections() {
	var temp = [];
    $("input[name='all']:checked").each(function(i){
          temp.push($(this)[0].id);
    });
	return temp;
}
function saveUser(){
    var id=getIdSelections();
    var roleId = $('#roleId').val();
    var businessId = $('#businessId').val();
    $.ajax({
        url:'/index.php/AdminRole/addUser/',
        data:{ids:id,roleId:roleId,businessId:businessId,other:'save'},
        type:'post',
        success:function(data){
            var res=eval('('+data+')') ;
            layer.msg(res.msg);
            $('#mytab').bootstrapTable('refresh');
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            parent.layer.close(index); //再执行关闭
        }
    })

}



