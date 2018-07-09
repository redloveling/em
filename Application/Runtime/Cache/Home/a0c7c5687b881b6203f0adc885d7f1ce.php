<?php if (!defined('THINK_PATH')) exit();?>
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main.css?v=1.0"/>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=097de6dbe729c5e3f7c85c96c78dd1c7&plugin=AMap.DistrictSearch"></script>

    <style type="text/css">
        #mapContainerS{
            margin-left: 140px;
            border-radius: 4px;
            width: 604px;
            border: 1px solid #dedede;
            height: 404px;
            margin-bottom: 20px;
        }
        #mapContainer{
            position: relative;
            width: 600px;
            height: 400px
        }
    </style>

    <?php foreach($areaArr as $key=>$value){ $key++;$areas = explode(',',$value);?>
        <div class="form-inline">
            <label class="left" ><?php if($key==1){?>工作区域:<?php }?></label>
            <select id='province_<?=$key?>'  style="width:155px;" class="form-control" onchange='search(this,<?=$key?>)'></select>
            <select id='city_<?=$key?>'      style="width:155px;" class="form-control" onchange='search(this,<?=$key?>)'></select>
            <select id='district_<?=$key?>'  style="width:155px;" class="form-control"onchange='search(this,<?=$key?>)'></select>
            <?php if($key!=1){?><label class="delete-options" onclick="delAreaLabel(this)"></label><?php }?>
            <label class="add-options" onclick="addAreaLabel()"></label>
            <input type="hidden" name="area_1[]" id="areas_1_<?=$key?>" value="<?=$areas[0]?>"/>
            <input type="hidden" name="area_2[]" id="areas_2_<?=$key?>" value="<?=$areas[1]?>"/>
            <input type="hidden" name="area_3[]" id="areas_3_<?=$key?>" value="<?=$areas[2]?>"/>
            <input type="hidden"  id="edit_area_1_<?=$key?>" value="<?=$areas[0]?>"/>
            <input type="hidden"  id="edit_area_2_<?=$key?>" value="<?=$areas[1]?>"/>
            <input type="hidden"  id="edit_area_3_<?=$key?>" value="<?=$areas[2]?>"/>
        </div>
    <?php }?>
    <input type="hidden" id="areaCount" value="<?=count($areaArr)?>">
    <input type="hidden" id="areaNum" value="<?=count($areaArr)?>">
    <div id="mapTemp" style="display: none">
        <div class="form-inline">
            <label class="left" ></label>
            <select id='province'  style="width:155px;" class="form-control" ></select>
            <select id='city'      style="width:155px;" class="form-control" ></select>
            <select id='district'  style="width:155px;" class="form-control"></select>
            <label class="delete-options" onclick="delAreaLabel(this)"></label>
            <label class="add-options" onclick="addAreaLabel()"></label>
            <input type="hidden"  id="areas_1" value=""/>
            <input type="hidden"  id="areas_2" value=""/>
            <input type="hidden"  id="areas_3" value=""/>
        </div>
    </div>
    <div id="mapContainerS">
        <div id="mapContainer"></div>
    </div>


    <!--<input type="hidden" name="area_bounds" id="area_bounds" value="<?=$areaDetail?>"/>-->


    <input type="hidden"  id="area_edit" value="<?=$areaDetail?>"/>
<script type="text/javascript">
    var t;
    function addAreaLabel(){
        var count = $('#areaCount').val()
        var num = $('#areaNum').val()
        var tempHtml = $('#mapTemp').html();
        count++;num++
        tempHtml = tempHtml.replace(/province/g, "province_"+num);
        tempHtml = tempHtml.replace(/city/g, "city_"+num);
        tempHtml = tempHtml.replace(/district/g, "district_"+num);
        tempHtml = tempHtml.replace(/areas_1/g, "areas_1_"+num);
        tempHtml = tempHtml.replace(/areas_2/g, "areas_2_"+num);
        tempHtml = tempHtml.replace(/areas_3/g, "areas_3_"+num);
        $('#mapContainerS').before(tempHtml)
        $("#province_"+num).attr('onchange','search(this,'+num+')');
        $("#city_"+num).attr('onchange','search(this,'+num+')');
        $("#district_"+num).attr('onchange','search(this,'+num+')');

        $("#areas_1_"+num).attr('name','area_1[]');
        $("#areas_2_"+num).attr('name','area_2[]');
        $("#areas_3_"+num).attr('name','area_3[]');
        getData(t,num);
        $('#areaCount').val(count)
        $('#areaNum').val(num)
    }
    function delAreaLabel(dom){
        $(dom).parent().remove();
        var count = $('#areaCount').val();
        count--;
        $('#areaCount').val(count)
    }

    var map, district, polygons = [], citycode;
    var citySelect = document.getElementById('city');
    var districtSelect = document.getElementById('district');
