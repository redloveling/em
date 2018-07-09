<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/8/9
 * Time: 15:28
 */
namespace Home\Model;

use Extend\SendShortMessage;

class UserModel extends CommonModel
{
    /**
     * 获取用户的基本信息
     * @author Red
     * @date 2016年11月23日17:25:08
     * @param $userId
     * @return mixed
     */
    public function getUserInfo($userId)
    {
        $userCardModel                 = M('user_card_list');
        $userInfo                      = $this->getOne(array('id' => $userId));
        $join2[]                       = 'inner join em_tb_bank tb on tb.id=em_user_card_list.bank_id';
        $userCardList                  = $userCardModel->join($join2)->field('em_user_card_list.*,tb.name as bank_name')->where(array('user_id' => $userId, 'em_user_card_list.status' => 1))->select();
        $userInfo['cardList']          = $userCardList;
        $educationList                 = get_config_table_list('tb_education');
        $black_status_name             = C('black_status');//黑名单
        $real_status                   = C('real_status');//实名
        $pay_status                    = C('pay_status');//支付
        $work_status                   = C('work_status');//工作状态
        $userInfo['black_status_name'] = $black_status_name[$userInfo['black_status']];
        $userInfo['real_status_name']  = $real_status[$userInfo['real_status']];
        $userInfo['pay_status_name']   = $pay_status[$userInfo['pay_status']];
        $userInfo['work_status_name']  = $work_status[$userInfo['work_status']];
        $userInfo['education_name']    = $educationList[$userInfo['education_id']]['name'];
        $userInfo['sex_name']          = sex_trans($userInfo['sex']);

        return $userInfo;
    }
    /**
     * 获取用户的身份证照片信息
     * @author xiaoyu
     * @date 2016年11月23日17:25:08
     * @param $userId
     * @return mixed
     */
    public function getUserPicture($ids)
    {
    	$id_arr = explode(',',$ids);
    	$pic_info = array();
    	foreach ($id_arr as $key=>$val){
    		$temp = D('attachment')->getById($val,$field = "file_key,file_location,create_uid");
    		if($temp['file_key']=='positive'){
    			$pic_info['id'] = $temp['create_uid'];
    			$pic_info['card_num_positive'] = $temp['file_location'];
    		}else{
    			$pic_info['card_num_opposite'] = $temp['file_location'];
    		}
    	}
    	return $pic_info;
    }
    /**
     * 获取用户列表
     * @author Red
     * @date 2016年11月24日15:52:25
     * @param $map
     * @param string $field
     * @param string $order
     * @param string $limit
     * @return array
     */
    public function getUserList($map, $field = '*', $order = '', $limit = '0,10')
    {
        //$join[] = 'inner join em_tb_education te on te.id=em_user.education_id';
        $educationList = get_config_table_list('tb_education');
        $field         = $field . ',em_user.id as uid';
        $list          = $this->get($map, $field, true, '', '', $order, $limit);
        foreach ($list as $key => $value) {
            $list[$key]['education_name'] = $educationList[$value['education_id']]['name'];
        }
        $total = $this->getCount($map);

        return array('total' => $total, 'rows' => $list);
    }

    /**
     * 用户加入黑名单相关操作
     * @author Red
     * @date 2016年12月6日10:21:02
     * @param $userId
     * @return bool
     */
    public function joinBlackList($userId)
    {
        //用户任务相关状态修改
        $userTaskModel = new UserTaskModel();
        $taskModel     = new TaskModel();
        //用户任务已报名--》报名失败
        $where1['status']   = 1;
        $where1['status_1'] = 1;
        $where1['user_id']  = $userId;
        if (false === $userTaskModel->update(array('status_1' => 2,'status_msg'=>'报名失败（拉黑）','black_time'=>time()), $where1)) {
            return false;
        }
        //用户任务报名成功--》报名失败
        $where2['status']   = 1;
        $where2['status_1'] = 3;
        $where2['user_id']  = $userId;
        //报名成功的任务人数减1
        $userTaskList = $userTaskModel->getAll($where2, 'task_id');
        $taskIds      = '';
        foreach ($userTaskList as $value) {
            $taskIds .= $value['task_id'] . ',';
        }
        $taskModel->where(array('id' => array('in', rtrim($taskIds, ','))))->setDec('entered_count');
        if (false === $userTaskModel->update(array('status_1' => 2,'black_time'=>time()), $where2)) {
            return false;
        }

        //用户任务任务中--》任务外
        $where3['status']   = 2;
        $where3['status_2'] = 2;
        $where3['user_id']  = $userId;
        if (false === $userTaskModel->update(array('status_1' => 2,'status_msg'=>'任务外（拉黑）','black_time'=>time()), $where3)) {
            return false;
        }
        //user表更改状态
        if (false === $this->update(array('black_status' => 1, 'black_time' => time()), array('id' => $userId))) {
            return false;
        }
        //发送消息
        $messageModel = new MessageModel();
        if (false === $messageModel->insertMessageFromTemplate($userId, 1)) {
            return false;
        };
        //日志
        insert_user_log($userId, '加入黑名单', get_user_id());

        return true;
    }

