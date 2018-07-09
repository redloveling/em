<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/11/27
 * Time: 16:52
 */
namespace Home\Widget;
use Home\Model\BannerModel;
use Think\Controller;

class FileUploadWidget extends Controller {
    /**
     * 上传banner
     * @author Red
     * @date 2016年11月23日17:09:10
     * @param $fileKey
     */
    public function bannerUpload($fileKey){
        $bannerModel = new BannerModel();
        $banner = $bannerModel->getOne(array('status'=>1,'name'=>$fileKey));
        $this->assign('params',array('file_key'=>$fileKey));
        $this->assign('banner',$banner);
        $this->display('Widget:fileUpload/bannerUpload');
    }
}