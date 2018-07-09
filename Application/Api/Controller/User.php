<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/12/7
 * Time: 10:22
 */


use Home\Model\AdminUserModel;
use Home\Model\ChannelModel;
use Home\Model\UserModel;

class User extends \Api\Controller\BaseApiController
{
    /**
     * app用户注册接口
     * @author Red
     * @date 2016年12月9日13:38:39
     */
    public function userRegister()
    {
        $userName        = parent::checkData('phone_number', '请填写手机号码');
        $nickName        = parent::checkData('nick_name', '请填写昵称');
        $password        = parent::checkData('password', '请填写密码');
        $confirmPassword = parent::checkData('confirm_password', '请填写确认密码');
        $userCode        = I('user_code', '', 'trim');
        if (strlen($password) < 6) {
            parent::formatErrData('密码长度不能小于6位');
        }
        if ($password != $confirmPassword) {
            parent::formatErrData('两次密码不一样');
        }
        if (preg_match("/[\x7f-\xff]/", $userName)) {
            parent::formatErrData('含有中文');
        }
        $userModel    = new UserModel();
        $channelModel = new ChannelModel();
        if ($userModel->getOne(array('username' => $userName))) {
            parent::formatErrData('该用户已存在');
        }
        $pId  = 0;
        $type = 0;
        if ($userCode) {
            $userInfo = $userModel->getOne(array('user_code' => $userCode));
            $pId      = $userInfo['id'];
            if (!$pId) {
                $channelInfo = $channelModel->getOne(array('extension_code' => $userCode, 'status' => 1));
                $pId         = $channelInfo['id'];
                $type        = 1;
            }
            if (!$pId) {
                parent::formatErrData('邀请码不存在');
            }
        };
        //为保护用户隐私昵称隐藏一部分
        if($userName==$nickName){
            $nickName = substr_replace($nickName,'****',3,4);
        }
        $userId = $userModel->addUser($userName, $nickName, $password, $type, $pId);
        if ($userId) {
            //添加日志
            api_insert_user_log($userId, '用户注册成功');
            parent::formatSuccessData($userId, '注册成功');
        }
        parent::formatErrData('注册失败');
    }

    /**
     * app用户登陆
     * @author Red
     * @date 2016年12月9日15:22:42
     */
    public function userLogin()
    {
        $username  = parent::checkData('phone_number', '请填写手机号码');
        $password  = parent::checkData('password', '请填写密码');
        $userModel = new UserModel();
        $userInfo  = $userModel->getOne(array('username' => $username), 'id,salt,password');
        if (!$userInfo) {
            parent::formatErrData('该用户不存在');
        }
        if ($userInfo['password'] != compilePassword($password, $userInfo['salt'])) {
            parent::formatErrData('密码错误');
        }
        //parent::formatSuccessData($userModel->userLogin($userInfo['id']), '登陆成功');

        $userModel = new UserModel();
        $userInfo  = $userModel->getUserInfo($userInfo['id']);
        $table     = M('tb_education');//get_config_table_list('tb_education')
        $list      = $table->where(array('status' => 1))->select();
        foreach ($list as $value) {
            $lists[$value['id']] = $value;
        }
        unset($userInfo['cardList']);//去掉银行卡列表
        $serialize                  = unserialize($userInfo['serialize']);
        $userInfo['transport']      = $serialize['transport'];
        $userInfo['freeDay']        = $serialize['freeDay'];
        $userInfo['school']         = $serialize['school'] ? $serialize['school'] : '';
        $userInfo['grade']          = $serialize['grade'] ? $serialize['grade'] : '';
        $userInfo['education_name'] = $lists[$userInfo['education_id']]['name'];
        parent::formatSuccessData($userInfo, '获取成功');
    }

