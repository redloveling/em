<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/12/9
 * Time: 17:05
 */
use Sms\Request\V20160927 as Sms;

class ShortMessage
{
    /**
     * 阿里短信发送
     * @author Red
     * @date 2016年12月12日10:19:46
     * @param $tempCode
     * @param $phoneNum
     * @param $params
     * @return bool
     */
    public function send($tempCode,$phoneNum,$params)
    {
        include_once 'aliyun-php-sdk-core/Config.php';
        $iClientProfile = DefaultProfile::getProfile("cn-hangzhou", C('ACCESS_KEY'), C('ACCESS_SECRET'));
        $client         = new DefaultAcsClient($iClientProfile);
        $request        = new Sms\SingleSendSmsRequest();
        $request->setSignName(C('SING_NAME'));/*签名名称*/
        $request->setTemplateCode($tempCode);/*模板code*/
        $request->setRecNum($phoneNum);/*目标手机号*/
        $request->setParamString($params);/*模板变量，数字一定要转换为字符串*/
        try {
            $response = $client->getAcsResponse($request);
            saveLog("dateCreated:" . $response, 'shortMessageSuccess');

            return true;
        } catch (ClientException  $e) {
            saveLog("error code :" . $e->getErrorCode() . "<br>" . "error msg :" . $e->getErrorMessage() . "<br>", 'shortMessageError');

            return false;
        } catch (ServerException  $e) {
            saveLog("error code :" . $e->getErrorCode() . "<br>" . "error msg :" . $e->getErrorMessage() . "<br>", 'shortMessageError');

            return false;
        }
    }
}