<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/12
 * Time: 13:56
 */

/**
 * 文件上传 主要用于异步上传
 * lyj
 * 2016年8月12日14:57:55
 * @param string $rootPath 文件上传主目录
 * @param string $savePath 文件上传子目录
 * @param int $maxSize 文件最大字节
 * @param array $exts 上传类型数组 如：array('xls', 'xlsx', 'jpg', 'jpeg', 'png', 'gif', 'doc', 'docx', 'rar')
 * return json
 */
function uploadFile($rootPath = './Uploads/', $savePath, $maxSize = 3145728, $exts = array())
{
    $upload           = new \Think\Upload();// 实例化上传类
    $upload->maxSize  = $maxSize;// 设置附件上传大小
    $upload->exts     = $exts;// 设置附件上传类型
    $upload->rootPath = $rootPath; // 设置附件上传根目录
    $upload->savePath = $savePath; // 设置附件上传（子）目录
    // 上传文件
    $info = $upload->upload();

    if (!$info) {
        $this->error($upload->getError());
        returnJson(0, $upload->getError(), null);
    } else {
        returnJson(1, '上传成功', $info);
    }
}

/**
 * 返回json数据
 * lyj
 * 2016年8月12日15:21:14
 * @param int $status 状态码
 * @param string $msg 提示信息
 * @param array $data 数据
 * @return string
 */
function returnJson($status, $msg, $data)
{
    return json_encode(array(
            'code' => $status,
            'msg'  => $msg,
            'data' => $data
        )
    );
}

/**
 * 生成密码种子
 * 2016年9月12日12:02:26
 * @param  integer
 * @return string
 */
function getSalt($length = 4)
{
    $salt = '';

    for ($i = 0; $i < $length; $i++) {
        $salt .= chr(rand(97, 122));
    }

    return $salt;
}

/**
 * 编译混淆密码
 * 2016年9月12日11:06:17
 * @param $password
 * @param $salt
 * @return string
 */
function compilePassword($password, $salt)
{
    return md5(md5($password) . $salt);
}

function get_api_data($url = '', $param = array())
{
    $result = '';
    foreach ($param as $k => $value) {
        $result .= $k . '=' . $value . '&';
    }

    //$str = 'function=upload&device_type=android&user_name=admin&password=admin' . $result;
    $str = 'device_type=ios&function=getBannerList&user_id=5';
    //$str = '你在干咔哒你在干什么你么你在干什么你什';
    $hex = '';
    for ($i = 0, $length = mb_strlen($str); $i < $length; $i++) {
        $hex .= dechex(ord($str{$i}));
    }
    //print_r($hex);
//    var_dump(strlen($hex));
    //$publicFile = './Application/Api/Controller/publicKey.pem';//公钥路径
    $publicFile = './Application/Api/key/rsa_public_key.pem';//公钥路径
    include_once './Application/Extend/Rsa.class.php';
    $rsa  = new \Extend\Rsa($publicFile);
    $code = $rsa->encrypt($hex);
    $code = str_replace('/', '*', $code);
    $url  = 'http://127.0.0.1:8081/index.php/Api/OpenApi/index/';
    $url .= 'code/' . $code;
    print_r(str_replace('+', '_', $url));
    exit;
    $result = curl_get_contents(str_replace('+', '_', $url));//把+替换成_
    var_dump($result);
    die;
    $res = json_decode($result);

    if ($res->status == 0) {
        return $res->msg;
    } else {
        return object_to_array($res->data);
    }
}

function get_api_datas($url = '', $param = array())
{
    $result = '';
    foreach ($param as $k => $value) {
        $result .= $k . '=' . $value . '&';
    }
    //$publicFile = './Application/Api/Controller/publicKey.pem';//公钥路径
    $publicFile = './Application/Api/key/rsa_public_key.pem';//公钥路径
    include_once './Application/Extend/Rsa.class.php';
    $rsa = new \Extend\Rsa($publicFile);

    $codes = '';
    for ($i = 0; $i <= strlen($result); $i += 117) {

        $code = $rsa->encrypt(substr($result, $i, 117));
        $code = str_replace('/', '*', $code);
        $code = str_replace('+', '_', $code);
        $codes .= $code . ',';
    }
    $post['code'] = $codes;
    $result       = curl_get_contents($url, 10, $post);
    $res          = json_decode($result);
    if ($res->code != 00001) {
        return $res->msg;
    } else {
        return object_to_array($res->data);
    }
}

