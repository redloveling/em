<?php
namespace Home\Controller;

use Extend\pay\BusinessPay;
use Extend\pay\UserPay;
use Extend\SendShortMessage;
use Home\Model\AdminUserModel;
use Think\Controller;

/**
 * 不需要验证的公用控制器
 * Class PublicController
 * @package Home\Controller
 */
class PublicController extends Controller
{

    public function _initialize()
    {
        $this->assign('web_icon', C('WEB_ICON'));
        $this->assign('web_title', C('WEB_TITLE'));
    }

    /**
     * 后台管理员登陆
     * @author Red
     * @date 2016年12月5日16:30:27
     */
    public function login()
    {
        if (IS_POST) {
            $users             = D('admin_user');
            $data              = $_POST;
            $where             = array();
            $where['username'] = $data['user_name'];
            $result            = $users->getOne($where);
            $data['password']  = compilePassword($data['password'], $result['salt']);
            if ($result && $result['password'] == $data['password']) {
                if ($result['status'] == 0)
                    $this->redirect('Public/login', array('error' => 2));
                // 存储session
                //检查用户是否超级管理员
                $userModel = new AdminUserModel();
                $result['isSuper'] = $userModel->checkIsSuper($result['id']);
                session(C('USER_AUTH_KEY'), $result['id']);
                session('uid', $result['id']);
                session('user_info', $result);
                //把用户信息加入数组中
                $this->uid = $result['id'];

                //bug系统提交用户登录信息
                $url = 'http://120.76.191.102:8085/index.php/Api/OpenApi';
                $data =array();
                $data['login_account'] = $result['username'];
                $data['appname'] =C('WEB_NAME');
                $data['browser'] = getBrowserVersion();
                $data['system'] = C('VERSION');
                $data['client_ip'] = getIp();
                $data['function'] = 'webUserLogin';
                $res =get_api_datas($url,$data);
                //把返回的record_id保存到session中
                session('bug_record_id_'.$result['id'], $res['record_id']);
                $this->redirect('Home/Index/index');

            } else {
                $this->redirect('Public/login', array('error' => 1));
            }
        }
        $this->display('public/login11');
    }

    /**
     * 退出登陆
     * @author Red
     * @date 2016年10月14日16:45:03
     */
    public function loginOut(){
        $userInfo = get_user_info();
        $url = 'http://120.76.191.102:8085/index.php/Api/OpenApi';
        $recordId = session('bug_record_id_'.$userInfo['id']);

        $recordId && $res = get_api_datas($url,array('record_id'=>$recordId,'function'=>'webLoginRecord'));
        //销毁session
        session('[destroy]');
        $this->redirect('Public/login');
    }
    public function shortMessageTest(){
//        $shortMessage = new SendShortMessage();
//        $shortMessage->aliSend("18111264139" ,array('6532','2'),"SMS_33985005");
//        $file_path = generate_qr_code('9857','ss');
//        print_r($file_path);
//        exit;
          include './Application/Home/Cron/WinCron.php';
    }
    public function test(){

        print_r(get_api_data());exit();

    }
    public function aliPayNotify(){
        $str='';
        foreach ($_POST as $key=>$value){
            $str .= $key.'=>'.$value.'\n';

        }
        saveLog($str);
        saveLog('out_trade_no=>'.$_POST['out_trade_no'].',trade_status=>'.$_POST['trade_status'],'pay');
    }

    /**
     * 错误上次bug系统
     * @author Red
     * @date 2017年4月25日11:55:36
     * @param $p
     */
    public function errorSend($p){
        $userInfo = get_user_info();
        $url = 'http://120.76.191.102:8085/index.php/Api/OpenApi';
        $data['description'] =$p['info'];
        $data['type'] = 1;
        $data['function'] = 'uploadWebbug';
        $data['loginaccount'] = $userInfo['username'];
        $data['appname'] = C('WEB_NAME');
        $data['browser'] = getBrowserVersion();
        $data['client_ip'] = getIp();;
        $data['system'] = C('VERSION');
        $res = get_api_datas($url,$data);
    }
}