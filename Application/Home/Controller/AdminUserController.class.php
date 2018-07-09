<?php
namespace Home\Controller;

use Home\Model\AdminUserModel;
use Home\Model\UserModel;

/**
 * 后台管理员控制器
 * Class BaseController
 * @package Home\Controller
 */
class AdminUserController extends BaseController
{
    /**
     * 管理员列表
     * @author Red
     * @date 2016年10月27日11:21:55
     */
    public function index()
    {
        if ($_POST['other'] == 'list') {
            $userModel = new AdminUserModel();
            $userInfo  = get_user_info();
            if (!$userInfo['isSuper']) {
                $where['business_id'] = $userInfo['business_id'];
                $where['business_admin'] = array('neq', 1);//排除商家管理员
            }
            $where['type'] = array('neq', 1);//排除渠道商

            $limit         = I('post.offset') . ',' . I('post.limit');
            $businessList  = get_config_table_list('tb_business');
            $list          = $userModel->get($where, '*', true, '', '', '', $limit);
            foreach ($list as $key => $value) {
                $list[$key]['business_name'] = $businessList[$value['business_id']]['name'];
            }
            $total = $userModel->getCount($where);
            echo json_encode(array('total' => $total, 'rows' => $list));
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
            exit(returnStatus(0, L('CHOOSE_DADA')));
        }
        $ids       = implode(',', $ids);
        $userModel = new AdminUserModel();
        $map['id'] = array('in', $ids);
        switch ($type) {
            case 0://删除
                $res = $userModel->del($map);
                break;
            case 1 ://启用
                $res = $userModel->update(array('status' => 1), $map);
                break;
            case 2 ://禁用
                $res = $userModel->update(array('status' => 0), $map);
                break;
            default:
                $res = false;
        }
        if ($res === false) {
            exit(returnStatus(1, L('OPERATE_FAIL')));
        } else {
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }
    }

    /**
     * 添加后台管理员
     * @author Red
     * @date 2016年10月18日11:21:08
     */
    public function add()
    {
        if (IS_POST) {
            $userModel = new AdminUserModel();
            $data      = array();
            $username  = check_post('username', L('USERNAME'));
            $password  = check_post('password', L('PASSWORD'), 1, '', 'trim');
            if (preg_match("/[\x7f-\xff]/", $username)) {
                exit(returnStatus(0, L('DO_NOT_CHINESE')));
            }
            if ($userModel->getOne(array('username' => trim($username)))) {
                exit(returnStatus(0, L('USER_EXIST')));
            }
            $data['username']    = trim($username);
            $data['salt']        = getSalt(4);
            $data['password']    = compilePassword($password, $data['salt']);
            $data['status']      = I('status', 1, 'int');
            $data['create_time'] = time();
            $data['create_uid']  = get_user_id();
            $userInfo            = get_user_info();
            $data['business_id'] = I('chooseBusiness', 0, 'int') ? I('chooseBusiness', 0, 'int') : $userInfo['business_id'];
            $res                 = $userModel->insert($data);
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
        $userModel = new AdminUserModel();
        $userInfo  = $userModel->getById($id);
        if (IS_POST) {
            $data = array();
            if (I('isModify', 0, 'int')) {
                $password         = check_post('password', L('PASSWORD'), 1, '', 'trim');
                $data['salt']     = getSalt(4);
                $data['password'] = compilePassword($password, $data['salt']);
            }
            $data['status']      = I('status', 1, 'int');
            $userInfo            = get_user_info();
            $data['business_id'] = I('chooseBusiness', 0, 'int') ? I('chooseBusiness', 0, 'int') : $userInfo['business_id'];
            $res                 = $userModel->update($data, array('id' => $id));
            if ($res === false) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
//            print_r($userModel->getLastSql());
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }

        $this->assign('vo', $userInfo);
        $this->display();
    }

    /**
     * 修改密码
     * @author Red
     * @date 2017年2月22日15:05:51
     */
    public function modifyPassword()
    {
        $userInfo = get_user_info();
        if (IS_POST && $_POST['modify']) {
            $oldPassword     = I('password');
            $newPassword     = I('newPassword');
            $confirmPassword = I('confirmPassword');
            $userModel       = new AdminUserModel();
            $user            = $userModel->getById($userInfo['id']);
            if (compilePassword($oldPassword, $user['salt']) != $user['password']) {
                exit(returnStatus(0, '请输入正确的原密码'));
            }
            if ($newPassword != $confirmPassword) {
                exit(returnStatus(0, '两次密码不一样'));
            }
            $data['salt']     = getSalt(4);
            $data['password'] = compilePassword($newPassword, $data['salt']);

            if ($userModel->update($data, array('id' => $user['id'])) === false) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }
        $this->assign('vo', $userInfo);
        $this->display();
    }
}