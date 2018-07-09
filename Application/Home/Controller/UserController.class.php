<?php
namespace Home\Controller;

use Extend\SendShortMessage;
use Home\Model\AdminUserModel;
use Home\Model\MessageModel;
use Home\Model\UserCardListModel;
use Home\Model\UserModel;
use Home\Model\UserRealAuditModel;

/**
 * 用户控制器
 * Class BaseController
 * @package Home\Controller
 */
class UserController extends BaseController
{
    /**
     * 用户列表
     * @author Red
     * @date 2016年10月31日16:11:11
     */
    public function index()
    {
        if ($_POST['other'] == 'list') {
            $userModel     = new UserModel();
            $status        = I('status');
            $where         = array();
            if ($status) {
                if ($status == 'all') {
                    $order = 'reg_time desc';
                }
                if ($status == 'real') {
                    $where['real_status'] = 2;
                    $order                = 'real_time desc';
                }
                if ($status == 'pay') {
                    $where['pay_status'] = 2;
                    $order               = 'pay_time desc';
                }
                if ($status == 'black') {
                    $where['black_status'] = 1;
                    $order                 = 'black_time desc';
                }

            }
            if (I('join_status', '', 'trim')) {
                $where['join_status'] = array('in', I('join_status', '', 'trim'));
            }
            if (I('start_time') && I('end_time')) {
                $where['reg_time'] = array('between', array(strtotime(I('start_time', '', 'trim')), strtotime(I('end_time', '', 'trim'))));
            }
            if (I('selectName') && I('keyWord')) {
                $where = self::searchTrans(I('selectName'), I('keyWord', '', 'trim'), $where);
            }
            $limit         = I('post.offset') . ',' . I('post.limit');
            $list          = $userModel->getUserList($where, '*', $order, $limit);
            $black_status1 = C('black_status1');
            $real_status   = C('real_status');
            $pay_status    = C('pay_status');
            foreach ($list['rows'] as $key => $value) {
                $list['rows'][$key]['sex_name']          = sex_trans($value['sex']);
                $list['rows'][$key]['reg_time_name']     = format_time($value['reg_time']);
                $list['rows'][$key]['black_status_name'] = $black_status1[$value['black_status']];
                $list['rows'][$key]['black_time_name']   = format_time($value['black_time']);
                $list['rows'][$key]['real_status_name']  = $real_status[$value['real_status']];
                $list['rows'][$key]['pay_status_name']   = $pay_status[$value['pay_status']];
                $list['rows'][$key]['age']               = $value['card_num'] ? get_age_by_id_card($value['card_num']) : '';
                $list['rows'][$key]['real_status_time']  = format_time($value['real_time']);
                $list['rows'][$key]['pay_status_time']   = format_time($value['pay_time']);
                //这里更新用户的最新年龄
                if ($list['rows'][$key]['age']) {
                    $userModel->update(array('age' => $list['rows'][$key]['age']), array('id' => $value['id']));
                }
            }
            //因为是多个列表加上状态缓存
            S('userList_' . $status . get_user_id(), $list['rows']);
            echo json_encode($list);
            exit;
        }
        //配置列表
        $this->assign('userTabList', C('user_tab'));
        $this->display();
    }

    /**
     * 格式化搜索条件
     * @author Red
     * @date 2016年11月24日17:37:49
     * @param $selectName
     * @param $keyWord
     * @return array
     */
    private function searchTrans($selectName, $keyWord, &$where)
    {
        switch ($selectName) {
            case 'username':
                $where['username'] = array('like', '%' . $keyWord . '%');
                break;
            case 'card_num':
                $where['card_num'] = array('like', '%' . $keyWord . '%');
                break;
            case 'age':
                $where['age'] = $keyWord;
                break;
            case 'sex':
                $where['sex'] = $keyWord == '男' ? 1 : ($keyWord == '女' ? 0 : 100);
                break;
            case 'education':
                $where['te.name'] = array('like', '%' . $keyWord . '%');
                break;
            default:
                return true;
        }

        return $where;
    }

