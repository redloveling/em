<?php
namespace Home\Controller;

use Home\Model\AdminUserModel;


/**
 * 系统相关配置控制器
 * Class BaseController
 * @package Home\Controller
 */
class ConfigController extends BaseController
{
    /**
     * 列表
     * @author Red
     * @date 2016年10月31日16:11:11
     */
    public function index()
    {
        if ($_POST['other'] == 'list' && I('tableName', '', 'trim')) {
            $tableName = I('tableName', '', 'trim');
            $model     = M($tableName);
            if (I('search', '', 'trim')) {
                $where['name'] = array('like', '%' . I('search', '', 'trim') . '%');
            }
            if (I('get.id', 0, 'int')) {
                $where['pid'] = I('get.id', 0, 'int');
            }
            $order = $tableName == 'tb_work_area' ? 'type,status' : 'status';
            $limit = I('post.offset') . ',' . I('post.limit');
            $list  = $model->where($where)->limit($limit)->order($order)->select();
            foreach ($list as $key => $value) {
                if ($tableName == 'message_template') {
                    $messageCategory             = C('message_category');
                    $list[$key]['category_name'] = $messageCategory[$value['category']];
                }
            }
            $total = $model->where($where)->select();
            echo json_encode(array('total' => count($total), 'rows' => $list));
            exit;
        }
        //配置列表
        $configList = C('config');
        $this->assign('configList', $configList);
        $this->display();
    }

    /**
     * 添加
     * @author Red
     * @date 2016年10月31日16:53:07
     */
    public function add()
    {
        $tableName = I('tableName', '', 'trim');
        if (IS_POST) {
            if ($tableName) {
                $model               = M($tableName);
                $data                = array();
                $data['name']        = check_post('name', L('NAME'));
                $data['description'] = I('description', '', 'trim');
                $data['status']      = I('status', 1, 'int');
                $data['create_time'] = time();
                trans_start();
                if (!in_array($tableName, array('message_template')) && $model->where(array('name' => $data['name']))->find()) {
                    trans_back(L('NAME_EXIST'));
                }
                //用户层级
                if ($tableName == 'user_level') {
                    trans_back('暂不支持新增');
                }
                //工作区域
                if ($tableName == 'tb_work_area') {
                    $data['type'] = I('type', 3, 'int');
                    $data['pid']  = $data['type'] == 3 ? I('city', 0, 'int') : ($data['type'] == 2 ? I('province', 0, 'int') : 0);
                }
                //版本
                if ($tableName == 'tb_version') {
                    $data['val'] = check_post('val', L('VERSION_VAL'));
                    $data['code'] = check_post('code', L('VERSION_CODE'));
                    $data['path'] = check_post('path', L('VERSION_PATH'));
                }
                //消息模板
                if ($tableName == 'message_template') {
                    $data['type']     = I('message_type', 1, 'int');
                    $data['category'] = check_post('message_category', L('MESSAGE_CATEGORY'));
                    $data['message']  = check_post('message', L('MESSAGE'));
                    $isShortMessage   = I('is_short_message', 0, 'int');

                    if ($isShortMessage) {
                        $data['is_short_message']     = $isShortMessage;
                        $data['template_code']        = check_post('template_code', L('TEMPLATE_CODE'));
                        $data['short_message_params'] = check_post('short_message_params', L('SHORT_MESSAGE_PARAMS'));
                    }

                }
                if ($tableName == 'tb_business') {
                    $username = check_post('username', L('USER_EXIST'), 1);
                    $password = check_post('password', L('PASSWORD'), 1);
                    if (preg_match("/[\x7f-\xff]/", $username)) {
                        trans_back(L('DO_NOT_CHINESE'));
                    }
                    $adminUserModel = new AdminUserModel();
                    if ($adminUserModel->getOne(array('username' => $username))) {
                        trans_back(L('ACCOUNT_EXIST'));//账号存在
                    }
                }
                $res = $model->data($data)->add();
                //清除缓存
                F($tableName, null);
                if ($res === false) {
                    trans_back();
                }
                if ($tableName == 'tb_business') {
                    //默认把当前人员加到该公司的管理员组中

                    if (false === $adminUserModel->insertBusinessUser($res, $username, $password)) {
                        trans_back();
                    }
                }
                trans_commit();
            }
            exit(returnStatus(0, L('OPERATE_FAIL')));
        }
        $this->assign('tableName', $tableName);
        if ($tableName == 'message_template') {
            $this->display('addMessage');
        } elseif ($tableName == 'tb_business') {
            $this->display('addBusiness');
        } elseif ($tableName == 'tb_version') {
            $this->display('addVersion');
        }else {
            $this->display();

        }
    }

