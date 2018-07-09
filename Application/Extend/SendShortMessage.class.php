<?php

/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/12/7
 * Time: 11:04
 */
namespace Extend;
class SendShortMessage
{

    /**
     * (云通讯)发送短信
     * @author Red
     * @date 2016年12月7日13:53:36
     * @param $to
     * @param $datas
     * @param $tempId
     * @return bool
     */
    public function ytxSend($to, $datas, $tempId)
    {

        //主帐号,对应开官网发者主账号下的 ACCOUNT SID
        $accountSid = C('ACCOUNT_SID');

        //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
        $accountToken = C('AUTH_TOKEN');

        //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
        //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
        $appId = C('APP_ID');

        //请求地址
        //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
        //生产环境（用户应用上线使用）：app.cloopen.com
        $serverIP = C('SERVER_IP');


        //请求端口，生产环境和沙盒环境一致
        $serverPort = '8883';

        //REST版本号，在官网文档REST介绍中获得。
        $softVersion = '2013-12-26';
        include_once("./Application/Vendor/ShortMessage/CCPRestSmsSDK.php");
        $rest = new \REST($serverIP, $serverPort, $softVersion);
        $rest->setAccount($accountSid, $accountToken);
        $rest->setAppId($appId);

        // 发送模板短信
        $result = $rest->sendTemplateSMS($to, $datas, $tempId);
        if ($result == NULL) {
            return false;
        }
        if ($result->statusCode != 0) {
            saveLog("error code :" . $result->statusCode . "<br>" . "error msg :" . $result->statusMsg . "<br>", 'shortMessageError');

            return $result->statusMsg;

        } else {
            $smsmessage = $result->TemplateSMS;
            saveLog("dateCreated:" . $smsmessage->dateCreated . "<br/>" . "smsMessageSid:" . $smsmessage->smsMessageSid . "<br/>", 'shortMessageSuccess');

            return true;

        }
    }

    /**
     * 阿里发送短信
     * @author Red
     * @date 2016年12月12日10:33:25
     * @param $phoneNum
     * @param $params
     * @param $tempCode
     * @return bool
     */
    public function aliSend($phoneNum, $tempCode, $params=array())
    {
        include_once("./Application/Vendor/ShortMessage/ShortMessage.php");
        $shortMessage = new \ShortMessage();
//        $param        = self::shortMessageParams($tempCode, $params);
        return $shortMessage->send($tempCode, $phoneNum, $params?json_encode($params):'');
    }

    /**
     * 参数转换
     * @author Red
     * @date 2016年12月12日10:33:41
     * @param $tempCode
     * @param $params
     * @return string
     */
    private function shortMessageParams($tempCode, $params)
    {
        switch ($tempCode) {
            //注册验证
            case '1':
                $res['params']   = array('code' => $params[0], 'minute' => $params[1]);
                $res['tempCode'] = 'SMS_33985005';
                break;
            //黑名单
            case '2':
                $res['params']   = array('error' => '奇葩不传参数居然不行');
                $res['tempCode'] = 'SMS_34000312';
                break;
            //实名认证失败
            case '3':
                $res['params']   = array('type' => $params[0]);
                $res['tempCode'] = 'SMS_34000312';
                break;
            //支付认证失败
            case '4':
                $res['params']   = array('type' => $params[0]);
                $res['tempCode'] = 'SMS_34000312';
                break;
            //报名通过
            case '5':
                $res['params']   = array('task' => $params[0]);
                $res['tempCode'] = 'SMS_34000312';
                break;
            //报名不通过
            case '6':
                $res['params']   = array('task' => $params[0]);
                $res['tempCode'] = 'SMS_34000312';
                break;
            //任务开始
            case '7':
                $res['params']   = array('task' => $params[0]);
                $res['tempCode'] = 'SMS_33480396';
                break;
            //任务结束
            case '8':
                $res['params']   = array('task' => $params[0]);
                $res['tempCode'] = 'SMS_33985005';
                break;
            default:
                $res = array();
        }

        return $res;
    }
}