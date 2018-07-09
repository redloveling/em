<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
    .file {
        position: relative;
        display: inline-block;
        background: #ffffff;
        border-radius: 4px;
        padding: 1px 4px;
        overflow: hidden;
        color: #0000ff;
        text-decoration: none;
        text-indent: 0;
        line-height: 20px;
        margin-left: -10px;

    }
    .file input {
        position: absolute;
        font-size: 60px;
        right: 0;
        top: 0;
        opacity: 0;
    }
    .file:hover {
        color: #004974;
        text-decoration: none;
    }
    .file_span {
        width:80px; background:#ffffff;color: #0000ff;border: 1px solid #99D3F5;
    }
    .file_span:hover{
        background: #AADFFD;
        border-color: #78C3F3;
        color: #004974;
        text-decoration: none;
    }
    .file_a_name {
        position: relative;
        display: inline-block;
        background: #ffffff;
        border-radius: 4px;
        padding: 4px 12px;
        overflow: hidden;
        text-decoration: none;
        text-indent: 0;
        line-height: 24px;
		left:740px;
		top:-156px;
    }
    .table{
        margin-left: -20px;
    }
    .table tbody tr td{
        border-top:0px ;
    }
	.banner_upload
	{ width:134px; height:32px; overflow:hidden; background:url('/Public/images/banner/btn_upload.png');}
	.file:hover .banner_upload
	{background:url('/Public/images/banner/btn_upload_hover.png');}
	.banner_add
	{ width:170px; height:32px; overflow:hidden; background:url('/Public/images/banner/btn_add.png');}
	.file:hover .banner_add
	{background:url('/Public/images/banner/btn_add_hover.png');}
	.banner_delete_a
	{ display:block; width:76px; height:32px;  overflow:hidden; position:relative; left:586px; top:-80px; }
	.banner_delete
	{ width:76px; height:32px;  overflow:hidden; background:url('/Public/images/banner/btn_delete.png');}
	.banner_delete_a:hover .banner_delete
	{width:76px; height:32px; background:url('/Public/images/banner/btn_delete_hover.png');}
</style>
<div>

    <table border=0  class="table " style="margin-bottom: -10px"  >

        <input type="hidden" id="file_num_<?=$params['file_key']?>" name="file_num_<?=$params['file_key']?>" value="1"/>

        <tr>
            <td>
                <div style="padding-left: 14px; height:230px;">
                    <div class=" file_my form-inline">
                        <img src="<?=$banner['image']?>" onerror="this.src='/Public/images/no_image.png'" id="image_<?=$params['file_key']?>_1" height="202" width="552" style="background-color: #f6f9fe">
                        <a href="javascript:void(0);" class="file" style="margin-left: 25px">
                            <?php if($banner['image']){?>
                            <div class="banner_upload"></div>
                            <?php }else{?>
                            <div class="banner_add"></div>
                            <?php }?>
                            <input type="file"  onchange="get_file_name(this,'<?=$params['file_key']?>',1)"  name="<?=$params['file_key']?>[]" id="<?=$params['file_key']?>">
                        </a>
                        <?php if($banner['id']){?>
                        <a href="javascript:void(0);" class="banner_delete_a" onclick="delete_banner_by_id(<?=$banner['id']?>)"><div class="banner_delete" ></div></a>
                        <?php }?>
                        <a type="text" id="input_file_<?=$params['file_key']?>_1" class="file_a_name"> </a>
                        <input type="hidden" name="file_url_<?=$params['file_key']?>_1" id="file_url_<?=$params['file_key']?>_1" value="" />
                    </div>
                </div>
            </td>
        </tr>

    </table>
    <div id="file_temp" style="display: none">
        <div>
            <div   class="col-sm-9 col-xs-8 file_my">
                <a href="javascript:void(0);" class="file">浏览
                    <input type="file"  onchange="get_file_name()"  name="fileName" id="file_id">
                </a>

                <a type="text" id="input_file" class="file_a_name"> </a>
                <input type="hidden" id="file_url" name="file_url" value="" />
            </div>
            <span   id="deleteFile"  class="file" onclick="deleteFile($(this))" >删除</span>

        </div>
    </div>
