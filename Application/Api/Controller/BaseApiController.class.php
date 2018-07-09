<?php
namespace Api\Controller;
use Think\Controller;

class BaseApiController extends Controller
{
    public $codeArr = array(
        1 => '00001',  //请求成功
        2 => '00002',  //请求失败
        3 => '00003',  //非法请求
    );
    public $pageSize = 10;
    /**
     *  请求失败
     * @author Red
     * @date
     * @param string $msg
     * @param int $code
     * @param array $data
     * @return array
     */
    public function formatErrData($msg = '请求失败',$code=2, $data = array())
    {
        return self::formatData( $msg, is_string($code)?$code:$this->codeArr[$code],$data);
    }

    /**
     * 请求成功
     * @author Red
     * @date
     * @param $data
     * @param string $msg
     * @return array
     */
    public function formatSuccessData($data, $msg = '请求成功')
    {
        return self::formatData($msg,'00001', $data);
    }
    /**
     * 格式化输出数据
     * @author Red
     * @date
     * @param $msg
     * @param $code
     * @param $data
     * @return array
     */
    protected function formatData( $msg,$code, $data)
    {
        echo json_encode(array('msg' => $msg,'code' => is_string($code)?$code:$this->codeArr[$code] , 'data' => $data));
        exit;
    }

    /**
     * 检查数据
     * @author Red
     * @date 2016年12月9日10:43:43
     * @param $content
     * @param string $msg
     * @param string $default
     * @param string $filter
     * @return mixed
     */
    public function checkData($content,$msg='必填项为空',$default='',$filter='trim'){
        $value = I($content, $default, $filter);
        if ((!isset($_POST[$content]) || $value === '' || $value==null ||$value === false) || ($default === 0 && $value === 0)) {
            echo json_encode(array('msg' => $msg,'code' => '00002', 'data' => array()));
            exit;
        }
        $return = I($content, $default, $filter);;

        return $return;
    }

    /**
     * 文件上传
     * @author Red
     * @date 2017年1月3日14:34:54
     * @param string $savePath
     * @param $userId
     * @return array
     */
    public function uploadFile($savePath = '/app/', $userId)
    {
        $upload           = new \Think\Upload();// 实例化上传类
        $upload->maxSize  = 314572800;// 设置附件上传大小
        $upload->exts     = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Uploads'; // 设置附件上传根目录
        $upload->savePath = $savePath; // 设置附件上传（子）目录
        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $this->formatErrData($upload->getError());
        }

        $fileArr = array();
        foreach ($info as $file) {
            $filePath = '/Uploads'.$file ['savepath'].$file ['savename'];
            //附件添加到attachment表中
            $fileName              = strstr($file['name'], '.', true);
            $data['file_name']     = $file['name'];
            $data['file_key']      = $fileName;
            $data['type']          = 2;
            $data['file_location'] = $filePath;
            $data['file_type']     = $file['type'];
            $data['file_size']     = $file['size'];
            $data['add_time']      = time();
            $data['create_uid']    = $userId;
            $data['user_id']       = $userId;
            $attachmentModel       = new \Home\Model\AttachmentModel();
            $attId                 = $attachmentModel->insert($data);
            $fileArr[$fileName]['filePath'] .= $filePath . ',';
            $fileArr[$fileName]['attIds'] .= $attId . ',';
        }

        return $fileArr;
    }

}