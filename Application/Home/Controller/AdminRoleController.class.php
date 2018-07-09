<?php
namespace Home\Controller;

use Home\Model\AdminRoleNodeModel;
use Home\Model\AdminUserModel;
use Home\Model\AdminRoleModel;
use Home\Model\AdminUserRoleModel;

/**
 * 后台管理员角色控制器
 * Class BaseController
 * @package Home\Controller
 */
class AdminRoleController extends BaseController
{
    /**
     * 角色列表
     * @author Red
     * @date 2016年10月27日14:21:28
     */
    public function index()
    {
        if ($_POST['other'] == 'list') {
            $roleModel = new AdminRoleModel();
            $userInfo  = get_user_info();
            if (!$userInfo['isSuper']) {
                $where['id']          = array('not in', '1,3');
                $where['business_id'] = $userInfo['business_id'];
            }
            $limit        = I('post.offset') . ',' . I('post.limit');
            $businessList = get_config_table_list('tb_business');
            $nodeList     = $roleModel->get($where, '*', true, '', '', '', $limit);
            foreach ($nodeList as $key => $value) {
                $nodeList[$key]['business_name'] = $businessList[$value['business_id']]['name'];
            }
            $total = $roleModel->get($where);
            echo json_encode(array('total' => count($total), 'rows' => $nodeList));
            exit;
        }
        $this->display();
    }

    /**
     * 操作数据
     * @author Red
     * @date 2016年10月25日16:51:02
     */
    public function handleData()
    {
        $type = I('type', 1, 'int');
        $ids  = I('ids', '');
        if ($ids == '') {
            exit(returnStatus(0, L('请选择数据')));
        }
        $ids       = implode(',', $ids);
        $roleModel = new AdminRoleModel();
        $map['id'] = array('in', $ids);
        switch ($type) {
            case 0://删除
                $res = $roleModel->del($map);
                break;
            case 1 ://启用
                $res = $roleModel->update(array('status' => 1), $map);
                break;
            case 2 ://禁用
                $res = $roleModel->update(array('status' => 0), $map);
                break;
            default:
                $res = false;
        }
        if ($res === false) {
            exit(returnStatus(0, L('OPERATE_FAIL')));
        } else {
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }
    }

