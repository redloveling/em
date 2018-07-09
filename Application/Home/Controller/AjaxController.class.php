<?php
namespace Home\Controller;

use Extend\FileUpload;
use Extend\Upload;
use Home\Model\MessageModel;
use Home\Model\TaskModel;
use Home\Model\UserCardListModel;
use Home\Model\UserModel;
use Home\Model\UserRealAuditModel;
use Home\Model\UserTaskModel;
use Think\Controller;

/**
 * ajax请求控制器
 * Class UserController
 * @package Home\Controller
 */
class AjaxController extends Controller
{
    /**
     * 获取子节点
     * @author Red
     * @date 2016年11月2日14:14:34
     */
    public function getChildNode()
    {
        $nodeId    = I('nodeId', 0, 'int');
        $nodeModel = D('admin_node');
        $nodeInfo  = $nodeModel->getAll(array('pid' => $nodeId));
        $this->ajaxReturn($nodeInfo);
    }

    /**
     * 获取当前任务下的所有人员
     * @author Red
     * @date 2016年11月22日10:24:20
     */
    public function getUserListByTaskId()
    {
        $taskId = I('taskId', 0, 'int');
        if ($taskId) {
            $userTaskModel = new UserTaskModel();
            $join[]        = 'inner join em_user u on u.id=em_user_task.user_id';
            $userList      = $userTaskModel->get(array('task_id' => $taskId), 'u.*', true, $join);
        }
        $this->ajaxReturn($userList);
    }

    /**
     * 获取某个类型下的所有人员
     * @author Red
     * @date 2016年11月22日10:24:20
     */
    public function getUserListByCategory()
    {
//        $userCategoryList = array(
//            1=>'全部用户',
//            2=>'黑名单',
//            3=>'实名认证',
//            4=>'支付认证',
//        );
        $userCategory = I('userCategory', 0, 'int');
        if ($userCategory) {
            $userModel = new UserModel();
            $where     = [];
            if ($userCategory == 1) {
            } elseif ($userCategory == 2) {
                $where['black_status'] = 1;
            } elseif ($userCategory == 3) {
                $where['real_status'] = 2;
            } elseif ($userCategory == 4) {
                $where['pay_status'] = 2;
            }
            $userList = $userModel->getAll($where, 'id,username,true_name,sex,age');
            foreach ($userList as $key => $value) {
                $userList[$key]['user'] = rtrim(($value['true_name'] ? $value['true_name'] : $value['username']) . ',' . sex_trans($value['sex']) . ',' . ($value['age'] ? $value['age'] : ''), ',');
            }
        }
        $this->ajaxReturn($userList);
    }

    /**
     * 上传文件
     * @author Red
     * @date 2016年11月24日14:14:05
     */
    public function fileUpload()
    {
        $file_name  = I('get.file_name', '', 'trim');
        $type       = I('get.type', '', 'trim') ? I('get.type', '', 'trim') : 'file';
        $attachment = C('attachment');
        $file_path  = __ROOT__ . $attachment[$type]['file_path'] . date('Ymd', time()) . '/';
        //创建文件
        if (!is_dir($file_path)) {
            $res = mkdir(iconv("UTF-8", "GBK", $file_path), 0777, true);
            if (!$res) {
                exit(returnStatus(0, L('CREATE_FILE_FAIL')));
            }
        }
        $up = new FileUpload();// 实例化上传类
        //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
        $up->set("path", $file_path);
        $up->set("allowtype", $attachment[$type]['file_type']);
        $up->set("israndname", $attachment[$type]['is_random']);
        //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
        $res = array();
        if ($up->upload($file_name)) {
            $currentFileName = $up->getFileName();
            $fileName        = $up->getOriginName();
            $fileSize        = $up->getFileSize();
            $fileType        = $up->getFileType();
            //这里只传了一个文件
            $res['name']     = $fileName[0];
            $res['url']      = '/' . $file_path . $currentFileName[0];
            $res['fileSize'] = $fileSize[0];
            $res['fileType'] = $fileType[0];
            echo json_encode(array('data' => $res, 'status' => 1));
            exit;
        } else {
            echo json_encode(array('msg' => $up->getErrorMsg(), 'status' => 0));
            exit;
        }
    }

