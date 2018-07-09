<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/12/8
 * Time: 10:43
 */

namespace Home\Model;


class ChannelModel extends CommonModel
{
    /**
     * 获取渠道商列表
     * @author Red
     * @date 2016年12月12日14:21:44
     * @param $map
     * @param $order
     * @param $limit
     * @param $otherSort
     * @return mixed
     */
    public function getChannelList($map, $order, $limit='0,10',$otherSort=array())
    {
        $list = $this->get($map, '*', true, '', '', $order, $limit);
        //找出渠道推广的用户
        $userModel = new UserModel();
        $userList  = $userModel->getAll(array('type' => 1), 'id,pid,type');

        //用户
        $userRecursionList = $userModel->getRecursionUserList();
        foreach ($userList as $value) {
            $userLists1[$value['pid']][] = $value;
            $userRecursionList[$value['id']]['child'] && $userLists2[$value['pid']][] = $userRecursionList[$value['id']]['child'];
        }
        foreach ($userLists2 as $key => $value) {
            foreach ($value as $v) {
                $userLists2[$key]['count'] += count($v);
            }
        }
        foreach ($list as $key => $value) {
            $list[$key]['direct_count']   = count($userLists1[$value['id']]);//直接推广
            $list[$key]['indirect_count'] = $userLists2[$value['id']]['count']?$userLists2[$value['id']]['count']:0;//间接推广
        }

        if($otherSort){
            foreach ($list as $key => $value) {
                $num1[$key]   = $value[$otherSort['key']];
            }
            $sort = $otherSort['sort']=='asc'?SORT_ASC:SORT_DESC;
            array_multisort($num1, $sort, $list);
        }
        $total = $this->getCount($map);

        return array('total' => $total, 'rows' => $list);
    }

    /**
     * 添加渠道商
     * @author Red
     * @date 2016年12月8日16:41:34
     * @param $data
     * @return mixed
     */
    public function addChannel($data)
    {

        //插入到供应商表中
        $channelId = $this->insert($data);
        if (!$channelId) {
            return false;
        }
        //推广码 //二维码
        $dataC['extension_code'] = generate_extension_code($channelId, 'q');
        $dataC['qr_code'] = generate_qr_code($dataC['extension_code'],$dataC['extension_code']);
        if (false === $this->update($dataC, array('id' => $channelId))) {
            return false;
        }


        //插入到后台用户表中
        $dataU['type']        = 1;
        $dataU['channel_id']  = $channelId;
        $dataU['username']    = $data['username'];
        $dataU['password']    = $data['password'];
        $dataU['salt']        = $data['salt'];
        $dataU['status']      = $data['status'];
        $dataU['create_uid']  = get_user_id();
        $dataU['create_time'] = time();
        $adminUserModel       = new AdminUserModel();
        $adminUserId = $adminUserModel->insert($dataU);
        if (false===$adminUserId) {
            return false;
        }
        //默认渠道商的角色
        $adminUserRoleModel = new AdminUserRoleModel();
        $dataR['user_id'] = $adminUserId;
        $dataR['role_id'] = 3;
        $dataR['create_time'] = time();
        $dataR['create_uid'] = get_user_id();
        if(false===$adminUserRoleModel->insert($dataR)){
            return false;
        }
        return true;
    }
}