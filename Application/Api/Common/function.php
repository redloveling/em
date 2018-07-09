<?php

/**
 * 接口上传附件
 * @author Red
 * @date 2016年12月19日11:48:18
 * @param string $fileName
 * @param $savePath
 * @param $userId
 * @return array
 */
function api_file_upload($fileName, $savePath = '/app/', $userId)
{
    if ($_FILES[$fileName]) {
        $upload           = new \Think\Upload();// 实例化上传类
        $upload->maxSize  = 3145728;// 设置附件上传大小
        $upload->exts     = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = './Uploads'; // 设置附件上传根目录
        $upload->savePath = $savePath; // 设置附件上传（子）目录
        // 上传文件
        $info = $upload->upload($fileName);

        if (!$info) {// 上传错误提示错误信息
            formatErrData($upload->getError());
        }

        $filePath = '';
        $attIds   = '';
        foreach ($info as $file) {
            $filePath .= date('Y-m-d') . '/' . $file['savename'] . ',';
            //附件添加到attachment表中
            $data['file_name']     = $file['name'];
            $data['file_key']      = $fileName;
            $data['type']          = 2;
            $data['file_location'] = $filePath;
            $data['file_type']     = $file['type'];
            $data['file_size']     = $file['size'];
            $data['add_time']      = time();
            $data['create_uid']    = $userId;
            $attachmentModel       = new \Home\Model\AttachmentModel();
            $attId                 = $attachmentModel->insert($data);
            $attIds .= $attId . ',';
        }

        return array('filePath' => rtrim($filePath, ','), 'attIds' => rtrim($attIds, ','));
    }
    formatErrData('请上传文件');
}

/**
 * 格式化返回消息
 * @author Red
 * @date 2016年12月19日11:48:40
 * @param string $msg
 * @param int $code
 * @param array $data
 * @return mixed
 */
function formatErrData($msg = '请求失败', $code = 00002, $data = array())
{
    return json_encode(array('msg' => $msg,'code' => is_string($code)?$code:$this->codeArr[$code] , 'data' => $data));
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
function api_insert_user_task_log($userId, $taskId, $msg, $operatorId = 0){
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
function api_insert_user_log($userId, $msg, $operatorId = 0){
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
function api_insert_task_log($taskId, $msg){
    $taskLogModel = new  \Home\Model\TaskLogModel();
    $taskLogModel->insertLog($taskId, $msg);
}
