<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/12/27
 * Time: 10:52
 */
namespace Home\Widget;
use Home\Model\AttachmentModel;
use Think\Controller;

class SomeWidget extends Controller {
    /**
     *
     * @author Red
     * @date
     * @param $attIds
     */
    public function picture($attIds){
        $attachmentModel = new AttachmentModel();
        $list = $attachmentModel->getAll(array('id'=>array('in',$attIds)));
        $this->assign('list',$list);
        $this->display('Widget:some/picture');

    }
}