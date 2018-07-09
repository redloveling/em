/**
 * Created by Red on 2016/11/23.
 */
//增加banner
function addBanner(){
    var bannerCount = parseInt($('#bannerCount').val());
    var maxId = parseInt($('#bannerMaxId').val());
    if(bannerCount>=5){
        layer.msg('亲，最多五个哟！');
        return
    }
    bannerCount++;
    maxId++;
    var html =$('#banner_temp').html();

    html = html.replace(/bannerImage/g, "bannerImage"+maxId);
    html = html.replace(/description/g, "description"+maxId);
    //$('#bannerImage'+(bannerCount-1)).after(html);
    $('#bannerCount').before(html);
    $('#bannerCount').val(bannerCount);
    $('#bannerMaxId').val(maxId);
}
/**
 * 上传banner判断
 * @returns {boolean}
 */
function confirmBanner(){
    var bannerCount = $('#bannerCount').val();
    for(var i=1;i<=bannerCount;i++){
        if($('#image_bannerImage1_1').attr('src')==''){
            return false
        }
        if($('#image_bannerImage'+i+'_1').attr('src')){
            if($('#description'+i).val()==''){
                //layer.msg('请填写第'+i+'个banner的详情')
                //return false
            }
        }
    }
    return true
}