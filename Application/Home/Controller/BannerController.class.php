<?php
namespace Home\Controller;

use Home\Model\BannerModel;

/**
 * Banner控制器
 * Class MessageController
 * @package Home\Controller
 */
class BannerController extends BaseController
{
    /**
     * banner列表
     * @author Red
     * @date 2016年11月23日17:09:30
     */
    public function index()
    {
        $bannerModel = new BannerModel();
        if (IS_POST) {
            $bannerCount = I('bannerMaxId', 0, 'int');
            $bannerImage = array();
            for ($i = 1; $i <= $bannerCount; $i++) {
                array_push($bannerImage, 'bannerImage' . $i);
            }
            trans_start();
            $res = addFile($bannerImage, 1);
            if ($res === false) {
                trans_back(L('OPERATE_FAIL'));
            }
            //保存到banner表中 没有则不插入
            if ($res && $bannerModel->insertBannerByAttId($res) === false) {
                trans_back(L('OPERATE_FAIL'));
            }
            //保存类型和详情到banner表
            foreach ($bannerImage as $value) {
                $num = ltrim($value, 'bannerImage');
                if ($_POST['type_' . $num] && $banner = $bannerModel->getOne(array('name' => $value), 'id')) {
                    $data['type']        = $_POST['type_' . $num];
                    //地址格式$_SERVER['HTTP_HOST'].'/index.php/Task/detail/id/30'
                    $data['description'] = $_POST['description_' . $num];
                    $bannerModel->update($data, array('id' => $banner['id']));
                }
            }
            trans_commit(L('OPERATE_SUCCESS'));

        }
        $bannerList = $bannerModel->getAll('status=1');
        $maxId      = $bannerModel->getAll(array(), 'id,name', 'id desc');
        $this->assign('maxId', $maxId[0]['id'] ? ltrim($maxId[0]['name'], 'bannerImage') : 1);
        $this->assign('bannerList', $bannerList ? $bannerList : array(array()));
        $this->display();
    }

    /**
     * 删除数据
     * @author Red
     * @date 2016年10月25日16:51:02
     */
    public function deleteBanner()
    {
        $id = I('id');
        if (is_numeric($id) == false) {
            exit(returnStatus(0, L('CHOOSE_DADA')));
        }
        $bannerModel = new BannerModel();
        $map['id']   = $id;
        $res         = $bannerModel->update(array('status' => 0), $map);

        if ($res === false) {
            exit(returnStatus(0, L('OPERATE_FAIL')));
        }
        exit(returnStatus(1, L('OPERATE_SUCCESS')));


    }
}