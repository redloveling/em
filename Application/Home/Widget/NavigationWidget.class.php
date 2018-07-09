<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/12/5
 * Time: 14:52
 */
namespace Home\Widget;

use Home\Model\AdminNodeModel;
use Home\Model\AdminUserRoleModel;
use Home\Model\AdminRoleNodeModel;
use Think\Controller;

/**
 * 导航
 * Class NavigationWidget
 * @package Home\Widget
 */
class NavigationWidget extends Controller
{
    /**
     * 顶部
     * @author Red
     * @date 2016年12月5日15:18:36
     */
    public function top()
    {
        $user      = D('admin_user');
        $user_info = $user->getById(get_user_id());
        $this->assign('user_info', $user_info);
        $this->display('Widget:navigation/top');
    }

    /**
     * 左边栏
     * @author Red
     * @date
     */
    public function left()
    {
        $user_info = get_user_info();

        $nodeModel = new AdminNodeModel();
        $url       = $_SERVER['REQUEST_URI'];
        if (substr($url, 10)) {
            $code  = str_replace('/home', '', rtrim(strtolower(substr($url, 10)), '/'));
            $t     = $nodeModel->getOne(array('type' => 2, 'code' => $code));
            $pInfo = $nodeModel->getOne(array('type' => 1, 'id' => $t['pid']));
        }

        //检查当前登陆人的权限
        $userRoleModel = new AdminUserRoleModel();
        $roleNodeModel = new AdminRoleNodeModel();
        $roleList      = $userRoleModel->getAll(array('user_id' => $user_info['id'], 'business_id' => $user_info['business_id']), 'role_id');
        $roleIds       = '';
        foreach ($roleList as $value) {
            $roleIds .= $value['role_id'] . ',';
        }
        //print_r($userRoleModel->getLastSql());
        $userNodeList = $roleNodeModel->getAll(array( 'status' => 1, 'role_id' => array('in', $roleIds)), 'node_id');
        $nodeIds      = '';
        foreach ($userNodeList as $value) {
            $nodeIds .= $value['node_id'] . ',';
        }
        //获取所有二级节点
        if (!$user_info['isSuper']) {
            $where['id']     = array(array('in', $nodeIds), array('not in', C('super_node')));
            $where['type']   = array('in', '1,2');
            $where['status'] = 1;
        }
        $nodeList = $nodeModel->getAll($where,'*','salt');
        foreach ($nodeList as $value) {
            $nodeLists[$value['pid']][] = $value;
        }
        $this->assign('urlInfo', array('url' => substr($url, 10), 'code' => $pInfo['code']));
        $this->assign('nodeList', $nodeLists);
        $this->assign('user_info', $user_info);
        $this->display('Widget:navigation/left');
    }
}