    /**
     * 实名审核
     * @author Red
     * @date 2016年11月3日09:38:20
     */
    public function realAudit()
    {
        if ($_POST['other'] == 'list') {
            if (I('status') == 1) {
                $where['status'] = 0;//审核中
                $order           = 'em_user_real_audit.create_time asc ';
            } else {
                $where['status'] = array('in', '1,2');//已审核 包括通过认证和拒绝认证
                $order           = 'em_user_real_audit.audit_time desc ';
            }
            $userRealAuditModel = new  UserRealAuditModel();
            $limit              = I('post.offset') . ',' . I('post.limit');
            $educationList      = get_config_table_list('tb_education');
            $filed              = 'u.*,u.id as em_user_id,em_user_real_audit.*,em_user_real_audit.serialize as real_serialize,em_user_real_audit.create_time as apply_time,em_user_real_audit.id as audit_id,em_user_real_audit.status as audit_status';
            $list               = $userRealAuditModel->getUserRealList($where, $filed, $order, $limit);
            foreach ($list['rows'] as $key => $value) {
                if ($where['status'] == 0) {
                    $serialize                       = unserialize($value['real_serialize']);
                    $list['rows'][$key]['sex']       = $serialize['sex'];
                    $list['rows'][$key]['true_name'] = $serialize['true_name'];
                    $list['rows'][$key]['card_num']  = $serialize['card_num'];
                    $list['rows'][$key]['age']       = $serialize['age'];
                }
                $list['rows'][$key]['education_name'] = $educationList[$value['education_id']]['name'];
                $list['rows'][$key]['reg_time_name']  = format_time($value['reg_time']);
                $list['rows'][$key]['apply_time']     = format_time($value['apply_time']);
                $list['rows'][$key]['audit_time']     = format_time($value['audit_time']);
                $list['rows'][$key]['attach_ids']     = rtrim($value['attach_ids'], ',');
            }

            echo json_encode(array('total' => $list['total'], 'rows' => $list['rows']));
            exit;
        }
        //配置列表
        $this->assign('realauditTabList', C('realaudit_tab'));
        $this->display();
    }

    /**
     * 通过实名认证改写
     * @author xiaoyu
     * @date 2016年11月3日10:19:41
     */
    public function passRealAudit()
    {
        $auditId = I('auditId', 0, 'int');
        if ($auditId && IS_POST) {
            $realAudit = new UserRealAuditModel();
            trans_start();
            if (false === $realAudit->passRealAudit($auditId)) {
                trans_back();
            }
            trans_commit();

        }
        exit(returnStatus(0, L('OPERATE_FAIL')));
    }

    /**
     * 拒绝实名认证改写
     * @author xiaoyu
     * @date 2016年11月3日14:07:36
     */
    public function denyRealAudit()
    {
        $auditId = I('auditId', 0, 'int');
        if ($auditId && IS_POST) {
            $realAudit = new UserRealAuditModel();

            $data['refuse_type'] = check_post('refuse_type', L('ERROR_TYPE'), 2, 0);
            $refuse              = M('tb_realaudit_refuse_type')->where(array('id' => $data['refuse_type']))->field('name')->find();
            $data['refuse_name'] = $refuse['name'];
            $data['description'] = check_post('description', L('SPECIFIC_REMARK'));
            trans_start();
            if (false === $realAudit->denyRealAudit($auditId, $data)) {
                trans_back();
            };
            trans_commit();
        }

        $this->assign('auditId', $auditId);
        $this->display();
    }

