<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/11/22
 * Time: 14:28
 */
namespace Home\Model;
class QuestionModel extends CommonModel
{
    /**
     * 获取题库列表
     * @author Red
     * @date 2016年11月26日15:57:05
     * @param $map
     * @param string $field
     * @param string $order
     * @param string $limit
     * @return array
     */
    public function getQuestionList($map, $field = '*', $order = '', $limit = '0,10')
    {
        $list  = $this->get($map, $field, true, '', '', $order, $limit);
        $count = $this->getCount($map);

        return array('total' => $count, 'rows' => $list);
    }
    public function test(){
        echo  11;
    }
}