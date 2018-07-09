<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2017年3月24日
 * Time: 11:42:30
 */
namespace Home\Model;
class UserAccountModel extends CommonModel
{
    /**
     * 个人金额修改
     * @author Red
     * @date  2017年6月20日10:40:26
     * @param $userId
     * @param $money
     * @param string $operator
     * @return bool
     */
    public function userAccountModify($userId, $money, $operator = "-")
    {

        $where['user_id'] = $userId;
        if(!$this->getOne(array('user_id'=>$userId))){
            $this->insert(array('user_id'=>$userId,'create_time'=>time()));
        }
        if ($operator == '-') {
            $res = $this->where($where)->setDec('money', $money);
        } elseif ($operator == '+') {
            $res =$this->where($where)->setInc('money', $money);
        } else {
            $res= false;
        }
        if ($res===false){
            return false;
        }
        return true;
    }
}