/**
 * CURL 获取文件内容
 * @author Red
 * @date
 * @param $url
 * @param int $timeout
 * @return mixed
 * @throws Zend_Exception
 */
function curl_get_contents($url, $timeout = 10, $data = array())
{
    if (!function_exists('curl_init')) {
        throw new Zend_Exception('CURL not support');
    }

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    $data && curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    if (defined('WECENTER_CURL_USERAGENT')) {
        curl_setopt($curl, CURLOPT_USERAGENT, WECENTER_CURL_USERAGENT);
    } else {
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/600.7.12 (KHTML, like Gecko) Version/8.0.7 Safari/600.7.12');
    }

    if (substr($url, 0, 8) == 'https://') {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
    }

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

/**
 * 对象转换成数组
 * @author Red
 * @date 2016年1月15日15:32:07
 * @param $obj
 * @return mixed
 */
function object_to_array($obj)
{
    $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
    foreach ($_arr as $key => $val) {
        $val       = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
        $arr[$key] = $val;
    }

    return $arr;
}

/*
 * 发送邮件
 * @param $to string
 * @param $title string
 * @param $content string
 * @return bool
 * */
function sendMails($to, $title, $content)
{
    include './Vendor/PHPMailer/Mail.class.php';

    $mail = new PHPMailer(); //实例化
    //var_dump($mail);die;
    $mail->IsSMTP(); // 启用SMTP
    $mail->Host       = C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->SMTPAuth   = C('MAIL_SMTPAUTH'); //启用smtp认证
    $mail->Username   = C('MAIL_USERNAME'); //发件人邮箱名
    $mail->Password   = C('MAIL_PASSWORD'); //163邮箱发件人授权密码
    $mail->From       = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
    $mail->FromName   = C('MAIL_FROMNAME'); //发件人姓名
    $mail->AddAddress($to, "尊敬的客户");
    $mail->WordWrap = 500; //设置每行字符长度
    $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
    $mail->CharSet = C('MAIL_CHARSET'); //设置邮件编码
    $mail->Subject = $title; //邮件主题
    $mail->Body    = $content; //邮件内容
    $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
    return ($mail->Send());
}

/**
 *  保存日志
 * @author Red
 * @date  2016年8月10日14:12:29
 * @param string $logMsg 日志信息
 * @param string $logFileName 日志文件名
 * @param string $level 错误等级
 */
function saveLog($logMsg, $logFileName = 'operatorLog', $level = '00001')
{
    $dir = RUNTIME_PATH . 'Logs/' . $logFileName . '/' . date('Ymd');

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    Think\Log::write(getLogPrefix() . $logMsg . ' || URL=' . __SELF__, $level, "", $dir . '/' . $logFileName . '.txt');
}

function getLogPrefix()
{
    $userInfo = get_user_info();

    return date('Y-m-d H:i', time()) . ' 用户 ' . $userInfo['name'] . '[' . $userInfo['id'] . '] ';
}

/**
 * 检查用户是否登陆标示
 * @author Red
 * @date 2016年10月14日15:40:39
 * @return int
 */
function get_access_user()
{
    return (int)session(C('USER_AUTH_KEY'));
}

/**
 * 获取当前登陆的用户id
 * @author Red
 * @date 2016年10月14日15:43:31
 * @return int
 */
function get_user_id()
{
    return (int)session('uid');
}

/**
 * 获取当前登陆的用户信息
 * @author Red
 * @date 2016年10月14日15:43:31
 * @return int
 */
function get_user_info()
{
    return session('user_info');
}

/**
 * 用户密码验证
 * 2016年9月12日11:03:40
 * @param $password
 * @param $db_password
 * @param string $salt 混淆码
 * @return bool
 */
function checkPassword($password, $db_password, $salt)
{
    $password = compilePassword($password, $salt);

    return $password == $db_password ? true : false;
}

/**
 * 百度云推送Android APP消息
 * lyj
 * 2016年9月12日16:01:14
 * @param string $title 通知标题，可以为空；如果为空则设为appid对应的应用名;
 * @param string $description 通知文本内容，不能为空;
 * @param array $custom_content custom_content：自定义内容，键值对，Json对象形式(可选)；在android客户端，这些键值对将以Intent中的extra进行传递。
 * @param int $msg_type 设置消息类型，0：透传消息 1：通知
 * @param int $channel_id android设备唯一id号
 */
function baidu_push($title, $description, $custom_content = array(), $msg_type = 0, $channel_id = null)
{
    require_once './Vendor/Baidu-Push-Server-SDK-Php-3.0.1/sdk.php';

    // 创建SDK对象.
    $sdk = new PushSDK();

    //$channelId      = '3606216536771322823';

    if (!trim($description)) {
        $this->formatErrData('消息内容不能为空');
    }

    // 消息内容.
    $message = array(
        'title'          => $title,
        'description'    => $description,
        'custom_content' => $custom_content
    );

    // 设置消息类型  0：透传消息 1：通知
    $opts = array(
        'msg_type' => $msg_type
    );

    if ($channel_id) {
        // 向目标设备发送一条消息
        $rs = $sdk->pushMsgToSingleDevice($channel_id, $message, $opts);
    } else {
        // 向所有设备发送一条消息
        $rs = $sdk->pushMsgToAll($message, $opts);
    }

    $baseApi = A('Api/BaseApi'); // 跨模块实例化baseApi

    // 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
    if ($rs === false) {
        $baseApi->formatErrData('推送失败', $this->codeArr[2]);
    } else {
        $baseApi->formatSuccessData($rs, '推送成功');
    }
}

/**
 * 检查post字段
 * @author Red
 * @date  2016年1月18日17:23:25
 * @param string $content
 * @param string $msg
 * @param string $msgtype
 * @return mixed
 *
 *  eg:check_post('name', '节点名称');
 */
function check_post($content = '', $msg = '', $msgtype = '', $default = '', $filter = null)
{

    $value = I($content, $default, $filter);
    if ((!isset($_POST[$content]) || $value === '' || $value === false) || ($default === 0 && $value === 0)) {
        switch ($msgtype) {
            case 1:
                echo '请填写' . $msg;
                break;
            case 2:
                echo '请选择' . $msg;
                break;
            case 3:
                echo $msg;
                break;
            default:
                echo $msg . '不能为空';
        }
        exit;
    }
    $return = I($content, $default, $filter);;

    return $return;
}

/**
 * 返回操作结果
 * Author  Zzer
 * @param $status 操作状态(0:失败,1:成功)
 * @param $msg 返回提示
 * Date   2016年09月08日 14:46
 */
function returnStatus($status, $msg, $data = null, $isJson = true)
{
    if ($isJson == true) {
        return json_encode(array(
            'status' => $status,
            'msg'    => $msg,
            'data'   => $data
        ));
    } else {
        return array(
            'status' => $status,
            'msg'    => $msg,
            'data'   => $data
        );
    }

}


/**
 * excel导出（支持多个sheet）和图片
 * @author Red
 * @date 2016年11月15日10:37:57
 * @param $list
 * @param $excelFieldsZHCN
 * @param $excelFileName
 * @param $sheetTitle
 */
function exportExcels($list, $excelFieldsZHCN, $excelFileName, $sheetTitle)
{
    $excelFileName = iconv('UTF-8', 'GBK', $excelFileName);

    $excelFileName = $excelFileName . date('YmdHi', time());
    include APP_PATH . '/Vendor/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("Red")->setLastModifiedBy("")->setTitle('I\'m superredman')->setDescription("create by red");
    //构造excel 列名
    $index = 0;
    $ret   = array();
    foreach ($excelFieldsZHCN as $key => $value) {
        $objPHPExcel->createSheet();
        $i = 0;
        foreach ($value as $fieldName => $ZHCN) {
            $pCoordinate = \PHPExcel_Cell::stringFromColumnIndex($i);
            $objPHPExcel->setActiveSheetIndex($index)->setCellValue($pCoordinate . '1', $value[$fieldName]);
            $ret[$i] = $fieldName;
            $i++;
        }
        $row = 2;//EXCEL 行索引 从第二行自增
        if ($list[$key]) {
            foreach ($list[$key] as $item) {
                $i = 0;
                foreach ($ret as $field) {

                    $pCoordinate = \PHPExcel_Cell::stringFromColumnIndex($i);
                    if (is_array($item[$field]) && $item[$field]['img']) {
                        /*实例化插入图片类*/
                        $objDrawing = new PHPExcel_Worksheet_Drawing();
                        /*设置图片路径 切记：只能是本地图片*/
                        $objDrawing->setPath($item[$field]['path']);
                        /*设置图片高度*/
                        $objDrawing->setHeight($item[$field]['height']);
                        $objDrawing->setWidth($item[$field]['width']);
                        //图片位置
                        $objDrawing->setOffsetX(5);
                        $objDrawing->setOffsetY(5);
                        /*设置图片要插入的单元格*/
                        $objDrawing->setCoordinates($pCoordinate . $row);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                        //设置行高和行宽
                        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight($item[$field]['width']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex($index)->setCellValue($pCoordinate . $row, ' ' . strip_tags($item[$field]));//过滤html标签
                    }

                    $i++;
                }
                $row++;
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle($sheetTitle[$key]);
        $objPHPExcel->setActiveSheetIndex($index);
        $index++;
    }


    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $excelFileName . '.xls"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');
    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;

}

/**
 * 格式化时间戳
 * @author Red
 * @date 2016年11月15日11:26:27
 * @param $timestamp
 * @return bool|string
 */
function format_time($timestamp)
{
    return $timestamp ? date('Y-m-d H:i', $timestamp) : '';
}

/**
 * 转换性别
 * @author Red
 * @date 2016年11月15日11:39:02
 * @param int $sex
 * @return string
 */
function sex_trans($sex = 1)
{
    return $sex == 1 ? '男' : '女';
}

/**
 * 开启事务
 * @author Red
 * @date 2016年11月22日16:15:46
 */
function trans_start()
{
    $model = new \Home\Model\UserModel();
    $model->startTrans();
}

/**
 * 回滚事务
 * @author Red
 * @date 2016年11月22日16:15:46
 */
function trans_back($msg = '操作失败')
{
    $model = new \Home\Model\UserModel();
    $model->rollback();
    exit(returnStatus(0, $msg));
}

/**
 * 提交事务
 * @author Red
 * @date 2016年11月22日16:15:46
 */
function trans_commit($msg = '操作成功')
{
    $model = new \Home\Model\UserModel();
    $model->commit();
    exit(returnStatus(1, $msg));
}

/**
 * 生成6位推广码
 * @author Red
 * @date 2016年12月8日11:51:31
 * @param $pre
 * @param $num
 * @return string
 */
function generate_extension_code($num, $pre = 'y')
{
    $randNum = mt_rand(0, 1000);
    $randStr = chr(rand(97, 122));

    return $pre . $randStr . str_pad($num, 4, $randNum, STR_PAD_LEFT);
}

/**
 * 生成二维码并保存 返回文件保存路劲
 * @author Red
 * @date 2016年12月12日17:09:01
 * @param $info
 * @param $fileName
 * @return string
 */
function generate_qr_code($info, $fileName)
{
    include APP_PATH . '/Vendor/phpqrcode.php';
    $qr        = new \QRcode();
    $file_path = __ROOT__ . 'Uploads/qr/' . date('Ymd', time()) . '/';
    //创建文件
    if (!is_dir($file_path)) {
        mkdir(iconv("UTF-8", "GBK", $file_path), 0777, true);
    }
    $qr::png($info, $file_path . $fileName . '.png', '', 10.4);

    return '/' . $file_path . $fileName . '.png';

}

/**
 * 下载文件
 * @author Red
 * @date 2016年12月12日17:08:56
 * @param $file
 */
function download_file($file)
{
    $file = str_replace('\\', '/', realpath(dirname(dirname(dirname((dirname(__FILE__)))) . '/'))) . $file;
    if (is_file($file)) {
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=" . basename($file));
        readfile($file);
        exit;
    } else {
        echo "文件不存在！";
        echo '<span><a href="javascript:history.go(-1);">◂返回上一步</a></span>';
        exit;
    }
}

/**
 * 计算天数之差
 * @author Red
 * @date 2016年12月23日11:23:33
 * @param $a
 * @param $b
 * @return float
 */
function count_days($a, $b)
{
    return round(abs($a - $b) / 86400);
}

/**
 * 16进制转字符串
 * @author Red
 * @date 2016年12月23日11:24:41
 * @param $hex
 * @return string
 */
function hex2str($hex)
{
    $str = '';
    $arr = str_split($hex, 2);
    foreach ($arr as $bit) {
        $str .= chr(hexdec($bit));
    }

    return $str;
}

/**
 * 字符串转16进制
 * @author Red
 * @date 2016年12月23日11:24:41
 * @param $str
 * @return string
 */
function str2hex($str)
{
    $hex = '';
    for ($i = 0, $length = mb_strlen($str); $i < $length; $i++) {
        $hex .= dechex(ord($str{$i}));
    }

    return $hex;
}

/**
 * 缓存配置表
 * @author Red
 * @date 2016年11月21日14:59:32
 * @param $tableName
 * @return mixed
 */
function get_config_table_list($tableName)
{
    $model = M($tableName);
//    if (F($tableName)) {
//        return F($tableName);
//    }
    $list = $model->where('status=1')->select();
    foreach ($list as $value) {
        $lists[$value['id']] = $value;
    }
    //缓存到文件中
    F($tableName, $lists);

    return $lists;
}

/**
 * 插入用户任务日志
 * @author Red
 * @date  2017年3月2日10:33:07
 * @param $userId
 * @param $taskId
 * @param $msg
 * @param int $operatorId
 */
function insert_user_task_log($userId, $taskId, $msg, $operatorId = 0)
{
    $userTaskLogModel = new  \Home\Model\UserTaskLogModel();
    $userTaskLogModel->insertLog($userId, $taskId, $msg, $operatorId);
}

/**
 * 插入用户日志
 * @author Red
 * @date 2017年3月2日10:37:10
 * @param $userId
 * @param $msg
 * @param int $operatorId
 */
function insert_user_log($userId, $msg, $operatorId = 0)
{
    $userLogModel = new  \Home\Model\UserLogModel();
    $userLogModel->insertLog($userId, $msg, $operatorId);
}

/**
 * 插入任务日志
 * @author Red
 * @date 2017年3月2日10:37:10
 * @param $taskId
 * @param $msg
 */
function insert_task_log($taskId, $msg)
{
    $taskLogModel = new  \Home\Model\TaskLogModel();
    $taskLogModel->insertLog($taskId, $msg);
}

function getBrowserVersion()
{
    return getBrowser() . getBrowserVer();
}

function getBrowser()
{
    $agent = $_SERVER["HTTP_USER_AGENT"];
    if (strpos($agent, 'MSIE') !== false || strpos($agent, 'rv:11.0')) //ie11判断
        return "ie";
    else if (strpos($agent, 'Firefox') !== false)
        return "firefox";
    else if (strpos($agent, 'Chrome') !== false)
        return "chrome";
    else if (strpos($agent, 'Opera') !== false)
        return 'opera';
    else if ((strpos($agent, 'Chrome') == false) && strpos($agent, 'Safari') !== false)
        return 'safari';
    else
        return 'unknown';
}

function getBrowserVer()
{
    if (empty($_SERVER['HTTP_USER_AGENT'])) {    //当浏览器没有发送访问者的信息的时候
        return 'unknow';
    }
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs))
        return $regs[1];
    elseif (preg_match('/FireFox\/(\d+)\..*/i', $agent, $regs))
        return $regs[1];
    elseif (preg_match('/Opera[\s|\/](\d+)\..*/i', $agent, $regs))
        return $regs[1];
    elseif (preg_match('/Chrome\/(\d+)\..*/i', $agent, $regs))
        return $regs[1];
    elseif ((strpos($agent, 'Chrome') == false) && preg_match('/Safari\/(\d+)\..*$/i', $agent, $regs))
        return $regs[1];
    else
        return 'unknow';
}
function getIp() {
    $ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return isIp($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : $ip;
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return isIp($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $ip;
    } else {
        return isIp($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $ip;
    }
}

function isIp($str) {
    $ip = explode('.', $str);
    for ($i = 0; $i < count($ip); $i++) {
        if ($ip[$i] > 255) {
            return false;
        }
    }

    return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $str);
}