    /**
     * app重置密码
     * @author Red
     * @date 2016年12月9日15:56:55
     */
    public function userPasswordReset()
    {
        $userName        = parent::checkData('phone_number', '请填写手机号码');
        $oldPassword     = parent::checkData('oldPassword', '请填写原密码');
        $password        = parent::checkData('password', '请填写密码');
        $confirmPassword = parent::checkData('confirm_password', '请填写确认密码');
        $userModel       = new UserModel();
        $userInfo        = $userModel->getById(I('user_id'));
        if ($userInfo['username'] != $userName) {
            parent::formatErrData('用户错误');
        }
        if ($userInfo['password'] != compilePassword($oldPassword, $userInfo['salt'])) {
            parent::formatErrData('原密码错误');
        }
        if (strlen($password) < 6) {
            parent::formatErrData('密码长度不能小于6位');
        }
        if ($password != $confirmPassword) {
            parent::formatErrData('两次密码不一样');
        }

        $userInfo = $userModel->userPasswordReset($userName, $password);
        if ($userInfo) {
            parent::formatSuccessData($userInfo, '更改成功');
        }
        parent::formatErrData('更改失败');
    }

    /**
     * 忘记密码
     * @author Red
     * @date 2016年12月16日15:22:18
     */
    public function userPasswordForget()
    {
        $userName        = parent::checkData('phone_number', '请填写手机号码');
        $password        = parent::checkData('password', '请填写密码');
        $confirmPassword = parent::checkData('confirm_password', '请填写确认密码');
        $userModel       = new UserModel();
        $userInfo        = $userModel->getOne(array('username' => $userName));
        if (!$userInfo) {
            parent::formatErrData('没有该用户');
        }
        if (strlen($password) < 6) {
            parent::formatErrData('密码长度不能小于6位');
        }
        if ($password != $confirmPassword) {
            parent::formatErrData('两次密码不一样');
        }
        $userInfo = $userModel->userPasswordReset($userName, $password);
        if ($userInfo) {
            parent::formatSuccessData($userInfo, '更改成功');
        }
        parent::formatErrData('更改失败');
    }

    /**
     * 获取用户的基本信息
     * @author Red
     * @date 2016年12月9日15:26:59
     */
    public function getUserInfo()
    {
        $userId    = parent::checkData('user_id', '缺少用户id');
        $userModel = new UserModel();
        $userInfo  = $userModel->getUserInfo($userId);
        $table     = M('tb_education');//get_config_table_list('tb_education')
        $list      = $table->where(array('status' => 1))->select();
        foreach ($list as $value) {
            $lists[$value['id']] = $value;
        }
        unset($userInfo['cardList']);//去掉银行卡列表
        $serialize                  = unserialize($userInfo['serialize']);
        $userInfo['transport']      = $serialize['transport'];
        $userInfo['freeDay']        = $serialize['freeDay'];
        $userInfo['school']         = $serialize['school'] ? $serialize['school'] : '';
        $userInfo['grade']          = $serialize['grade'] ? $serialize['grade'] : '';
        $userInfo['education_name'] = $lists[$userInfo['education_id']]['name'];
        parent::formatSuccessData($userInfo, '获取成功');
    }

    /**
     *
     * 修改简历
     * @author Red
     * @date 2016年12月19日14:27:38
     */
    public function userResume()
    {
        $userId            = parent::checkData('user_id', '缺少用户id');
        $userModel         = new UserModel();
        $userInfo          = $userModel->getUserInfo($userId);
        $serialize         = unserialize($userInfo['serialize']);
        $data['nick_name'] = parent::checkData('nick_name', '昵称');
        if ($userInfo['real_status'] == 0 || $userInfo['real_status'] == 1) {
            $data['sex']      = I('sex', 0, 'int');
            $data['birthday'] = parent::checkData('birthday', '生日');
        }
        $data['work_status'] = parent::checkData('work_status', '工作状态');
        if ($data['work_status'] == 1) {
            $data['education_id'] = parent::checkData('education_id', '学历');
        }
        if ($data['work_status'] == 2) {
            $serialize['school'] = parent::checkData('school', '学校');
            $serialize['grade']  = parent::checkData('grade', '年级');

        }

        $serialize['transport'] = I('transport', '', 'trim');
        $serialize['freeDay']   = I('freeDay', '', 'trim');
        if ($_FILES['avatar_file']) {
            $uploadFile          = parent::uploadFile('/user/avatarFile/', $userId);
            $data['avatar_file'] = rtrim($uploadFile['headPhoto']['filePath'], ',');
        }
        $data['serialize'] = serialize($serialize);
        $userModel->update($data, array('id' => $userId));
        parent::formatSuccessData(1, '修改成功');
    }