</div>
<script type="text/javascript">
    function get_file_name(obj,k,k1){

        var p = new Array();
        p = obj.value.split('\\');

        $('#input_file_'+k+'_'+k1).html(p[p.length - 1]);
        var file_name = obj.name.replace('[]','');
        //ajax异步上传
        $.ajaxFileUpload({
            url:'/index.php/Ajax/fileUpload/type/banner/file_name/'+file_name,//始终post不过去数据，暂时先get过去吧
            secureuri:false,
            fileElementId:obj.id, //文件选择框的id属性
            dataType: 'json', //服务器返回的格式，可以是json、xml
            success:function(res){
                if(res.status==1 && res.data.url){
                    var html = '<span>';
//                    html += '<img src="'+res.data.url+'">';
                    html += '<input type="hidden" name="'+k+'_name[]" value="'+res.data.name+'"/>';
                    html += '<input type="hidden" name="'+k+'_url[]" value="'+res.data.url+'"/>';
                    html += '<input type="hidden" name="'+k+'_fileSize[]" value="'+res.data.fileSize+'"/>';
                    html += '<input type="hidden" name="'+k+'_fileType[]" value="'+res.data.fileType+'"/>';
                    $('#input_file_'+k+'_'+k1).append(html);
                    $('#file_url_'+k+'_'+k1).val(res.data.url);
                    $('#image_'+k+'_'+k1).attr("src",res.data.url);
                }else{
                    $('#input_file_'+k+'_'+k1).append('');
                    $.messager.alert('警告', '附件上传失败，请重新上传', 'info');
                }
            }
        });
    }
    function addFile(dom,k){
        var file_num = parseInt($("#file_num_"+k).val());
        var html=$("#file_temp").html();
        html = html.replace(/input_file/g, "input_file_"+k +'_'+file_num);
        html = html.replace(/file_url/g, "file_url_"+k +'_'+file_num);
        html = html.replace(/file_id/g, k + '_'+file_num);
        html = html.replace(/fileName/g, k +'[]');
        html = '<tr> <td>'+html+'</td></tr>';

        $(dom).parent('div').parent('td').parent('tr').after(html);
        $('#'+k + '_'+file_num).attr('onchange','get_file_name(this,\''+k+'\','+file_num+')');

        file_num++;

        $("#file_num_"+k ).val(file_num);

        //$("#deleteFile"+k + file_num).attr('onclick','deleteFile('+k+','+file_num+')');

    }
    function deleteFile(dom,k){
        var file_num = parseInt($("#file_num_"+k).val());
        $("#file_num_"+k).val(file_num-1);
        $(dom).parent('div').parent('td').parent('tr').remove()
    }
	//删除banner
	function delete_banner_by_id(imgId){	
    	$.post('/index.php/Banner/deleteBanner/',{id:imgId},function (data) {
        	var res=eval('('+data+')') ;
			$(".banner"+imgId).remove();
        	layer.msg(res.msg);
    	})
	}

    //jq ajaxUpload
    jQuery.extend({

        createUploadIframe: function(id, uri)
        {
            //create frame
            var frameId = 'jUploadFrame' + id;

            if(window.ActiveXObject) {
                var io = document.createElement('<iframe id="' + frameId + '" name="' + frameId + '" />');
                if(typeof uri== 'boolean'){
                    io.src = 'javascript:false';
                }
                else if(typeof uri== 'string'){
                    io.src = uri;
                }
            }
            else {
                var io = document.createElement('iframe');
                io.id = frameId;
                io.name = frameId;
            }
            io.style.position = 'absolute';
            io.style.top = '-1000px';
            io.style.left = '-1000px';

            document.body.appendChild(io);

            return io
        },
        createUploadForm: function(id, fileElementId)
        {
            //create form
            var formId = 'jUploadForm' + id;
            var fileId = 'jUploadFile' + id;
            var form = $('<form  action="" method="POST" name="' + formId + '" id="' + formId + '" enctype="multipart/form-data"></form>');
            var oldElement = $('#' + fileElementId);
            var newElement = $(oldElement).clone();
            $(oldElement).attr('id', fileId);
            $(oldElement).before(newElement);
            $(oldElement).appendTo(form);
            //set attributes
            $(form).css('position', 'absolute');
            $(form).css('top', '-1200px');
            $(form).css('left', '-1200px');
            $(form).appendTo('body');
            return form;
        },

        ajaxFileUpload: function(s) {
            // TODO introduce global settings, allowing the client to modify them for all requests, not only timeout
            s = jQuery.extend({}, jQuery.ajaxSettings, s);
            var id = new Date().getTime()
            var form = jQuery.createUploadForm(id, s.fileElementId);
            var io = jQuery.createUploadIframe(id, s.secureuri);
            var frameId = 'jUploadFrame' + id;
            var formId = 'jUploadForm' + id;
            // Watch for a new set of requests
            if ( s.global && ! jQuery.active++ )
            {
                jQuery.event.trigger( "ajaxStart" );
            }
            var requestDone = false;
            // Create the request object
            var xml = {}
            if ( s.global )
                jQuery.event.trigger("ajaxSend", [xml, s]);
            // Wait for a response to come back
            var uploadCallback = function(isTimeout)
            {
                var io = document.getElementById(frameId);
                try
                {
                    if(io.contentWindow)
                    {
                        xml.responseText = io.contentWindow.document.body?io.contentWindow.document.body.innerHTML:null;
                        xml.responseXML = io.contentWindow.document.XMLDocument?io.contentWindow.document.XMLDocument:io.contentWindow.document;

                    }else if(io.contentDocument)
                    {
                        xml.responseText = io.contentDocument.document.body?io.contentDocument.document.body.innerHTML:null;
                        xml.responseXML = io.contentDocument.document.XMLDocument?io.contentDocument.document.XMLDocument:io.contentDocument.document;
                    }
                }catch(e)
                {
                    jQuery.handleError(s, xml, null, e);
                }
                if ( xml || isTimeout == "timeout")
                {
                    requestDone = true;
                    var status;
                    try {
                        status = isTimeout != "timeout" ? "success" : "error";

                        // Make sure that the request was successful or notmodified
                        if ( status != "error" )
                        {
                            // process the data (runs the xml through httpData regardless of callback)
                            var data = jQuery.uploadHttpData( xml, s.dataType );
                            // If a local callback was specified, fire it and pass it the data
                            if ( s.success )
                                s.success( data, status );

                            // Fire the global callback
                            if( s.global )
                                jQuery.event.trigger( "ajaxSuccess", [xml, s] );
                        } else
                            jQuery.handleError(s, xml, status);
                    } catch(e)
                    {
                        status = "error";
                        jQuery.handleError(s, xml, status, e);
                    }

                    // The request was completed
                    if( s.global )
                        jQuery.event.trigger( "ajaxComplete", [xml, s] );

                    // Handle the global AJAX counter
                    if ( s.global && ! --jQuery.active )
                        jQuery.event.trigger( "ajaxStop" );

                    // Process result
                    if ( s.complete )
                        s.complete(xml, status);

                    jQuery(io).unbind()

                    setTimeout(function()
                    {    try
                    {
                        $(io).remove();
                        $(form).remove();

                    } catch(e)
                    {
                        jQuery.handleError(s, xml, null, e);
                    }

                    }, 100)

                    xml = null

                }
            }
            // Timeout checker
            if ( s.timeout > 0 )
            {
                setTimeout(function(){
                    // Check to see if the request is still happening
                    if( !requestDone ) uploadCallback( "timeout" );
                }, s.timeout);
            }
            try
            {
                // var io = $('#' + frameId);
                var form = $('#' + formId);
                $(form).attr('action', s.url);
                $(form).attr('method', 'POST');
                $(form).attr('target', frameId);
                if(form.encoding)
                {
                    form.encoding = 'multipart/form-data';
                }
                else
                {
                    form.enctype = 'multipart/form-data';
                }
                $(form).submit();

            } catch(e)
            {
                jQuery.handleError(s, xml, null, e);
            }
            if(window.attachEvent){
                document.getElementById(frameId).attachEvent('onload', uploadCallback);
            }
            else{
                document.getElementById(frameId).addEventListener('load', uploadCallback, false);
            }
            return {abort: function () {}};

        },

        uploadHttpData: function( r, type ) {
            var data = !type;
            data = type == "xml" || data ? r.responseXML : r.responseText;
            // If the type is "script", eval it in global context
            if ( type == "script" )
                jQuery.globalEval( data );
            // Get the JavaScript object, if JSON is used.
            if ( type == "json" )
                eval( "data = " + data );
            // evaluate scripts within html
            if ( type == "html" )
                jQuery("<div>").html(data).evalScripts();
            //alert($('param', data).each(function(){alert($(this).attr('value'));}));
            return data;
        },
        handleError : function(s, xhr, status, e) {
            if (s.error) {
                s.error.call(s.context || s, xhr, status, e);
            }
            if (s.global) {
                (s.context ? jQuery(s.context) : jQuery.event).trigger(
                        "ajaxError", [ xhr, s, e ]);
            }
        }
    })
</script>