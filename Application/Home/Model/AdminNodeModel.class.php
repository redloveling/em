<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/10/17
 * Time: 15:28
 */
namespace Home\Model;
class AdminNodeModel extends CommonModel
{
    /**
     * 获取当前登录人的节点ids
     * @author Red
     * @date  2016年12月28日11:30:54
     */
    public function getAdminUserAccessNodeIds()
    {
        $userInfo = get_user_info();
        //检查当前登陆人的权限
        $userRoleModel = new AdminUserRoleModel();
        $roleNodeModel = new AdminRoleNodeModel();
        $roleList      = $userRoleModel->getAll(array('user_id' => $userInfo['id'], 'business_id' => $userInfo['business_id']), 'role_id');
        $roleIds       = '';
        foreach ($roleList as $value) {
            $roleIds .= $value['role_id'] . ',';
        }
        $userNodeList = $roleNodeModel->getAll(array( 'status' => 1, 'role_id' => array('in', $roleIds)), 'node_id');
        $nodeIds      = '';
        foreach ($userNodeList as $value) {
            $nodeIds .= $value['node_id'] . ',';
        }
        return rtrim($nodeIds,',');
    }


}