    /**
     * 获取某个用户的任务列表
     * @author Red
     * @date 2016年11月24日14:39:37
     */
    public function getUserTaskHistoryList()
    {
        $userId = I('userId', 0, 'int');
        if ($userId) {
            $limit          = I('post.offset') . ',' . I('post.limit');
            $userTaskModel  = new UserTaskModel();
            $list           = $userTaskModel->getUserTaskByUserId($userId, "*,k.status as taskstatus,em_user_task.create_time as usertaskcreatetime", '', $limit);
            $userTaskStatus = C('task_status');
            $wageType       = C('wages');
            $settlement     = get_config_table_list('tb_settlement');
            foreach ($list['rows'] as $key => $value) {
                $list['rows'][$key]['deadline_name']    = format_time($value['deadline']);
                $list['rows'][$key]['work_time_name']   = format_time($value['start_time']) . '~' . format_time($value['end_time']);
                $list['rows'][$key]['wage_name']        = $value['wages'] . '/' . $wageType[$value['wages_type']]['name'];//工资
                $list['rows'][$key]['settlement_name']  = $settlement[$value['settlement_type']]['name'];//结算方式
                $list['rows'][$key]['apply_time_name']  = format_time($value['usertaskcreatetime']);//报名时间
                $list['rows'][$key]['task_status_name'] = $userTaskStatus[$value['taskstatus']];//任务状态
                $list['rows'][$key]['is_join']          = $value['status_1'] == 3 ? '是' : '否';
            }
            echo json_encode($list);
        }
    }

    /**
     * 获取相关数量
     * @author Red
     * @date 2016年12月2日17:10:31
     */
    public function getMessageCount()
    {
        $message = array();
        //任务列表数量
        $taskModel            = new TaskModel();
        $message['taskCount'] = $taskModel->getCurrentTaskCount();

        //实名审核
        $userRealModel        = new UserRealAuditModel();
        $message['realCount'] = $userRealModel->getCount(array('status' => 0));

        //支付审核
        $cardModel           = new UserCardListModel();
        $message['payCount'] = $cardModel->getCount(array('status' => 0, 'status_1' => 1));

        //留言查看
        $messageModel             = new MessageModel();
        $map['em_message.status'] = 0;
        $map['em_message.type']   = 3;
        $map['send_uid']          = array('neq', '0');
        $join[]                   = 'inner join em_user u on u.id=em_message.send_uid';
        $list                     = $messageModel->get($map, '*', true, $join, 'left');
        $message['messageCount']  = count($list);
        $this->ajaxReturn($message);

    }

    /**
     * 当前区域下的子区域
     * @author Red
     * @date 2016年12月5日15:14:50
     */
    public function getNextArea()
    {
        $pid = I('pid', 0, 'int');
        if ($pid) {
            $workAreaModel = M('tb_work_area');
            $list          = $workAreaModel->where(array('pid' => $pid, 'status' => 1))->field('id,pid,name')->select();
            $this->ajaxReturn($list);
        }
    }

    /**
     * 获取任务各个状态的数量
     * @author Red
     * @date
     */
    public function getTaskStatusCount()
    {
        $taskModel = new TaskModel();
        $userInfo  = get_user_info();
        $where     = array();
        if (!$userInfo['isSuper']) {
            $where['business_id'] = $userInfo['business_id'];
        }
        $where['status'] = array('neq', 100);//排除已删除的
        $list            = $taskModel->getAll($where, 'status');
        $res             = array();
        $res['task']     = count($list);
        $res['task0']    = $res['task1'] = $res['task2'] = $res['task3'] = 0;
        foreach ($list as $value) {
            if ($value['status'] == 0) {
                $res['task0'] += 1;
            }
            if ($value['status'] == 1) {
                $res['task1'] += 1;
            }
            if ($value['status'] == 2) {
                $res['task2'] += 1;
            }
            if ($value['status'] == 3 || $value['status'] == 4) {
                $res['task3'] += 1;
            }
        }
        $this->ajaxReturn($res);
    }

