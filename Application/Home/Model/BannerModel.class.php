<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/11/23
 * Time: 15:28
 */
namespace Home\Model;
class BannerModel extends CommonModel
{
    /**
     * 根据附件表的id插入banner
     * @author Red
     * @date 2016年11月23日16:13:56
     * @param $attIds
     * @return bool
     */
    public function insertBannerByAttId($attIds)
    {
        $attModel = new AttachmentModel();
        $attList  = $attModel->getAll(array('id' => array('in', $attIds)));
        $attArr   = explode(',', $attIds);
        foreach ($attArr as $key => $value) {
            if ($this->getOne(array('status' => 1, 'name' => $attList[$key]['file_key']))) {
                $this->del(array('status' => 1, 'name' => $attList[$key]['file_key']));
            }
            $data['name']        = $attList[$key]['file_key'];
            $data['image']       = $attList[$key]['file_location'];
            $data['description'] = $attList[$key]['description'];
            $data['create_time'] = time();
            $data['create_uid']  = get_user_id();

            $res = $this->insert($data);
            if ($res === false) {
                return false;
            }
        }

        return true;
    }

}