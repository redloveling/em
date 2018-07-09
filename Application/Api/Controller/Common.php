<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/12/7
 * Time: 10:27
 */


use Extend\SendShortMessage;

class Common extends \Api\Controller\BaseApiController
{
    /**
     * 发送短信验证码
     * @author Red
     * @date 2016年12月7日14:34:45
     */
    public function sendShortMessageCode()
    {
        $phoneNum = I('phone_number', 0, 'trim');
        $keyWord  = parent::checkData('key_word', '缺少关键字');

        if ($phoneNum && $keyWord) {
            $code           = rand(1000, 9999);
            $expirationTime = C('CODE_EXPIRATION_TIME');
            $userModel = new \Home\Model\UserModel();
            //如果是注册判断是否已经有该手机了
            if($keyWord=='register'){
                if($userModel->getOne(array('username'=>$phoneNum))){
                    parent::formatErrData('用户已存在');
                }
            }
            //找回密码
            if($keyWord=='reset'){
                if(!$userModel->getOne(array('username'=>$phoneNum))){
                    parent::formatErrData('该用户未注册');
                }
            }
            $shortMessage   = new SendShortMessage();
            $res            = $shortMessage->alisend($phoneNum, 'SMS_33985005', array('code' => strval($code), 'minute' => $expirationTime));
            if ($res === true) {
                //把验证码和手机保存到缓存中
                S('verifyCode_' . $phoneNum, $code, $expirationTime * 60 * 6 + 10);
                parent::formatSuccessData($code, '发送成功');
            };
            parent::formatErrData('发送失败' . $res);
        }
        parent::formatErrData('缺少手机号码', 2);
    }

    /**
     * 验证短信验证码
     * @author Red
     * @date 2016年12月7日14:40:04
     */
    public function getShortMessageCode()
    {
        $phoneNum = I('phone_number', 0, 'trim');
        $code     = I('verify_code', 0, 'trim');
        if ($phoneNum && $code) {
            if (S('verifyCode_' . $phoneNum) == $code) {
                S('verifyCode_' . $phoneNum, null);
                parent::formatSuccessData(1, '验证成功');
            }
            parent::formatErrData('验证失败');
        }
        parent::formatErrData('缺少手机号码或验证码', 2);
    }

    /**
     * 学历列表
     * @author Red
     * @date 2016年12月19日13:55:48
     * @return mixed
     */
    public function getEducationList()
    {
        $table = M('tb_education');//get_config_table_list('tb_education')
        $list  = $table->where(array('status' => 1,'id'=>array('neq','3')))->select();
        parent::formatSuccessData($list);
    }

    /**
     * 银行卡列表
     * @author Red
     * @date 2016年12月19日15:00:58
     */
    public function getBankList()
    {
        $table = M('tb_bank');//get_config_table_list('tb_bank')
        $list  = $table->where(array('status' => 1))->select();
        parent::formatSuccessData($list);
    }

    /**
     * 题库列表
     * @author Red
     * @date 2016年12月19日15:59:54
     */
    public function getQuestionList()
    {
        $questionModel = new \Home\Model\QuestionModel();
        $list          = $questionModel->getAll(array('status' => 1), 'id,title,type,content');
        foreach ($list as $key => $value) {
            $content                    = unserialize($value['content']);
            $list[$key]['content_name'] = implode(',', $content);
        }
        parent::formatSuccessData($list);
    }

    /**
     * 阅读消息
     * @author Red
     * @date
     */
    public function readMessage()
    {
        $messageId    = parent::checkData('message_id', '缺少消息id');
        $messageModel = new \Home\Model\MessageModel();
        $messageModel->update(array('status' => 1), array('id' => array('in', $messageId)));
        parent::formatSuccessData(1);
    }

    /**
     * 获取banner
     * @author Red
     * @date 2016年12月30日11:30:05
     */
    public function getBannerList()
    {
        $bannerModel = new \Home\Model\BannerModel();
        $list        = $bannerModel->getAll(array('status' => 1), 'id,name,type,image,description');
        foreach ($list as $key=>$value){
            //地址格式$_SERVER['HTTP_HOST'].'/index.php/Task/detail/id/30'  转换成 taskId=30
            $value['type']==1 && $list[$key]['description'] = substr($value['description'],strrpos($value['description'],'/')+1);
        }
        parent::formatSuccessData($list);
    }

    /**
     * 版本更新
     * @author Red
     * @date 2017年1月24日15:12:59
     */
    public function getNewVersion()
    {
        $versionCode     = parent::checkData('version_code', '缺少版本号');
        $deviceType      = parent::checkData('device_type', '缺少参数');
        $model           = M('tb_version');
        $where['val']    = $deviceType;
        $where['status'] = 1;
        $versionInfo     = $model->where($where)->order('create_time desc')->find();
        if ($versionInfo['code'] != $versionCode) {
            parent::formatSuccessData($versionInfo['path'], '下载最新版本');
        } else {
            parent::formatSuccessData(null);
        }
    }
}