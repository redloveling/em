/**
 * Created by Red on 2017/1/24.
 */
/**
 * 搜索
 * @param tableName
 */
function tableRefresh(tableName){

    var status = $('#status').val();
    var start_time = $('#start_time').val();
    var end_time = $('#end_time').val();
    var selectName=$('#selectList').val();
    var keyWord = $('#keyWord').val();
    var taskId = $('#taskId').val();
    $('#'+tableName).bootstrapTable('refresh',{query:{taskId:taskId,search_status:status,start_time:start_time,end_time:end_time,selectName:selectName,keyWord:keyWord}})
}
function resetButton(ids,tableName){
    $("#search-tool select:first").selectpicker('val', ids);
    $("#search-tool select:last").selectpicker('val', 'username');
    $('#start_time').val('');
    $('#end_time').val('');
    $('#keyWord').val('');
    $('#'+tableName).bootstrapTable('refresh')
}