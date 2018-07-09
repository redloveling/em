<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/10/14
 * Time: 14:52
 */
namespace Home\Widget;

use Home\Model\AdminNodeModel;
use Home\Model\AdminRoleNodeModel;
use Think\Controller;

/**
 * 节点
 * Class NodeWidget
 * @package Home\Widget
 */
class NodeWidget extends Controller
{
    /**
     * 选择节点
     * @author Red
     * @date 2016年12月5日15:45:26
     * @param int $id
     */
    public function select($id = 0)
    {
        $nodeModel  = D('admin_node');
        $nodeList   = $nodeModel->getAll(array('pid' => 0));
        $nodeInfo   = $nodeModel->getById($id);
        $secondList = $nodeModel->getAll(array('pid' => $nodeInfo['pid']));
        if ($nodeInfo['type'] == 3) {
            $thirdList = $nodeModel->getAll(array('pid' => $nodeInfo['pid'], 'type' => 2));
            $this->assign('thirdList', $thirdList);
        }
        $this->assign('nodeInfo', $nodeInfo);
        $this->assign('nodeList', $nodeList);
        $this->assign('secondList', $secondList);
        $this->display('Widget:node/index');
    }

    /**
     * 节点列表
     * @author Red
     * @date 2016年12月5日15:26:45
     * @param int $id
     */
    public function nodeList($id = 0)
    {
        $nodeModel  = D('admin_node');
        $nodeList   = $nodeModel->getAll(array('pid' => 0));
        $nodeInfo   = $nodeModel->getById($id);
        $secondList = $nodeModel->getAll(array('pid' => $nodeInfo['pid']));
        if ($nodeInfo['type'] == 3) {
            $thirdList = $nodeModel->getAll(array('pid' => $nodeInfo['pid'], 'type' => 2));
            $this->assign('thirdList', $thirdList);
        }
        $this->assign('nodeInfo', $nodeInfo);
        $this->assign('nodeList', $nodeList);
        $this->assign('secondList', $secondList);
        $this->display('Widget:node/list');
    }

    /**
     * 节点授权
     * @author Red
     * @date 2016年12月5日15:27:12
     * @param int $roleId
     */
    public function access($roleId = 0)
    {
        $nodeModel     = new AdminNodeModel();
        $roleNodeModel = new AdminRoleNodeModel();

        //超级管理员才有权限修改节点管理和后台配置(固定账号)
        if(get_user_id()!=1){
            $where['id'] = array('not in',C('super_node'));
        }
        $list          = $nodeModel->getAll($where);
        $userInfo = get_user_info();
        foreach ($list as $key => $value) {

            $lists[$value['pid']][] = $value;
        }
        $superBusiness = C('super_business');
        if(!$userInfo['isSuper'] && in_array($userInfo['business_id'],$superBusiness)){
           foreach($lists[0] as  $key=>$value){
               //除了超级管理员以外其它的管理员只能授权系统配置和任务管理
               if(!in_array($value['id'],array(1,4))){
                   unset($lists[0][$key]);
               }
           }
        }
        $roleNodeList = $roleNodeModel->getAll(array('role_id' => $roleId), 'node_id');
        foreach ($roleNodeList as $value) {
            $roleNodeArr[] = $value['node_id'];
        }
//        print_r($lists);
//        print_r($roleNodeArr);
        $this->assign('list', $lists);
        $this->assign('roleNodeArr', $roleNodeArr);
        $this->display('Widget:node/access');
    }

}