    /**
     * 获取人员名单数量
     * @author Red
     * @date 2017年2月3日10:00:26
     */
    public function getUserStatusCount()
    {
        $userModel         = new UserModel();
        $res['user_all']   = $userModel->getCount(array('id' => array('neq', '0')));
        $res['user_black'] = $userModel->getCount(array('black_status' => 1));
        $res['user_real']  = $userModel->getCount(array('real_status' => 2));
        $res['user_pay']   = $userModel->getCount(array('pay_status' => 2));
        $this->ajaxReturn($res);
    }

    /**
     * 获取实名认证数量
     * @author Red
     * @date 2017年2月3日11:11:21
     */
    public function getRealStatusCount()
    {
        $userRealModel       = new UserRealAuditModel();
        $res['real_no']      = $userRealModel->getCount(array('status' => 0));
        $res['real_already'] = $userRealModel->getCount(array('status' => array('in', '1,2')));
        $this->ajaxReturn($res);
    }

    /**
     * 获取支付认证数量
     * @author Red
     * @date 2017年2月3日11:11:43
     */
    public function getPayStatusCount()
    {
        $cardModel                            = new UserCardListModel();
        $where1['em_user_card_list.status']   = 0;
        $where2['em_user_card_list.status']   = array('in', '1,2');
        $where1['u.black_status']             = $where1['u.black_status'] = 0;
        $where1['em_user_card_list.status_1'] = $where2['em_user_card_list.status_1'] = 1;
        $join[]                               = 'em_user u ON u.id = em_user_card_list.user_id';
        $list1                                = $cardModel->get($where1, "em_user_card_list.id", true, $join, 'LEFT');
        $list2                                = $cardModel->get($where2, "em_user_card_list.id", true, $join, 'LEFT');
        $res['pay_no']                        = count($list1);
        $res['pay_already']                   = count($list2);
        $this->ajaxReturn($res);
    }

    /**
     * 用户任务结算
     * @author Red
     * @date 2017年7月11日18:19:18
     */
    public function userTaskMoney()
    {
        $userId = I('userId', 0, 'int');
        $taskId = I('taskId', 0, 'int');
        if ($userId && $taskId) {
            $model                    = M('user_task_settlement');
            $data['user_id']          = $userId;
            $data['task_id']          = $taskId;
            $data['money']            = I('totalMoney');
            $data['remark']           = I('remark', '', 'trim');
            $serialize                = array();//serialize 只能有这几个
            $serialize['price']       = I('price');
            $serialize['count']       = I('count');
            $serialize['total']       = I('total');
            $serialize['total_money'] = $data['money'];
            $serialize['reward']      = I('reward');
            $serialize['debit']       = I('debit');
            $serialize['commission']  = I('commission');
            $info                     = $model->where(array('user_id' => $userId, 'task_id' => $taskId))->find();
            $data['serialize']        = serialize($serialize);
            $data['create_uid']       = get_user_id();
            $data['create_time']      = time();
            trans_start();
            if ($info) {
                //如果是已经结算了则不能再更改
                if ($info['status'] != 0) {
                    trans_back('任务已结算');
                }
                $res = $model->where(array('id' => $info['id']))->save($data);
            } else {
                $res = $model->add($data);
            }
            if (false === $res) {
                trans_back();
            }
            //加入日志
            $data['create_uid']  = get_user_id();
            $data['create_time'] = time();
            $logModel            = M('user_task_settlement_log');
            $res                 = $logModel->add($data);
            if (false === $res) {
                trans_back();
            }
            //用户任务表
            $userTaskModel = new UserTaskModel();
            if (false === $userTaskModel->moneyConfirm($data['money'], $userId, $taskId)) {
                trans_back();
            }
            trans_commit();

        }
        $this->ajaxReturn(array('status' => 0));
    }

