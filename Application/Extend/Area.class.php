<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/12/29
 * Time: 10:52
 */
namespace Extend;
class Area
{
    /**
     * 三级行政区域
     * @author Red
     * @date 2016年12月29日11:03:20
     * @param $province
     * @param $city
     * @param $district
     * @return int
     */
    public function insetArea($province, $city, $district)
    {
        $areaModel    = M('tb_work_area');
        $provinceInfo = $areaModel->where(array('name' => $province, 'type' => 1))->find();
        if ($provinceInfo) {
            $provinceId = $provinceInfo['id'];
        } else {
            $provinceId = $areaModel->add(array('type' => 1, 'name' => $province, 'create_time' => time()));
        }

        $cityInfo = $areaModel->where(array('name' => $city, 'pid' => $provinceId, 'type' => 2))->find();
        if ($cityInfo) {
            $cityId = $cityInfo['id'];
        } else {
            $cityId = $areaModel->add(array('pid' => $provinceId, 'type' => 2, 'name' => $city, 'create_time' => time()));
        }
        $districtInfo = $areaModel->where(array('name' => $district, 'pid' => $cityId, 'type' => 3))->find();
        if (!$districtInfo) {
            $districtId = $areaModel->add(array('pid' => $cityId, 'type' => 3, 'name' => $district, 'create_time' => time()));

        }
        return $districtId;
    }
    public function test(){
        print_r(1111);
    }
}

?>