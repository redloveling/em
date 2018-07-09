<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/11/21
 * Time: 15:28
 */
namespace Home\Model;
class MessageTemplateModel extends CommonModel
{
    /**
     * 任务模板参数转换
     * @author Red
     * @date 2016年12月6日16:13:36
     * @param $messageContent
     * @param int $realTypeId
     * @param int $payTypeId
     * @param int $taskId
     * @param string $msg
     * @return string
     */
    public function transformMessageParams($messageContent, $realTypeId = 0, $payTypeId = 0, $taskId = 0,$msg='')
    {
        if ($taskId) {
            $taskModel = new TaskModel();
            $taskInfo  = $taskModel->getById($taskId);
        }
        //$message_params = C('message_params');//这个配置文件读取始终有问题呀
        $message_params = array(
        '{$realType}'=>'实名认证拒绝类型',
        '{$payType}'=>'支付认证拒绝类型',
        '{$taskName}'=>'任务标题',
        '{$msg}'=>'原因',
         );
        foreach ($message_params as $key => $value) {
            switch ($key) {
                case '{$realType}':
                    $realRefuseModel = M('tb_realaudit_refuse_type');
                    $realRefuseInfo  = $realRefuseModel->where(array('id'=>$realTypeId))->field('name')->find();
                    $realType        = $realRefuseInfo['name'];
                    $messageContent = str_replace('{$realType}', $realType, $messageContent);
                    break;
                case '{$payType}':
                    $payRefuseModel = M('tb_payaudit_refuse_type');
                    $payRefuseInfo  = $payRefuseModel->where(array('id'=>$payTypeId))->field('name')->find();
                    $payType        = $payRefuseInfo['name'];
                    $messageContent = str_replace('{$payType}', $payType, $messageContent);
                    break;
                case '{$taskName}':
                    $taskName        = $taskInfo['title'];
                    $messageContent = str_replace('{$taskName}', $taskName, $messageContent);
                    break;
                case '{$msg}':
                    $messageContent = str_replace('{$msg}', $msg, $messageContent);
                    break;
                default:
                    $messageContent = $messageContent;
            }
        }
        return trim($messageContent);
    }

}