    /**
     * 任务分账时的备注信息
     * @author Red
     * @date 2017年7月24日14:46:05
     */
    public function splitCardRemark()
    {
        $splitCardId = I('splitCardId', 0, 'int');
        $remark      = I('remark', '', 'trim');
        if ($splitCardId) {
            $model = M('settlement_split_card');
            $model->where('id=' . $splitCardId)->setField('remark', $remark);
        }
    }

    /**
     * 确认结算
     * @author Red
     * @date 2017年7月25日16:24:13
     */
    public function confirmSettlement()
    {
        $settlementId = I('settlementId', 0, 'int');
        if ($settlementId) {
            $model          = M('settlement');
            $settlementInfo = $model->where(array('id' => $settlementId))->find();
            if ($settlementInfo['status'] != 0) {
                $this->ajaxReturn(array('status' => 0, 'msg' => '结算出现错误，请联系管理员'));
            }
            //settlement 已结算
            if ($settlementInfo['month'] == 1) {
                $data['split_status'] = 0;
            }
            $data['status'] = 1;
            $model->where(array('id' => $settlementId))->save($data);

            $model_1 = M('settlement_split_card');
            $model_2 = M('user_task_settlement');
            $model_3 = M('user_card_list');
            $list    = $model_1->where(array('settlement_id' => $settlementId))->select();
            //任务结算表改为已结算
            foreach ($list as $value) {
                $where            = [];
                $where['task_id'] = $value['task_id'];
                $where['user_id'] = $value['user_id'];
                $model_2->where($where)->save(array('status' => 2));
                if ($settlementInfo['month'] == 1) {
                    $data                 = [];
                    $data['money']        = 0;
                    $data['split_status'] = 0;
                    $model_3->where(array('id' => $value['bank_id']))->data($data);
                }
                $model_1->where(array('id'=>$value['id']))->save(array('status'=>1));
            }
            M('settlement_split_wages')->where(array('settlement_id'=>$settlementId))->save(array('status'=>1));
            M('settlement_split_user')->where(array('settlement_id'=>$settlementId))->save(array('status'=>1));
            $this->ajaxReturn(array('status' => 1));

        }
        $this->ajaxReturn(array('status' => 0, 'msg' => '操作失败'));

    }

    /**
     * 确认已付款
     * @author Red
     * @date 2017年7月25日16:29:46
     */
    public function confirmPay()
    {
        $settlementId = I('settlementId', 0, 'int');
        if ($settlementId) {
            $model          = M('settlement');
            $settlementInfo = $model->where(array('id' => $settlementId))->find();
            if ($settlementInfo['status'] != 1) {
                $this->ajaxReturn(array('status' => 0, 'msg' => '结算出现错误，请联系管理员'));
            }
            //settlement 已付款
            $data['pay_uid']  = get_user_id();
            $data['pay_time'] = time();
            $data['status']   = 2;
            $model->where(array('id' => $settlementId))->save($data);

            $model_1 = M('settlement_split_card');
            $model_2 = M('user_task_settlement');
            $list    = $model_1->where(array('settlement_id' => $settlementId))->select();
            $model_1->where(array('settlement_id'=>$settlementId))->save(array('status'=>2));
            //任务结算表改为已付款
            foreach ($list as $value) {
                $where            = [];
                $where['task_id'] = $value['task_id'];
                $where['user_id'] = $value['user_id'];
                $model_2->where($where)->save(array('status' => 3));

            }
            M('settlement_split_user')->where(array('settlement_id'=>$settlementId))->save(array('status'=>2));
            M('settlement_split_wages')->where(array('settlement_id'=>$settlementId))->save(array('status'=>2));
            $this->ajaxReturn(array('status' => 1));
        }
        $this->ajaxReturn(array('status' => 0, 'msg' => '操作失败'));
    }
    public function getTemplateArr(){
        $templateId = I('templateId',0,'int');
        $templateP =I('templateP');
        if($templateId){
            $list = $templateP?C('template_brr'):C('template_arr');
            $this->ajaxReturn(array('status' => 1,'data'=>$list[$templateId]));
        }
        $this->ajaxReturn(array('status' => 0, 'msg' => '模板不存在'));
    }
}