//    var areaSelect = document.getElementById('street');

    map = new AMap.Map('mapContainer', {
        resizeEnable: true,
//        center: [116.30946, 39.937629],
        center: [104.06667,30.66667],
        zoom: 11
    });
    //行政区划查询
    var opts = {
        subdistrict: 1,   //返回下一级行政区
        level: 'city',
        showbiz:false  //查询行政级别为 市
    };
    district = new AMap.DistrictSearch(opts);//注意：需要使用插件同步下发功能才能这样直接使用
    district.search('中国', function(status, result) {
        if(status=='complete'){
            t=result.districtList[0];
            getData(result.districtList[0],1);
            getData(result.districtList[0],2);
            getData(result.districtList[0],3);

        }
    });
    if($('#area_edit').val()){
        var areaCount = $('#areaCount').val();
        for(var i=1;i<=areaCount;i++){
            loadDisList($('#edit_area_1_'+i).val(),'city',i);
            loadDisList($('#edit_area_2_'+i).val(),'district',i);
        }


    }
    $('#area_edit').val('');
    function loadDisList(districtName,idName,id){
        console.log(idName+id)
        district.search(districtName, function(status, result) {
            if(status=='complete'){
                var subList = result.districtList[0].districtList;
                if(idName === 'district'){
                    var contentSub=new Option('不定');
                    document.querySelector('#'+idName+'_'+id).add(contentSub);
                }
                for (var i = 0, l = subList.length; i < l; i++) {
                    var name = subList[i].name;
                    var levelSub = subList[i].level;


                    contentSub=new Option(name);
                    contentSub.setAttribute("value", levelSub);

                    contentSub.center = subList[i].center;
                    contentSub.adcode = subList[i].adcode;
                    $('#edit_area_2_'+id).val()==name && contentSub.setAttribute("selected", 'true');
                    $('#edit_area_3_'+id).val()==name && contentSub.setAttribute("selected", 'true');
                    document.querySelector('#'+idName+'_'+id).add(contentSub);
                }
            }
        });
    }
    function getData(data,id) {
        var bounds = data.boundaries;
        if (bounds) {
            $('#area_bounds').val(bounds);
            for (var i = 0, l = bounds.length; i < l; i++) {
                var polygon = new AMap.Polygon({
                    map: map,
                    strokeWeight: 1,
                    strokeColor: '#CC66CC',
                    fillColor: '#CCF3FF',
                    fillOpacity: 0.5,
                    path: bounds[i]
                });
                polygons.push(polygon);
            }
            map.setFitView();//地图自适应
        }

        var subList = data.districtList;
        var level = data.level+'_'+id;
        console.log(level)
        var citySelect = document.getElementById('city_'+id);
        var districtSelect = document.getElementById('district_'+id);
        //清空下一级别的下拉列表
        if (level === 'province_'+id) {
            citySelect.innerHTML = '';
            districtSelect.innerHTML = '';
            $('#areas_2_'+id).val('');
            $('#areas_3_'+id).val('');
        } else if (level === 'city_'+id) {
            districtSelect.innerHTML = '';
            $('#areas_3_'+id).val('');

        } else if (level === 'district_'+id) {
//            areaSelect.innerHTML = '';
        }
        if (subList) {
            var contentSub =new Option('--请选择--');
            for (var i = 0, l = subList.length; i < l; i++) {

                var name = subList[i].name;
                var levelSub = subList[i].level+'_'+id;
                var cityCode = subList[i].citycode;
                if(i==0){
                    try{
                        document.querySelector('#' + levelSub).add(contentSub);
                        if(level === 'city_'+id){
                            contentSub=new Option('不定');
                            document.querySelector('#' + levelSub).add(contentSub);
                        }
                    }catch (e){

                    }

                }

                contentSub=new Option(name);
                contentSub.setAttribute("value", levelSub);
                $('#edit_area_1_'+id).val()==name && contentSub.setAttribute("selected", 'true');
                $('#edit_area_2_'+id).val()==name && contentSub.setAttribute("selected", 'true');
                $('#edit_area_3_'+id).val()==name && contentSub.setAttribute("selected", 'true');
                contentSub.center = subList[i].center;
                contentSub.adcode = subList[i].adcode;
                //.log(contentSub)
                try{
                    document.querySelector('#' + levelSub).add(contentSub);
                }catch (e){

                }
            }

        }

    }
    function search(obj,id) {
        //清除地图上所有覆盖物
        for (var i = 0, l = polygons.length; i < l; i++) {
            polygons[i].setMap(null);
        }
        var option = obj[obj.options.selectedIndex];
        var keyword = option.text; //关键字
        var adcode = option.adcode;
        var idName= obj.id.split('_');
        idName = idName[0]
        if(idName=='province'){
            $('#areas_1_'+id).val(keyword);
            $('#areas_2_'+id).val('');
            $('#areas_3_'+id).val('');
        }
        if(idName=='city'){
            $('#areas_2_'+id).val(keyword);
            $('#areas_3_'+id).val('');
        }
        if(idName=='district'){
            $('#areas_3_'+id).val(keyword);

        }
        district.setLevel(option.value); //行政区级别
        district.setExtensions('all');
        //行政区查询
        //按照adcode进行查询可以保证数据返回的唯一性
        district.search(adcode, function(status, result) {
            if(status === 'complete'){
                getData(result.districtList[0],id);
            }
        });
    }
    function setCenter(obj){
        map.setCenter(obj[obj.options.selectedIndex].center)
    }
    function addArea(districts) {
        //加载行政区划插件
        AMap.service('AMap.DistrictSearch', function() {
            var opts = {
                subdistrict: 1,   //返回下一级行政区
                extensions: 'all',  //返回行政区边界坐标组等具体信息
                level: 'district'  //查询行政级别为 市
            };
            //实例化DistrictSearch
            district = new AMap.DistrictSearch(opts);
            district.setLevel('district');
            //行政区查询
            district.search(districts, function(status, result) {
                var bounds = result.districtList[0].boundaries;
                var polygons = [];
                if (bounds) {
                    for (var i = 0, l = bounds.length; i < l; i++) {
                        //生成行政区划polygon
                        var polygon = new AMap.Polygon({
                            map: map,
                            strokeWeight: 1,
                            path: bounds[i],
                            fillOpacity: 0.7,
                            fillColor: '#CCF3FF',
                            strokeColor: '#CC66CC'
                        });
                        polygons.push(polygon);
                    }
                    map.setFitView();//地图自适应
                }
            });
        });
    }
</script>
<script type="text/javascript" src="http://webapi.amap.com/demos/js/liteToolbar.js"></script>