    /**
     * 用户实名认证
     * @author Red
     * @date 2016年12月19日14:39:20
     */
    public function userRealAudit()
    {
        $userId                         = parent::checkData('user_id', '缺少用户id');
        $serialize['true_name']         = parent::checkData('true_name', '真实姓名');
        $serialize['card_num']          = parent::checkData('card_num', '身份证号');
        $res                            = parent::uploadFile('/user/idCard/', $userId);
        $serialize['card_num_positive'] = rtrim($res['positive']['filePath'], ',');
        $serialize['card_num_opposite'] = rtrim($res['negative']['filePath'], ',');
        $serialize['age']               = $serialize['card_num'] ? self::getAgeByIdCard($serialize['card_num']) : '';
        if ($serialize['card_num']) {
            $birth                 = strlen($serialize['card_num']) == 15 ? ('19' . substr($serialize['card_num'], 6, 6)) : substr($serialize['card_num'], 6, 8);
            $serialize['sex']      = substr($serialize['card_num'], (strlen($serialize['card_num']) == 18 ? -2 : -1), 1) % 2 ? '1' : '0';
            $serialize['birthday'] = date('Y-m-d', strtotime($birth));
        }
        if ($serialize['age'] < 18) {
            parent::formatErrData('用户未满18岁不能进行实名认证');
        }
        $userModel = new UserModel();
        $userInfo  = $userModel->getById($userId);

        if ($userInfo['real_status'] == 2) {
            parent::formatErrData('该用户已经完成实名认证');
        }
        #以前说好的不加日志现在又要加真是@#￥&%#！
        $dataReal['uid']         = $userId;
        $dataReal['create_time'] = time();
        $dataReal['attach_ids']  = rtrim($res['positive']['attIds'] . $res['negative']['attIds'],',');
        $dataReal['serialize']   = serialize($serialize);
        $userReal                = new  \Home\Model\UserRealAuditModel();
        if($userReal->getOne(array('uid'=>$userId,'status'=>0))){
            parent::formatErrData('已提交申请，请耐心等待');
        }
        if($userReal->getOne(array('uid'=>$userId,'status'=>1))){
            parent::formatErrData('已通过实名认证');
        }
        $userReal->insert($dataReal);
        //添加日志
        api_insert_user_log($userId,'发起实名认证申请');
        $userModel->update(array('real_status'=>1), array('id' => $userId));
        parent::formatSuccessData(1, '成功');
    }

    /**
     * 根据身份证号码计算年龄
     * @author Red
     * @date 2016年12月26日14:54:07
     * @param $idCard
     * @return float
     */
    private function getAgeByIdCard($idCard)
    {
        $date  = strtotime(substr($idCard, 6, 8));//获得出生年月日的时间戳
        $today = strtotime('today');//获得今日的时间戳
        $diff  = floor(($today - $date) / 86400 / 365);//得到两个日期相差的大体年数
        //strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比
        return strtotime(substr($idCard, 6, 8) . ' +' . $diff . 'years') > $today ? ($diff + 1) : $diff;
    }

    /**
     * 添加用户银行卡
     * @author Red
     * @date 2016年12月19日15:04:41
     */
    public function userPayAudit()
    {
        $userId                 = parent::checkData('user_id', '缺少用户id');
        $data['user_id']        = $userId;
        $data['owner']          = parent::checkData('owner', '持卡人');
        $data['card_no']        = parent::checkData('card_no', '卡号');
        $data['bank_id']        = parent::checkData('bank_id', '银行卡类型');
        $data['reserve_mobile'] = parent::checkData('reserve_mobile', '预留手机');
        $data['reserve_num']    = parent::checkData('reserve_num', '预留身份证');
        $data['status_1']       = 1;
        $data['create_time']    = time();
        $userCardModel          = new \Home\Model\UserCardListModel();
        if ($userCardModel->getOne(array('card_no' => $data['card_no'], 'status_1' => 1))) {
            parent::formatErrData('银行卡已经存在');
        }
        $userCardModel->insert($data);
        if (!$userCardModel->getOne(array('user_id' => $userId, 'status_1' => 1, 'status' => 1))) {
            $userModel = new UserModel();
            $userModel->update(array('pay_status' => 1), array('id' => $userId));
        }
        parent::formatSuccessData(1);
    }