    /**
     * 支付审核
     * @author Red
     * @date 2016年11月3日09:38:20
     */
    public function payAudit()
    {
        if ($_POST['other'] == 'list') {
            $limit     = I('post.offset') . ',' . I('post.limit');
            $cardModel = new UserCardListModel();
            if (I('status') == 0) {
                $where['em_user_card_list.status'] = 0;
                $order                             = 'em_user_card_list.create_time asc ';
            } else {
                $where['em_user_card_list.status'] = array('in', '1,2');
                $order                             = 'em_user_card_list.audit_time desc ';
            }
            $where['em_user_card_list.status_1'] = 1;//排除已删除的
            $join[]                              = 'em_user u ON u.id = em_user_card_list.user_id';
            $join[]                              = 'em_tb_bank b on em_user_card_list.bank_id=b.id';
            $list                                = $cardModel->get($where, "*,u.reg_time as user_reg_time,em_user_card_list.id as card_id,u.id as uid,b.name as bank_name,em_user_card_list.status as card_status,em_user_card_list.create_time as apply_time", true, $join, 'LEFT', $order, $limit);
            foreach ($list as $key => $value) {
                $list[$key]['reg_time_name'] = format_time($value['user_reg_time']);
                $list[$key]['apply_time']    = format_time($value['apply_time']);
                $list[$key]['audit_time']    = format_time($value['audit_time']);
            }
            $total = $cardModel->get($where, "*", true, $join, 'LEFT', '', '');
            //print_r($cardModel->getLastSql());
            echo json_encode(array('total' => count($total), 'rows' => $list));
            exit;
        }
        //配置列表
        $this->assign('payauditTabList', C('payaudit_tab'));
        $this->display();
    }

    /**
     * 通过支付认证
     * @author Red
     * @date 2016年11月7日10:15:30
     */
    public function passPayAudit()
    {
        $userId = I('userId', 0, 'int');
        $cardId = I('id', 0, 'int');
        if ($userId && $cardId && IS_POST) {
            trans_start();
            $cardModel = new UserCardListModel();

            if (false === $cardModel->passPayAudit($cardId)) {
                trans_back();
            }

            trans_commit();

        }
        exit(returnStatus(0, L('OPERATE_FAIL')));
    }

    /**
     * 拒绝支付认证
     * @author Red
     * @date 2016年11月3日14:07:36
     */
    public function denyPayAudit()
    {
        $userId = I('userId', 0, 'int');
        $cardId = I('cardId', 0, 'int');
        if ($userId && IS_POST && $cardId) {
            trans_start();
            $cardModel           = new UserCardListModel();
            $data['refuse_type'] = check_post('refuse_type', L('ERROR_TYPE'), 2, 0);
            $data['description'] = check_post('description', L('SPECIFIC_REMARK'));
            $refuse              = M('tb_payaudit_refuse_type')->where(array('id' => $data['refuse_type']))->field('name')->find();
            $data['refuse_name'] = $refuse['name'];
            if (false === $cardModel->denyPayAudit($cardId, $data)) {
                trans_back();
            };
            trans_commit();
        }
        $this->assign('userId', $userId);
        $this->assign('cardId', $cardId);
        $this->display();
    }

    /**
     * 任务历史
     * @author Red
     * @date 2016年11月24日15:13:58
     */
    public function userTaskHistory()
    {
        if (I('userId', 0, 'int'))
            W('User/userTaskHistory', array(I('userId', 0, 'int')));
    }

    /**
     * 查看照片
     * @author Red
     * @date
     */
    public function showUserPicture()
    {
        if (I('userId', 0, 'int'))
            W('User/userPicture', array(I('userId', 0, 'int')));
    }

    /**
     * 查看照片改写
     * @author xiaoyu
     * @date
     */
    public function viewUserPicture()
    {
        if (I('ids'))
            W('User/userPictureView', array(I('ids')));
    }

    /**
     * 黑名单操作
     * @author Red
     * @date 2016年11月24日15:17:21
     */
    public function blackTrans()
    {
        $userId = I('userId', 0, 'int');
        if ($userId) {
            $type      = I('type', 0, 'int');
            $userModel = new UserModel();
            trans_start();
            if ($type == 0) {
                //移出黑名单
                $res = $userModel->outBlackList($userId);
            } else {
                //加入黑名单
                $res = $userModel->joinBlackList($userId);
            }
            if ($res === false) {
                trans_back();
            }
            trans_commit();
        }
        exit(returnStatus(0, L('OPERATE_FAIL')));
    }

    /**
     * 导出
     * @author Red
     * @date 2016年11月25日09:48:11
     */
    public function exportUser()
    {
        $status          = I('get.status', 0, 'trim');
        $list            = S('userList_' . $status . get_user_id());
        $excelFieldsZHCN = C('user_tab_list_' . $status);
        exportExcels(array($list), array($excelFieldsZHCN['filed']), $excelFieldsZHCN['fileName'], array($excelFieldsZHCN['sheetName']));
    }
}