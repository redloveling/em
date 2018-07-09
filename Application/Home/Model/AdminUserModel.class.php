<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/8/9
 * Time: 15:28
 */
namespace Home\Model;
class AdminUserModel extends CommonModel
{
    /**
     * 判断用户是否为超级管理员
     * @author Red
     * @date 2016年12月5日16:37:24
     * @param $uid
     * @return mixed
     */
    public function checkIsSuper($uid)
    {
        $userRoleModel = new AdminUserRoleModel();

        return $userRoleModel->getCount(array('user_id' => $uid, 'role_id' => 1));
    }

    /**
     * 增加公司时添加该公司的管理员账号
     * @author Red
     * @date 2017-1-3 16:44:05
     * @param $businessId
     * @param $username
     * @param $password
     * @return bool
     */
    public function insertBusinessUser($businessId, $username, $password)
    {

        $data['business_id']    = $businessId;
        $data['username']       = $username;
        $data['salt']           = getSalt();
        $data['password']       = compilePassword($password, $data['salt']);
        $data['create_time']    = time();
        $data['business_admin'] = 1;
        $data['create_uid']     = get_user_id();
        $adminUserId            = $this->insert($data);
        if (!$adminUserId) {
            return false;
        }
        //加入默认该公司的管理员角色
        $adminUserRoleModel   = new AdminUserRoleModel();
        $dataR['user_id']     = $adminUserId;
        $dataR['role_id']     = 4;//这个角色为固定的所有公司的管理员角色权限相同
        $dataR['business_id'] = $businessId;
        $dataR['create_time'] = time();
        $dataR['create_uid']  = get_user_id();
        if (false === $adminUserRoleModel->insert($dataR)) {
            return false;
        }

        return true;
    }
}