    /**
     * 移出黑名单
     * @author Red
     * @date 2017年3月3日10:48:21
     * @param $userId
     * @return bool
     */
    public function outBlackList($userId)
    {
        if (false === $this->update(array('black_status' => 0, 'black_time' => 0), array('id' => $userId))) {
            return false;
        }
        //日志
        insert_user_log($userId, '移出黑名单', get_user_id());

        return true;
    }

    /**
     * 添加用户
     * @author Red
     * @date 2016年12月9日14:05:54
     * @param $userName
     * @param $nickName
     * @param $password
     * @param $type
     * @param $pId
     * @return bool
     */
    public function addUser($userName, $nickName, $password, $type, $pId)
    {
        $data['pid']       = $pId ? $pId : 0;
        $data['type']      = $type;
        $data['username']  = $userName;
        $data['salt']      = getSalt();
        $data['password']  = compilePassword($password, $data['salt']);
        $data['nick_name'] = $nickName;
        $data['tell']      = $userName;
        $data['reg_time']  = time();
        $userId            = $this->insert($data);
        if (!$userId) {
            saveLog('Api/register', '用户注册失败sql=>' . $this->getLastSql());

            return false;
        }
        //推广码 //二维码
        $dataC['user_code'] = generate_extension_code($userId);
        $dataC['qr_code']   = generate_qr_code($dataC['user_code'], $dataC['user_code']);
        if (false === $this->update($dataC, array('id' => $userId))) {
            saveLog('Api/register', '用户注册失败sql=>' . $this->getLastSql());

            return false;
        }

        return $userId;
    }

    /**
     * 用户登陆
     * @author Red
     * @date 2016年12月9日15:20:45
     * @param $userId
     * @return mixed
     */
    public function userLogin($userId)
    {
        $userInfo = $this->getById($userId);
        //把登陆成功后的用户信息放入session中
        session('uid', $userId);
        session('user_info', $userInfo);
        //更新登陆时间
        $this->update(array('last_login' => time()), array('id' => $userId));
        saveLog('用户登陆成功' . session('tt') . 'id=>' . session('tt') . session('ttt') . $userInfo['id'] . 'username=>' . $userInfo['username'], 'appLoginSuccess');
        $table = M('tb_education');//get_config_table_list('tb_education')
        $list  = $table->where(array('status' => 1))->select();
        foreach ($list as $value) {
            $lists[$value['id']] = $value;
        }
        $userInfo['education_name'] = $lists[$userInfo['education_id']]['name'];

        return $userInfo;
    }

    /**
     * 重置密码
     * @author Red
     * @date 2016年12月9日16:05:02
     * @param $username
     * @param $password
     * @return bool|mixed
     */
    public function userPasswordReset($username, $password)
    {
        $data['salt']     = getSalt();
        $data['password'] = compilePassword($password, $data['salt']);
        $userInfo         = $this->getOne(array('username' => $username));
        if (!$userInfo) {
            return false;
        }
        if (!$this->update($data, array('username' => $username))) {
            return false;
        }
        //更新登陆时间
        $this->update(array('last_login' => time()), array('username' => $username));

        return $userInfo;
    }

    /**
     * 递归获取所有用户下面的子用户
     * @author Red
     * @date 2016年12月13日12:00:54
     * @return mixed
     */
    public function getRecursionUserList()
    {
        $list = $this->getAll();
        foreach ($list as $key => $value) {
            $lists[$value['id']]          = $value;
            $lists[$value['id']]['child'] = self::getChildList($value['id']);
        }
        foreach ($lists as $key => $value) {
            if ($value['child']) {
                foreach ($value['child'] as $v) {
                    if ($v['pid'] == $value['id']) {
                        $lists[$key]['direct_child'][] = $v;
                    } else {
                        $lists[$key]['indirect_child'][] = $v;
                    }
                }
            }

        }

        return $lists;
    }

