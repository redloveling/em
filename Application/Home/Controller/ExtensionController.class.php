<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/12/7
 * Time: 17:19
 */

namespace Home\Controller;


use Home\Model\AdminUserModel;
use Home\Model\ChannelModel;
use Home\Model\UserModel;

class ExtensionController extends BaseController
{
    public function index(){
        $this->redirect('extension/channelIndex');
    }
    /**
     * 渠道商列表
     * @author Red
     * @date 2016年12月12日17:55:36
     */
    public function channelIndex()
    {
        if ($_POST['other'] == 'list') {
            $channelModel = new ChannelModel();
            $sort         = I('sort', '', 'trim');
            $order        = I('order', '', 'trim');
            $limit        = I('post.offset') . ',' . I('post.limit');
            if ($sort == 'direct_count' || $sort == 'indirect_count') {
                $otherSort['key']  = $sort;
                $otherSort['sort'] = $order;
                $order             = '';
            } else {
                $order             = '';
                $otherSort['key']  = 'direct_count';
                $otherSort['sort'] = 'desc';
            }
            $list = $channelModel->getChannelList('', $order, $limit, $otherSort);
            foreach ($list['rows'] as $key => $value) {
                $list['rows'][$key]['create_time_name'] = format_time($value['create_time']);
                $list['rows'][$key]['status_name']      = $value['status'] == 1 ? '<font style="color: green">有效</font>' : '<font style="color: #808080">无效</font>';
                $list['rows'][$key]['qr_code_img']      = array('img' => true, 'width' => 40, 'height' => 40, 'path' => '.' . $value['qr_code']);//excel下载时的图片处理 路径
            }
            S('channelList_' . get_user_id(), $list['rows']);

            echo json_encode(array('total' => $list['total'], 'rows' => $list['rows']));
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
        $ids          = implode(',', $ids);
        $channelModel = new ChannelModel();
        $map['id']    = array('in', $ids);
        switch ($type) {
            case 0://删除
                $res = $channelModel->del($map);
                break;
            case 1 ://启用
                $res = $channelModel->update(array('status' => 1), $map);
                break;
            case 2 ://禁用
                $res = $channelModel->update(array('status' => 0), $map);
                break;
            default:
                $res = false;
        }
        if ($res === false) {
            exit(returnStatus(0, L('OPERATE_FAIL')));
        }
        exit(returnStatus(1, L('OPERATE_SUCCESS')));

    }

    /**
     * 添加渠道商
     * @author Red
     * @date 2016年12月12日15:35:52
     */
    public function addChannel()
    {
        if (IS_POST) {
            $data['name']        = check_post('name', L('CHANNEL_NAME'), 1);
            $data['username']    = check_post('username', L('CHANNEL_USERNAME'), 1);
            $password            = check_post('password', L('CHANNEL_PASSWORD'), 1);
            $data['tell']        = check_post('tell', L('CHANNEL_TELL'), 1);
            $data['status']      = I('status', 1, 'int');
            $data['salt']        = getSalt(4);
            $data['password']    = compilePassword($password, $data['salt']);
            $data['create_uid']  = get_user_id();
            $data['create_time'] = time();
            $channelModel        = new ChannelModel();
            $userModel           = new AdminUserModel();
            if (preg_match("/[\x7f-\xff]/", $data['username'])) {
                exit(returnStatus(0, L('DO_NOT_CHINESE')));
            }
            trans_start();
            if ($channelModel->getOne(array('username' => trim($data['username'])))) {
                trans_back(L('CHANNEL_USERNAME_EXIST'));
            }
            if ($userModel->getOne(array('username' => trim($data['username'])))) {
                trans_back(L('CHANNEL_USERNAME_EXIST'));
            }
            if ($channelModel->addChannel($data)) {
                trans_commit();
            }
            trans_back();
        }
        $this->display();
    }

    /**
     * 编辑渠道商
     * @author Red
     * @date 2016年12月12日18:04:51
     */
    public function editChannel()
    {
        $id           = I('cId', 0, 'int');
        $channelModel = new ChannelModel();
        $channelInfo  = $channelModel->getById($id);
        if (IS_POST) {
            $data['name']   = check_post('name', L('CHANNEL_NAME'), 1);
            $data['tell']   = check_post('tell', L('CHANNEL_TELL'), 1);
            $data['status'] = I('status', 1, 'int');
            if (I('isModify', 0, 'int')) {
                $password         = check_post('password', L('CHANNEL_PASSWORD'), 1, '', 'trim');
                $data['salt']     = getSalt(4);
                $data['password'] = compilePassword($password, $data['salt']);
            }
            $res = $channelModel->update($data, array('id' => $id));
            if ($res === false) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }
        $this->assign('vo', $channelInfo);
        $this->display();
    }

    /**
     * 直接推广详情
     * @author Red
     * @date 2016年12月13日10:26:15
     */
    public function directDetail()
    {
        $id = I('cId', 0, 'int');
        $type = I('type', 0, 'int');
        if ($_POST['other'] == 'list' && $id) {
            $limit         = I('post.offset') . ',' . I('post.limit');
            $userModel     = new UserModel();
            $where['type'] = I('type');
            $where['pid']  = $id;
            $list          = $userModel->getUserList($where, '*', 'reg_time asc', $limit);
            foreach ($list['rows'] as $key => $value) {
                $list['rows'][$key]['sex_name']      = sex_trans($value['sex']);
                $list['rows'][$key]['reg_time_name'] = format_time($value['reg_time']);
            }
            echo json_encode(array('total' => $list['total'], 'rows' => $list['rows']));
            exit;
        }
        $this->assign('cId', $id);
        $this->assign('type', $type);
        $this->display();
    }

    /**
     * 渠道商导出
     * @author Red
     * @date 2016年12月13日10:34:37
     */
    public function exportChannel()
    {
        $list            = S('channelList_' . get_user_id());
        $excelFieldsZHCN = C('channel_list');
        exportExcels(array($list), array($excelFieldsZHCN['filed']), $excelFieldsZHCN['fileName'], array($excelFieldsZHCN['sheetName']));
    }

    /**
     * 查看二维码
     * @author Red
     * @date 2016年12月12日17:45:43
     */
    public function showQrCode()
    {
        $cId = I('cId', 0, 'int');
        if ($cId) {
            $channelModel = new ChannelModel();
            $this->assign('vo', $channelModel->getById($cId));
            $this->display();
        }
    }

    /**
     * 下载二维码
     * @author Red
     * @date 2016年12月12日17:46:07
     */
    public function downloadQrCode()
    {
        $cId = I('cId', 0, 'int');
        if ($cId) {
            $channelModel = new ChannelModel();
            $cInfo        = $channelModel->getById($cId);
            download_file($cInfo['qr_code']);
        }
    }

    /**
     * 用户推广列表
     * @author Red
     * @date 2016年12月13日11:57:14
     */
    public function UserIndex()
    {
        if ($_POST['other'] == 'list') {
            $userModel = new UserModel();
            $sort      = I('sort', '', 'trim');
            $order     = I('order', '', 'trim');
            $limit     = I('post.offset') . ',' . I('post.limit');
            if ($sort == 'direct_count' || $sort == 'indirect_count') {
                $otherSort['key']  = $sort;
                $otherSort['sort'] = $order;
                $order             = '';
            } else {
                $order             = '';
                $otherSort['key']  = 'direct_count';
                $otherSort['sort'] = 'desc';
            }
            $list = $userModel->getUserExtensionList('', $order, $limit, $otherSort);
            foreach ($list['rows'] as $key => $value) {
                $list['rows'][$key]['sex_name']     = sex_trans($value['sex']);
                $list['rows'][$key]['reg_time_day'] = $value['reg_time'] ? round(abs(time() - $value['reg_time']) / 86400) . '天' : '';
            }
            echo json_encode(array('total' => $list['total'], 'rows' => $list['rows']));
            exit;
        }
        $this->display();
    }

}