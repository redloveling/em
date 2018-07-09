<?php
namespace Home\Controller;

use Home\Model\AdminNodeModel;

/**
 * 节点控制器
 * Class UserController
 * @package Home\Controller
 */
class NodeController extends BaseController
{
    /**
     * 节点列表
     * @author Red
     * @date 2016年10月27日11:11:47
     */
    public function index()
    {
        if ($_POST['other'] == 'list') {
            $nodeModel = new AdminNodeModel();
            if (I('get.id', 0, 'int')) {
                $where['pid'] = I('get.id', 0, 'int');
            }
            $limit = I('post.offset') . ',' . I('post.limit');

            $nodeList = $nodeModel->get($where, '*', true, '', '', 'type', $limit);
            $total    = $nodeModel->getCount($where);
            echo json_encode(array('total' => $total, 'rows' => $nodeList));
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
        $nodeMode  = new AdminNodeModel();
        $map['id'] = array('in', $ids);
        switch ($type) {
            case 0://删除
                $res = $nodeMode->del($map);
                break;
            case 1 ://启用
                $res = $nodeMode->update(array('status' => 1), $map);
                break;
            case 2 ://禁用
                $res = $nodeMode->update(array('status' => 0), $map);
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
     * 编辑节点
     * @author Red
     * @date 2016年10月18日11:20:39
     */
    public function edit()
    {
        $id        = I('id', 1, 'int');
        $nodeModel = new AdminNodeModel();
        $nodeInfo  = $nodeModel->getById($id);
        if (IS_POST) {
            $data                = array();
            $data['name']        = check_post('name',L('NODE_NAME'));
            $data['status']      = I('status', 1, 'int');
            $data['description'] = I('description', '', 'trim');
            $data['code']        = I('code', '', 'trim');
            //一级菜单
            if (!I('firstNode')) {
                $data['pid'] = 0;
            }
            //二级菜单
            if (I('firstNode') && !I('secondNode')) {
                $data['pid'] = I('firstNode', 0, 'int');
            }
            //三级菜单
            if (!I('firstNode') && !I('secondNode')) {
                $data['pid'] = I('thirdNode');
            }
            $nodeModel = D('admin_node');
            $res       = $nodeModel->update($data, array('id' => $id));
            if ($res === false) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }

        $this->assign('nodeInfo', $nodeInfo);
        $this->display();
    }

    /**
     * 添加节点
     * @author Red
     * @date 2016年10月18日11:21:08
     */
    public function add()
    {
        if (IS_POST) {
            $data                = array();
            $data['name']        = check_post('name', L('NODE_NAME'));
            $data['status']      = I('status', 1, 'int');
            $data['description'] = I('description', '', 'trim');
            //一级菜单
            if (!I('firstNode')) {
                $data['pid']  = 0;
                $data['type'] = 1;
            }
            //二级菜单
            if (I('firstNode') && !I('secondNode')) {
                $data['pid']  = I('firstNode', 0, 'int');
                $data['type'] = 2;
            }
            //三级菜单
            if (I('firstNode') && I('secondNode')) {
                $data['pid']  = I('secondNode', 0, 'int');
                $data['type'] = 3;
            }
            $data['code']        = I('code', '', 'trim');
            $data['create_time'] = time();
            $data['create_uid']  = get_user_id();
            $nodeModel           = new AdminNodeModel();//print_r($data);exit;
            $res                 = $nodeModel->insert($data);
            if ($res === false) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
            exit(returnStatus(1, L('OPERATE_SUCCESS')));

        }
        $this->display();
    }

}