    /**
     * 添加角色
     * @author Red
     * @date 2016年10月27日14:37:28
     */
    public function add()
    {
        if (IS_POST) {
            $roleModel  = new AdminRoleModel();
            $data       = array();
            $name       = check_post('name', '角色名');
            $businessId = I('chooseBusiness', 0, 'int');
            if ($roleModel->getOne(array('name' => trim($name), 'business_id' => $businessId))) {
                exit(returnStatus(0, L('ROLE_EXIST')));
            }
            $data['name']        = trim($name);
            $data['status']      = I('status', 1, 'int');
            $data['create_time'] = time();
            $data['create_uid']  = get_user_id();
            $userInfo            = get_user_info();
            $data['business_id'] = I('chooseBusiness', 0, 'int') ? I('chooseBusiness', 0, 'int') : $userInfo['business_id'];
            $res                 = $roleModel->insert($data);
            if ($res === false) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            } else {
                exit(returnStatus(1, L('OPERATE_SUCCESS')));
            }

        }
        $this->display();
    }

    /**
     * 编辑后台管理员
     * @author Red
     * @date 2016年10月27日13:54:36
     */
    public function edit()
    {
        $id        = I('id', 0, 'int');
        $roleModel = new AdminRoleModel();
        $roleInfo  = $roleModel->getById($id);
        if (IS_POST) {
            $data                = array();
            $data['status']      = I('status', 1, 'int');
            $userInfo            = get_user_info();
            $data['business_id'] = I('chooseBusiness', 0, 'int') ? I('chooseBusiness', 0, 'int') : $userInfo['business_id'];
            $res                 = $roleModel->update($data, array('id' => $id));
            if ($res === false) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }

        $this->assign('vo', $roleInfo);
        $this->display();
    }

    /**
     * 角色授权
     * @author Red
     * @date 2016年10月27日15:09:52
     */
    public function access()
    {
        $id        = I('id', 0, 'int');
        $roleModel = new AdminRoleModel();
        $roleInfo  = $roleModel->getById($id);
        if (IS_POST) {
            $roleId        = I('id', 0, 'int');
            $nodeArr       = I('select_node');
            $roleNodeModel = new AdminRoleNodeModel();
            foreach ($nodeArr as $value) {
                $where['role_id'] = $roleId;
                $where['node_id'] = intval($value);
                $res              = $roleNodeModel->getOne($where);
                if (!$res) {
                    $data['business_id'] = 0;
                    $data['role_id']     = $roleId;
                    $data['node_id']     = $value;
                    $data['create_time'] = time();
                    $data['create_uid']  = get_user_id();
                    $res                 = $roleNodeModel->insert($data);
                }
            }
            //删除以前有的现在没有了的
            $roleNodeArr = explode(',', I('roleNodeStr', '', 'trim'));
            if (count($roleNodeArr) > 0) {
                $diff = array_diff($roleNodeArr, $nodeArr);
                $res  = $roleNodeModel->del(array('role_id' => $roleId, 'node_id' => array('in', implode(',', $diff))));
            }
            if ($res === false) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }
        $this->assign('vo', $roleInfo);
        $this->display();
    }

    /**
     * 添加人员
     * @author Red
     * @date 2016年10月28日16:54:12
     */
    public function addUser()
    {
        $userModel = new AdminUserModel();
        $roleModel = new AdminUserRoleModel();
        $roleId    = I('post.roleId', 0, 'int');
        if ($_POST['other'] == 'list') {
            //找出当前角色的用户
            $roleList = $roleModel->getAll(array('role_id' => $roleId));
            foreach ($roleList as $value) {
                $userArr[] = $value['user_id'];
            }
            $limit = I('post.offset') . ',' . I('post.limit');
            if ($_POST['search']) {
                $where['username'] = array('like', trim($_POST['search']));
            }
            $userInfo = get_user_info();
            if (!$userInfo['isSuper']) {
                $where['business_id'] = $userInfo['business_id'];
            }
            $join     = 'inner join em_tb_business b on b.id=em_admin_user.business_id';
            $userList = $userModel->get($where, 'em_admin_user.*,b.name as business_name', true, $join, '', '', $limit);
            foreach ($userList as $key => $value) {
                if (in_array($value['id'], $userArr)) {
                    $userList[$key]['selects'] = 1;
                }
            }
//            print_r($userList);
            $total = $userModel->getCount($where);
            echo json_encode(array('total' => $total, 'rows' => $userList));
            exit;
        } elseif ($_POST['other'] == 'save') {
            $userArr    = I('ids', '');
            $roleId     = I('post.roleId', 0, 'int');
            $businessId = I('post.businessId', 0, 'int');
            if ($userArr == '') {
                $res  = $roleModel->del(array('role_id' => $roleId));

            }
            //当前角色的所有用户
            $roleList = $roleModel->getAll(array('role_id' => $roleId));
            foreach ($roleList as $value) {
                $userRoleArr[] = $value['user_id'];
            }

            $userRoleModel = new AdminUserRoleModel();
            //把所选用户加入到em_admin_user_role表中
            $userInfo = get_user_info();

            foreach ($userArr as $value) {

                $where['role_id'] = $roleId;
                $where['user_id'] = intval($value);
                $res              = $userRoleModel->getOne($where);
                if (!$res) {
                    $data['business_id'] = $businessId;
                    $data['role_id']     = $roleId;
                    $data['user_id']     = $value;
                    $data['create_time'] = time();
                    $data['create_uid']  = get_user_id();
                    $res                 = $userRoleModel->insert($data);
                }
            }
            //删除以前有的现在没有了的
            if (count($userRoleArr) > 0) {
                $diff = array_diff($userRoleArr, $userArr);
                $res  = $roleModel->del(array('role_id' => $roleId, 'user_id' => array('in', implode(',', $diff))));
            }
            if ($res === false) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }
        $this->display();
    }
}