    /**
     * 根据用户id获取该用户下面的子用户
     * @author Red
     * @date 2016年12月13日12:01:31
     * @param int $userId
     * @return array
     */
    public function getRecursionUserById($userId = 0)
    {
        $userList  = $this->getAll(array('id' => $userId));
        $childList = self::getChildList($userId);

        return array_merge($userList, $childList);
    }

    /**
     * 递归调用
     * @author Red
     * @date 2016年12月13日12:01:52
     * @param $pid
     * @return array|mixed
     */
    private function getChildList($pid)
    {
        $list = $this->getAll(array('pid' => $pid, 'type' => 0));
        if ($list) {
            foreach ($list as $value) {
                $childList = $this->getChildList($value['id']);

                $list = array_merge($list, $childList);
            }
        }

        return $list;
    }

    /**
     * 用户推广列表
     * @author Red
     * @date 2016年12月13日14:36:40
     * @param $map
     * @param $order
     * @param string $limit
     * @param array $otherSort
     * @return array
     */
    public function getUserExtensionList($map, $order, $limit = '0,10', $otherSort = array())
    {
        $list              = $this->getUserList($map, '*', $order, $limit);
        $userRecursionList = $this->getRecursionUserList();
        foreach ($list['rows'] as $key => $value) {
            $list['rows'][$key]['direct_count']   = count($userRecursionList[$value['uid']]['direct_child']);
            $list['rows'][$key]['indirect_count'] = count($userRecursionList[$value['uid']]['indirect_child']);
        }

        if ($otherSort) {
            foreach ($list['rows'] as $key => $value) {
                $num1[$key] = $value[$otherSort['key']];
            }
            $sort = $otherSort['sort'] == 'asc' ? SORT_ASC : SORT_DESC;
            array_multisort($num1, $sort, $list['rows']);
        }

        return array('total' => $list['total'], 'rows' => $list['rows']);
    }

    /**
     * 判断该用户是否可以报名
     * @author Red
     * @date 2016年12月21日15:44:56
     * @param $userId
     * @param $taskId
     * @return bool|mixed
     */
    public function judgeUserCanJoinWork($userId, $taskId)
    {
        $userInfo = $this->getById($userId);
        //是否黑名单
        if ($userInfo['black_status'] == 1) {
            //return '黑名单用户';
            return '报名失败，请联系管理员';
        }
        //是否实名认证
        if ($userInfo['real_status'] != 2) {
            //return '未通过实名认证';
            return '请先到"我 - > 实名认证"界面完善相关信息';
        }
        //是否支付认证
        if ($userInfo['pay_status'] != 2) {
            //return '未通过支付认证';
            return '请先到"我 - > 支付认证"界面完善相关信息';
        }
        //是否通过基础培训
        if ($userInfo['train_status'] == 0) {
            //return '未通过基础培训';
            return '请先到"我 - > 基础培训"界面完善相关信息';
        }
        $taskModel = new TaskModel();
        $taskInfo  = $taskModel->getById($taskId);

        //是否超过报名截止时间
        if ($taskInfo['deadline'] < time()) {
            return '超过报名截止时间';
        }
        //性别是否符合
        if ($taskInfo['person_type'] != 2 && $userInfo['sex'] != $taskInfo['person_type']) {
            return '性别不符合';
        }
        //任务状态
        if ($taskInfo['status'] != 1) {
            return '任务状态错误';
        }
        //只有取消报名才能重新报名
        $userTaskModel = new UserTaskModel();
        $userTaskInfo  = $userTaskModel->getOne(array('user_id' => $userId, 'task_id' => $taskId), 'status_1');
        if ($userTaskInfo && $userTaskInfo['status_1'] == 1) {
            return '任务正在审核中';
        }
        if ($userTaskInfo && $userTaskInfo['status_1'] == 2) {
            return '已被拒绝参加该任务';
        }
        if ($userTaskInfo && $userTaskInfo['status_1'] == 3) {
            return '已报名';
        }
        if ($userTaskModel->getCount(array('status' => 1, 'status_1' => 3,'task_id' => $taskId)) >= $taskInfo['person_num']) {
            return '已到报名人数上限';
        }

        return true;
    }
}