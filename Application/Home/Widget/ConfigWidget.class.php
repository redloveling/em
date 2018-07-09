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
 * 后台配置
 * Class ConfigWidget
 * @package Home\Widget
 */
class ConfigWidget extends Controller
{
    /**
     * 配置表select
     * @author Red
     * @date 2016年12月6日11:01:27
     * @param $tableName
     * @param $selectName
     * @param int $selected
     * @param array $where
     */
    public function select($tableName, $selectName, $selected = 0, $where = array())
    {

        $list = get_config_table_list($tableName);
        $this->assign('selectName', $selectName);
        $this->assign('selected', $selected);
        $this->assign('list', $list);
        $this->display('Widget:config/select');
    }

    /**
     * 消息类型
     * @author Red
     * @date 2016年12月6日11:54:40
     * @param int $selected
     * @param bool $disabled
     */
    public function messageTypeSelect($selected = 0, $disabled = false)
    {
        $messageCategory = C('message_type');
        $this->assign('list', $messageCategory);
        $this->assign('selected', $selected);
        $this->assign('disabled', $disabled);
        $this->display('Widget:config/messageTypeSelect');
    }

    /**
     * 消息类别
     * @author Red
     * @date 2016年12月6日11:54:40
     * @param int $selected
     * @param bool $disabled
     */
    public function messageCategorySelect($selected = 0, $disabled = false)
    {
        $messageCategory = C('message_category');
        $this->assign('list', $messageCategory);
        $this->assign('selected', $selected);
        $this->assign('disabled', $disabled);
        $this->display('Widget:config/messageCategorySelect');
    }

    /**
     * 模板选择
     * @author Red
     * @date 2017年7月28日10:41:38
     * @param $p
     */
    public function messageTemplateSelect($p)
    {
        $templateList = $p ? C('template_brr') : C('template_arr');
        $this->assign('p', $p);
        $this->assign('list', $templateList);
        $this->assign('firstDescription', current($templateList)['description']);
        if ($p){
            $this->display('Widget:config/messageTemplateSelect1');
        }else{
            $this->display('Widget:config/messageTemplateSelect');
        }

    }
}