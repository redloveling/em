/**
 * Created by Red on 2016/10/25.
 */
$(function() {
    //根据窗口调整表格高度
    $(window).resize(function() {
        $('#channelTab').bootstrapTable('resetView', {
            height: tableHeight()
        })
    })

    $('#channelTab').bootstrapTable({
        url: './channelIndex',//数据源
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
        sortOrder:'id',//默认排序
        queryParamsType: "limit",//查询参数组织方式
        queryParams: function getParams(params) {
            params.other = "list";
            params.order=this.sortOrder;
            return params;
        },
        searchOnEnterKey: false,//回车搜索
        showRefresh: true,//刷新按钮
        //showColumns: false,//列选择按钮
        buttonsAlign: "right",//按钮对齐方式
        toolbar: "#button",//指定工具栏
        toolbarAlign: "left",//工具栏对齐方式
        sortable:true,//是否启用排序
        clickToSelect:true,//行选择

        columns: [
            {
                title: "<input type=\"checkbox\"  class=\"checkboxstyle\"  id=\"all\" onclick=\"checkall(this)\" /><label class=\"checklabelstyle\"  for=\"all\"></label>",
                field: "select",
                width: 40,//宽度
                align: "center",//水平
                valign: "middle",//垂直
				formatter: function (value, row, index) {
					return "<input type=\"checkbox\"  name =\"all\" class=\"checkboxstyle\"  id=\""+row.id+"\" onclick=\"checkitem(this)\" /><label class=\"checklabelstyle\" for=\""+row.id+"\"></label>";
              }
            },
            {
                title: "渠道名称",//标题
                field: "name",//键名
                align: "center",//水平
                order: "desc"
            },
            {
                field: "tell",
                title: "手机号码",
                align:'center'
            },
            {
                field: "create_time_name",
                title: "创建时间",
                align:'center'
            },
            {
                field: "extension_code",
                title: "推广码",
                align:'center'

            },
            {
                field: "tell",
                title: "二维码",
                align:'center',
                formatter: function (value, row, index) {
                    var html ='';
                    html +="<a class='edit-a-color' href='javascript:void(0)' onclick='showUserQrCode("+row.id+")'>查看</a> &nbsp;&nbsp;";
                    html +="<a class='edit-a-color-1'href='javascript:void(0)' onclick='downloadQrCode("+row.id+")'>下载</a> &nbsp;&nbsp;";
                    return html;
                }
            },
            {
                field: "direct_count",
                title: "直接推广人数",
                align:'center',
                sortable:true,
                formatter:function(value,row,index){
                    return '<a class="edit-a-color-2" href="javascript:void(0)" onclick="directDetail('+row.id+')">'+row.direct_count+'</a>';
                }
            },
            {
                field: "indirect_count",
                title: "间接推广人数",
                align:'center',
                order:'desc',
                sortable:true
            },
            {
                field: "status_name",
                title: "渠道状态",
                align:'center'
            },
            {
                field: "status_name",
                title: "操作",
                align:'center',
                formatter: function (value, row, index) {
                    return "<a class='edit-a-color' href=\"javascript:void(0)\" onclick=\"editChannel(" + row.id + ")\" name=\"UserName\" data-type=\"text\" data-pk=\"" + row.id + "\">编辑</a>";

                }
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
    $('#forbidden').click(function () {
        var id=getIdSelections();
        handleData(id,2)
    });

    $('#enable').click(function () {
        var id = getIdSelections();
        handleData(id,1)
    });

    $('#add').click(function () {
        layer.open({
            type: 2,
            title: '新增渠道商',
            shadeClose: false,
            shade: 0.1,
            area: ['380px', '500px'],
            content: '/index.php/Extension/addChannel/'
        });

    });
    $('#export').click(function () {
        window.location.href='/index.php/Extension/exportChannel/'
    });
})
//表格高度
function tableHeight() {
    return $(window).height() - 200;
}
//获取选择数据id
function getIdSelections() {
	var temp = [];
    $("input[name='all']:checked").each(function(i){
          temp.push($(this)[0].id);
    });
	return temp;
}

function handleData(id,type){
    $.post('/index.php/Extension/handleData/',{type:type,ids:id},function (data) {
        var res=eval('('+data+')') ;
        layer.msg(res.msg,{time:1000});
        $('#channelTab').bootstrapTable('refresh');
    })
}
function showUserQrCode(cId){
    layer.open({
        type: 2,
        title: '查看二维码',
        shadeClose: false,
        shade: 0.1,
        area: ['400px', '400px'],
        content: '/index.php/Extension/showQrCode/?cId='+cId
    });
}
function downloadQrCode(cId){
    window.location.href='/index.php/Extension/downloadQrCode/?cId='+cId
}
function editChannel(cId){
    layer.open({
        type: 2,
        title: '编辑渠道商',
        shadeClose: false,
        shade: 0.1,
        area: ['380px', '500px'],
        content: '/index.php/Extension/editChannel/?cId='+cId
    });
}
function directDetail(cId){
    layer.open({
        type: 2,
        title: '直接推广详情',
        shadeClose: false,
        shade: 0.1,
        area: ['850px', '600px'],
        content: '/index.php/Extension/directDetail/?cId='+cId+'&type=1'
    });
}