    /**
     * 编辑
     * @author Red
     * @date 2016年10月31日16:53:07
     */
    public function edit()
    {
        $tableName = I('tableName', '', 'trim');
        $id        = I('id', 0, 'int');
        $model     = M($tableName);
        if (IS_POST) {
            if ($tableName) {
                $data                = array();
                $data['name']        = check_post('name', L('NAME'));
                $data['description'] = I('description', '', 'trim');
                if (!in_array($tableName, array('message_template','tb_version')) && $model->where(array('name' => $data['name']))->find()) {
                    trans_back(L('NAME_EXIST'));
                }
                //工作区域
                if ($tableName == 'tb_work_area') {
                    $data['type'] = I('type', 3, 'int');
                    $data['pid']  = $data['type'] == 3 ? I('city', 0, 'int') : ($data['type'] == 2 ? I('province', 0, 'int') : 0);
                }
                //版本
                if ($tableName == 'tb_version') {
                    $data['val'] = check_post('val', L('VERSION_VAL'));
                    $data['code'] = check_post('code', L('VERSION_CODE'));
                    $data['path'] = check_post('path', L('VERSION_PATH'));
                }
                //消息模板
                if ($tableName == 'message_template') {
                    $data['message'] = check_post('message', L('MESSAGE'));
                    $isShortMessage  = I('is_short_message', 0, 'int');

                    if ($isShortMessage) {
                        $data['is_short_message']     = $isShortMessage;
                        $data['template_code']        = check_post('template_code', L('TEMPLATE_CODE'));
                        $data['short_message_params'] = check_post('short_message_params', L('SHORT_MESSAGE_PARAMS'));
                    }
                }
                $res = $model->where(array('id' => $id))->save($data);
                if ($res === false) {
                    exit(returnStatus(0, L('OPERATE_FAIL')));
                }
                //清除缓存
                F($tableName, null);
                exit(returnStatus(1, L('OPERATE_SUCCESS')));
            }
            exit(returnStatus(0, L('OPERATE_FAIL')));
        }
        $this->assign('vo', $model->where(array('id' => $id))->find());
        $this->assign('tableName', $tableName);
        if ($tableName == 'message_template') {
            $this->display('editMessage');
        } elseif ($tableName == 'tb_version') {
            $this->display('editVersion');
        }else {
            $this->display();

        }
    }

    /**
     * 操作数据
     * @author Red
     * @date 2016年11月2日16:51:02
     */
    public function handleData()
    {
        $type      = I('type', 1, 'int');
        $ids       = I('ids', '');
        $tableName = I('tableName', '', 'trim');
        if (!$tableName) {
            exit(returnStatus(0, L('OPERATE_FAIL')));
        }
        if ($ids == '') {
            exit(returnStatus(0, L('CHOOSE_DADA')));
        }
        if($tableName=='tb_education'){
            $key = array_search(3, $ids);
            if ($key !== false)
                array_splice($ids, $key, 1);
            //学历id=3的不能删除，方便以后的联合查询学历（主要是为了查询方便）
        }
        $ids       = implode(',', $ids);

        $model     = M($tableName);
        $map['id'] = array('in', $ids);
        switch ($type) {
            case 0://删除
                $res = $model->where($map)->delete();
                break;
            case 1 ://启用
                $res = $model->where($map)->save(array('status' => 1));
                break;
            case 2 ://禁用
                $res = $model->where($map)->save(array('status' => 0));
                break;
            default:
                $res = false;
        }
        //清除缓存
        F($tableName, null);
        if ($res === false) {
            exit(returnStatus(0, L('OPERATE_FAIL')));
        } else {
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }

    }
}