    /**
     * 删除用户银行卡
     * @author Red
     * @date 2016年12月19日15:31:05
     */
    public function userDeleteBank()
    {
        $userId        = parent::checkData('user_id', '缺少用户id');
        $userCardId    = parent::checkData('user_card_id', '银行卡id');
        $userCardModel = new \Home\Model\UserCardListModel();
        $userCardModel->update(array('status_1' => 0), array('id' => $userCardId));
        $userCardInfo = $userCardModel->getById($userCardId);
        if ($userCardInfo['is_default'] == 1) {
            //添加默认的
            $cardNew = $userCardModel->getOne(array('user_id' => $userId, 'status' => 1, 'status_1' => 1), 'id');
            if ($cardNew)
                $userCardModel->update(array('is_default' => 1), array('id' => $cardNew['id']));
        }
        parent::formatSuccessData(1);
    }

    /**
     * 设置用户默认银行卡
     * @author Red
     * @date 2016年12月22日15:49:44
     */
    public function setUserDefaultBank()
    {
        $userCardId    = parent::checkData('user_card_id', '银行卡id');
        $userId        = parent::checkData('user_id', '缺少用户id');
        $userCardModel = new \Home\Model\UserCardListModel();
        $userCardModel->update(array('is_default' => 0), array('user_id' => $userId));
        $userCardModel->update(array('is_default' => 1), array('id' => $userCardId));
        parent::formatSuccessData(1);
    }

    /**
     * 获取用户的银行卡
     * @author Red
     * @date 2016年12月19日15:51:17
     */
    public function getUserCardList()
    {
        $userId        = parent::checkData('user_id', '缺少用户id');
        $userCardModel = new \Home\Model\UserCardListModel();
        $model         = M('tb_bank');
        $list          = $userCardModel->getAll(array('user_id' => $userId, 'status_1' => 1));
        $cardList      = $model->where(array('status' => 1))->select();

        foreach ($cardList as $key => $value) {
            $cardLists[$value['id']] = $value;
        }
        foreach ($list as $key => $value) {
            $list[$key]['bank_name'] = $cardLists[$value['bank_id']]['name'];
        }
        parent::formatSuccessData($list);
    }


    /**
     * 用户留言
     * @author Red
     * @date 2016年12月20日11:22:16
     */
    public function userLeaveMessage()
    {
        $userId              = parent::checkData('user_id', '缺少用户id');
        $data['content']     = parent::checkData('content', '留言');
        $data['star_label']  = parent::checkData('star_label', '星级');
        $data['type']        = 3;
        $data['send_uid']    = $userId;
        $data['get_uid']     = 1;
        $data['create_time'] = time();
        $data['create_uid']  = $userId;
        $_FILES['message_image'] && $uploadFile = parent::uploadFile('/user/leave_message/', $userId);
        $data['att_ids'] = $uploadFile['advice']['attIds'];
        $messageModel    = new \Home\Model\MessageModel();
        $messageModel->insert($data);
        parent::formatSuccessData(1, '留言成功');
    }

    /**
     * 用户推广
     * @author Red
     * @date 2016年12月21日15:10:32
     */
    public function getUserExtension()
    {
        $info             = array();
        $userId           = parent::checkData('user_id', '缺少用户id');
        $userModel        = new UserModel();
        $userInfo         = $userModel->getById($userId, 'id,pid,type,user_code,qr_code,reg_time,nick_name');
        $info['userInfo'] = $userInfo;
        if ($userInfo['type'] == 1) {
            //渠道推广
            $channelModel           = new ChannelModel();
            $channelInfo            = $channelModel->getById($userInfo['pid']);
            $info['parent']['name'] = $channelInfo['name'];
        } else {

            $parent                 = $userModel->getById($userInfo['pid']);
            $info['parent']['name'] = $parent['true_name'] ? $parent['true_name'] : $userInfo['nick_name'];
        }
        $childList          = $userModel->getAll(array('id' => array('neq', $userId), 'pid' => $userInfo['id'], 'type' => 0), 'id,nick_name,true_name,pid,type,user_code,qr_code,reg_time');
        $info['child']      = $childList;
        $info['childCount'] = count($childList);
        parent::formatSuccessData($info);
    }

