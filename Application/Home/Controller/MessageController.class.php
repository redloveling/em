<?php
namespace Home\Controller;

use Home\Model\MessageModel;

/**
 * 留言控制器
 * Class MessageController
 * @package Home\Controller
 */
class MessageController extends BaseController
{
    /**
     * 留言列表
     * @author Red
     * @date 2016年12月29日11:57:30
     */
    public function index()
    {
        if ($_POST['other'] == 'list') {
            $messageModel = new MessageModel();
            $limit        = I('post.offset') . ',' . I('post.limit');
            $where        = array();
            if (I('start_time') && I('end_time')) {
                $where['em_message.create_time'] = array(array('egt', strtotime(I('start_time'))), array('elt', strtotime(I('end_time'))));
            }
            if (I('content', '')) {
                $where['em_message.content'] = array('like', '%' . I('content', '', 'trim') . '%');
            }
            $list          = $messageModel->getLeaveMessage($where, '*,em_message.id as message_id,em_message.status as message_status', 'message_status,message_time', $limit);
            //print_r($messageModel->getLastSql());exit;
            $black_status1 = C('black_status1');
            $real_status   = C('real_status');
            $educationList = get_config_table_list('tb_education');

            foreach ($list['rows'] as $key => $value) {
                $list['rows'][$key]['sex_name']          = sex_trans($value['sex']);
                $list['rows'][$key]['black_status_name'] = $black_status1[$value['black_status']];
                $list['rows'][$key]['real_status_name']  = '<font style="color: #666667">'.$real_status[$value['real_status']].'</font>';
                $list['rows'][$key]['message_time']      = format_time($value['message_time']);
                $list['rows'][$key]['star_label_name']   = get_star($value['star_label']);
                $list['rows'][$key]['education_name']    = $educationList[$value['education_id']]['name'];
                $list['rows'][$key]['status_name']       = $value['message_status'] == 0 ? '<font style="color: #4f99cd">未读</font>' : '<font style="color: #878787">已读</font>';
            }
            echo json_encode($list);
            exit;
        }
        $this->display();
    }

    /**
     * 展示用户留言的图片
     * @author Red
     * @date 2016年12月27日10:52:59
     */
    public function showMessagePicture(){
        if (I('messageId', 0, 'int')){
            $messageModel = new MessageModel();
            $messageInfo = $messageModel->getById(I('messageId','0','int'));
            if(!$messageInfo['att_ids']){
                echo '暂无图片，亲！';exit;
            }
            W('Some/picture', array($messageInfo['att_ids']));
        }


    }

    /**
     * 留言操作
     * @author Red
     * @date 2016年12月29日12:02:26
     */
    public function messageHandle(){
        $ids = I('ids','','trim');
        if($ids && IS_POST){
            $status = I('status',0,'int');
            $messageModel = new MessageModel();
            $messageModel->update(array('status'=>$status),array('id'=>array('in',implode(',',$ids))));
            exit(returnStatus(1, L('OPERATE_SUCCESS')));

        }
        exit(returnStatus(0, L('OPERATE_FAIL')));

    }
}