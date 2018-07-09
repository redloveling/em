<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/10/14
 * Time: 14:52
 */
namespace Home\Widget;
use Think\Controller;

class MapWidget extends Controller {
    public function index($workArea,$workAreaDetail){
        $this->assign('areaArr',explode(';',$workArea));
        $this->assign('areaDetail',$workAreaDetail);
        $this->display('Widget:map/map');
    }
}