    /**
     * 获取用户消息(系统消息)
     * @author Red
     * @date 2016年12月23日14:40:11
     */
    public function getUserSystemMessage()
    {
        $userId       = parent::checkData('user_id', '缺少用户id');
        $messageModel = new \Home\Model\MessageModel();
        $list         = $messageModel->getAll(array('get_uid' => $userId, 'type' => 1), 'id,content,status,create_time','status desc,create_time desc');
        $count        = count($list);
        //$noReadCount  = $messageModel->getCount(array('get_uid' => $userId, 'type' => 1, 'status' => 0));
        foreach ($list as $key => $value) {
            $list[$key]['count'] = $count;
            //$list[$key]['noReadCount'] = $noReadCount;
        }

        parent::formatSuccessData($list);
    }

    /**
     * 获取用户是否有留言
     * @author Red
     * @date 2017年1月22日15:23:28
     */
    public function getUserHaveMessage()
    {
        $userId       = parent::checkData('user_id', '缺少用户id');
        $messageModel = new \Home\Model\MessageModel();
        $list         = $messageModel->getAll(array('get_uid' => $userId, 'status' => 0, 'type' => array('in', '1,2')), 'id');
        if ($list) {
            parent::formatSuccessData(1);
        }
        parent::formatSuccessData(0);
    }

    /**
     * 检查培训结果
     * @author Red
     * @date 2016年12月19日17:21:45
     */
    public function checkQuestionResult()
    {
        $userId        = parent::checkData('user_id', '缺少用户id');
        $questionStr   = parent::checkData('question_arr', '问题参数');//格式 [{"id":"1","answer":"1,3,"},{"id":"2","answer":"有可能"},{"id":"8","answer":"1"},{"id":"9","answer":"2"},{"id":"10","answer":"bvjb"},{"id":"11","answer":"cjgvi"}]
        $questionModel = new \Home\Model\QuestionModel();
        $questionArr   = object_to_array(json_decode($questionStr));

        $questionList  = $questionModel->getAll(array('status' => 1));
        $questionCount = 0;
        foreach ($questionList as $key => $value) {
            $answer = unserialize($value['answer']);
            foreach ($questionArr as $k => $v) {

                if ($v['id'] == $value['id']) {

                    //填空题
                    if ($value['type'] == 0 && $v['answer'] == $answer[0]) {
                        $questionCount++;
                    }
                    //不定项选择
                    if (in_array($value['type'], array(1, 2))) {
                        $arr = explode(',', rtrim($v['answer'], ','));
                        sort($arr);
                        $brr = array_keys($answer);
                        sort($brr);
                        if ($arr == $brr) {
                            $questionCount++;
                        }

                    }
                }
            }
        }
        //如果考试通过更改用户的基础培训状态
        if ($questionCount == count($questionList)) {
            $userModel = new UserModel();
            $userModel->update(array('train_status' => 1), array('id' => $userId));
            parent::formatSuccessData(1, '全部正确');
        } else {
            parent::formatSuccessData(0, '总共' . count($questionList) . '道题,对了' . $questionCount . '道。大侠请重新来过！');
        }

    }

    /**
     * 用户是否发送短信
     * @author Red
     * @date 2017年2月7日16:38:52
     */
    public function isSendShortMessage()
    {
        $userId         = parent::checkData('user_id', '缺少用户id');
        $isShortMessage = parent::checkData('is_message', '缺少发送消息关键字');
        $userModel      = new UserModel();
        $userModel->update(array('is_shortmessage' => $isShortMessage), array('id' => $userId));
        parent::formatSuccessData(1);
    }
}