<?php
namespace Api\Controller;

use Extend\Rsa;
use Home\Model\UserModel;

/**
 * Class openApi
 * 提供给外部的接口
 */
class OpenApiController extends BaseApiController
{
    private $device_type;
    private $publicFile = './Application/Api/key/rsa_public_key.pem';//公钥路径
   //private $privateFile = './Application/Api/key/pkcs8_rsa_private_key.pem';
    private $privateFile = './Application/Api/key/rsa_private_key.pem';


    public function index()
    {
        self::ssl();
        self::validate_necessary_params();
        self::load_class_function();
        exit;
    }

    /**
     * ssl验证
     * @author Red
     * @date
     */

    private function ssl()
    {
        $rsa    = new Rsa($this->publicFile, $this->privateFile);
        $code   = $_POST['code'] ? $_POST['code'] : $_REQUEST['code'];
        $result = '';
        foreach (explode(',', $code) as $value) {
            if (strlen($value) > 0) {
                $result .= $rsa->decrypt(str_replace('*', '/', str_ireplace('_', '+', $value)));
            }
        }
        //解密后的为16进制数据，转化为字符串
        $result = self::hex2str($result);
        !$result && parent::formatErrData('来自二次元？', $this->codeArr[3]);
        foreach (explode('&', $result) as $value) {
            $arr            = explode('=', $value);
            $_GET[$arr[0]]  = $arr[1];
            $_POST[$arr[0]] = $arr[1];
        }
    }
    /**
     * 16进制转字符串
     * @author Red
     * @date 2016年12月23日11:24:41
     * @param $hex
     * @return string
     */
    public function hex2str($hex){
        $str = '';
        $arr = str_split($hex, 2);
        foreach($arr as $bit){
            $str .= chr(hexdec($bit));
        }
        return $str;
    }
    /**
     * 必须参数验证
     * @author Red
     * @date
     */
    private function validate_necessary_params()
    {
        if (!$this->device_type = trim($_GET['device_type'])) {
            parent::formatErrData('缺少参数device_type', $this->codeArr[3]);
        }

        if (!in_array(strtolower($this->device_type), C('DEVICE_TYPE'))) {
            parent::formatErrData('设备类型不存在', $this->codeArr[3]);
        }

    }


    /**
     * 加载具体类
     * @author Red
     * @date
     */
    private function load_class_function()
    {
        $apiConfig = C('API');
        $act       = trim($_GET['function']);
        if ($apiConfig['config'][$act]) {
            include_once($apiConfig['config'][$act]['path']);
            $objName = $apiConfig['config'][$act]['objName'];
            //检查类是否存在
            if (!file_exists($apiConfig['config'][$act]['path'])) {
                parent::formatErrData('接口错误');
            }
            $obj = new $objName;
            if ($apiConfig['config'][$act]['function']) {
                $function = $apiConfig['config'][$act]['function'];
            } else {
                $function = $act;
            }

            //检查方法是否存在
            if (!method_exists($obj, $function)) {
                parent::formatErrData('接口错误');
            }
            //用户检查
            if ($apiConfig['config'][$act]['type'] == 2) {
                //检查用户是否登陆
                self::checkUserLogin();
            }
            saveLog('接口访问成功','apiSuccess');
            $obj->$function();
        } else {
            parent::formatErrData('接口未定义');
        }
    }

    /**
     * 检查登陆情况
     * @author Red
     * @date 2016年12月9日15:31:13
     */
    private function checkUserLogin()
    {
        $userId = parent::checkData('user_id', '缺少用户id');
        $userModel = new UserModel();
        if (!$userModel->getById($userId)) {
            parent::formatErrData('未知用户，请重新登陆');
        }
    }

}