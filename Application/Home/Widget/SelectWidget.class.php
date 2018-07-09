<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/10/14
 * Time: 14:52
 */
namespace Home\Widget;

use Think\Controller;

/**
 * 下拉选择
 * Class SelectWidget
 * @package Home\Widget
 */
class SelectWidget extends Controller
{

    public function workAreaSingle($tableName, $selectName, $selected = 0, $where = array())
    {
        $model           = M($tableName);
        $where['status'] = 1;
        $list            = $model->where($where)->select();
        $this->assign('selectName', $selectName);
        $this->assign('selected', $selected);
        $this->assign('list', $list);
        $this->display('Widget:select/workAreaSingle');
    }

    /**
     * 工作区域
     * @author Red
     * @date 2016年12月5日15:24:12
     * @param $selectFirst
     * @param int $selectSecond
     * @param int $selectThird
     */
    public function workArea($selectFirst, $selectSecond = 0, $selectThird = 0, $widgetName = '')
    {
        $model      = M('tb_work_area');
        $firstList  = $model->where(array('pid' => 0, 'type' => 1))->select();
        $secondList = $model->where(array('type' => 2))->select();
        $thirdList  = $model->where(array('type' => 3))->select();
        $this->assign('widgetName', $widgetName);
        $this->assign('selectFirst', $selectFirst);
        $this->assign('selectSecond', $selectSecond);
        $this->assign('selectThird', $selectThird);
        $this->assign('firstList', $firstList);
        $this->assign('secondList', $secondList);
        $this->assign('thirdList', $thirdList);
        $this->display('Widget:select/workArea');
    }

    /**
     * 公司
     * @author Red
     * @date 2017年1月3日17:20:19
     * @param $businessId
     */
    public function business($businessId = 0)
    {
        $businessList = get_config_table_list('tb_business');
        $userInfo     = get_user_info();
        $disabled     = '';
        if (!$userInfo['isSuper']) {
            $businessId = $userInfo['business_id'];
            $disabled   = 'disabled="disabled"';
        }
        $this->assign('list', $businessList);
        $this->assign('selected', $businessId);
        $this->assign('disabled', $disabled);
        $this->display('Widget:select/business');
    }
}