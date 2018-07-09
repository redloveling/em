<?php
namespace Data\Controller;

use Home\Model\AttachmentModel;
use Home\Model\UserCardListModel;
use Home\Model\UserModel;
use Home\Model\UserRealAuditModel;
use Think\Controller;

/**
 *  用于数据处理
 * Class IndexController
 * @package Data\Controller
 */
class IndexController extends Controller
{
    function __construct()
    {
        $userId = get_user_id();
        if ($userId != 1) {
            $this->redirect('Home/Index/index');
        }
    }

    public function index()
    {
//        $this->realAuditHandle();
//        $this->userToReal();
    }

    /**
     * 处理user_real_refuse表的数据到user_real_audit
     * @author Red
     * @date 2017年3月6日09:53:43
     */
    public function realAuditHandle()
    {
        $refuseModel    = M('user_real_refuse');
        $realModel      = new UserRealAuditModel();
        $realRefuseList = $refuseModel->select();
        foreach ($realRefuseList as $value) {
            $refuse                 = M('tb_realaudit_refuse_type')->where(array('id' => $value['refuse_type']))->field('name')->find();
            $data['uid']            = $value['user_id'];
            $data['audit_uid']      = 5;
            $data['audit_username'] = 'wangju';
            $data['status']         = 2;
            $data['refuse_type']    = $value['refuse_type'];
            $data['refuse_name']    = $refuse['name'];
            $data['description']    = $value['description'];
            $data['audit_time']     = '1488250560';
            $data['create_time']    = '1488250560';
            //$realModel->insert($data);
        }

    }

    /**
     * 从user表中提取已经实名审核的数据
     * @author Red
     * @date 2017年3月7日16:33:44
     */
    public function userToReal()
    {
        $userModel = new  UserModel();
        $realModel = new UserRealAuditModel();
        $attachModel = new  AttachmentModel();
        $list      = $userModel->getAll(array('real_status' => array('in', '1,2')));
        foreach ($list as $value) {
            $att1 = $attachModel->getOne(array('file_location'=>$value['card_num_positive'],'file_key'=>'positive','create_uid'=>$value['id']));
            $att2 = $attachModel->getOne(array('file_location'=>$value['card_num_opposite'],'file_key'=>'negative','create_uid'=>$value['id']));
            $att1 && $data['attach_ids']     = $att1['id'].','.$att2['id'];
            $data['uid']            = $value['id'];
            $data['audit_uid']      = 5;
            $data['audit_username'] = 'wangju';
            $data['status']         = $value['real_status'] == 1 ? 0 : 1;
            $data['audit_time']     = $value['last_login'];
            $data['create_time']    = $value['last_login'];
            $serialize['true_name'] = $value['true_name'];
            $serialize['sex']       = $value['sex'];
            $serialize['age']       = $value['age'];
            $serialize['card_num']  = $value['card_num'];
            $serialize['birthday']  = $value['birthday'];
            $data['serialize'] = serialize($serialize);
            //$realModel->insert($data);
        }
    }
    public function realPayTime(){
        $userModel = new  UserModel();
        $realModel = new UserRealAuditModel();
        $cardModel = new UserCardListModel();
//        //实名审核
//        $list = $userModel->getAll(array('real_status'=>2));
//        foreach ($list as $value){
//            $res = $realModel->getOne(array('uid'=>$value['id'],'status'=>1));
//            if($res){
//                $sql = 'update em_user set real_time='.$res['audit_time'].' where id='.$value['id'].';';
//                print_r($sql.'<br/>');
//            }
//        }
        //支付审核
        $list = $userModel->getAll(array('pay_status'=>2));
        foreach ($list as $value){
            $res = $realModel->get(array('user_id'=>$value['id'],'status'=>1,'status_1'=>1),"*",true,'','','audit_time asc');
            if($res){
                $sql = 'update em_user set pay_time='.$res[0]['audit_time'].' where id='.$value['id'].';';
                print_r($sql.'<br/>');
            }
        }
    }
    public function usernameTell()
    {
        $userModel = new  UserModel();
        $list = $userModel->getAll();
        foreach ($list as $value){
            if($value['tell']==$value['nick_name']){
                $sql = 'update em_user set nick_name="'.substr_replace($value['tell'],'****',3,4).'" where id='.$value['id'].';';
                print_r($sql.'<br/>');
            }
        }
    }
}