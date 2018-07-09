<?php
namespace Home\Controller;

use Home\Model\BannerModel;
use Home\Model\QuestionModel;

/**
 * 题库控制器
 * Class MessageController
 * @package Home\Controller
 */
class QuestionController extends BaseController
{
    /**
     * 题库列表
     * @author Red
     * @date 2016年11月26日16:06:35
     */
    public function index()
    {
    	
        if ($_POST['other'] == 'list') {
            $questionModel = new QuestionModel();
            $limit         = I('post.offset') . ',' . I('post.limit');
            $list          = $questionModel->getQuestionList(array('status' => 1), '*', 'status desc,create_time desc', $limit);
            $i             = 1;
            $questionType  = C('question_type');
            foreach ($list['rows'] as $key => $value) {
                $list['rows'][$key]['kid']       = $i;
                $list['rows'][$key]['type_name'] = $questionType[$value['type']]['name'];
                $i++;
            }
            echo json_encode($list);
            exit;
        }
        $this->display();
    }

    /**
     * 添加题目
     * @author Red
     * @date 2016年12月1日11:57:32
     */
    public function add()
    {
        if (IS_POST) {
            $optionNum    = I('optionNum', 0, 'int');
            $data['type'] = I('question_type', 0, 'int');
            if (!$optionNum) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
            $data['title'] = check_post('title', L('QUESTION_TITLE'));
            //不定项选择
            if ($data['type'] != 0) {
                $contentCount = 0;
                $answerCount  = 0;
                $key          = 1;
                for ($i = 1; $i <= $optionNum; $i++) {
                    I('options_' . $i) && $data['content'][$i] = check_post('options_' . $i, L('PLEASE_WRITE_NUM') . $i . L('QUESTION_OPTION'), 3);
                    I('isChoose_' . $i, 0, 'int') && $data['answer'][$i] = 1;
                    I('options_' . $i) && $contentCount++;
                    I('isChoose_' . $i, 0, 'int') > 0 && $answerCount++;
                    $key++;
                }
                $contentCount == 0 && exit(returnStatus(0, L('LEAST_ONE_OPTION')));
                $answerCount == 0 && exit(returnStatus(0, L('LEAST_ONE_ANSWER')));
                if(count($data['answer'])==1){
                    $data['type']=2;
                }
            }
            //填空题
            if ($data['type'] == 0) {
                $data['answer'][] = $data['content'][] = check_post('options_1', L('ANSWER'));
            }
            $data['content']     = serialize($data['content']);
            $data['answer']      = serialize($data['answer']);
            $data['create_time'] = time();
            $data['create_uid']  = get_user_id();
            $questionModel       = new QuestionModel();
            $res                 = $questionModel->insert($data);
            if ($res === false) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }
        $this->display();
    }

    /**
     * 编辑题目
     * @author Red
     * @date 2016年12月1日14:14:08
     */
    public function edit()
    {
        $id                           = I('id', 0, 'int');
        $questionModel                = new QuestionModel();
        $questionInfo                 = $questionModel->getById($id);
        $questionInfo['content_name'] = unserialize($questionInfo['content']);
        $questionInfo['answer_name']  = unserialize($questionInfo['answer']);
        if (IS_POST) {
            $optionNum    = I('optionNum', 0, 'int');
            $data['type'] = I('question_type', 0, 'int');
            if (!$optionNum) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
            $data['title'] = check_post('title', L('QUESTION_TITLE'));
            //不定项选择
            if ($data['type'] != 0) {
                $contentCount = 0;
                $answerCount  = 0;
                $key          = 1;
                for ($i = 1; $i <= $optionNum; $i++) {
                    I('options_' . $i) && $data['content'][$i] = check_post('options_' . $i, L('PLEASE_WRITE_NUM') . $i . L('QUESTION_OPTION'), 3);
                    I('isChoose_' . $i, 0, 'int') && $data['answer'][$i] = 1;
                    I('options_' . $i) && $contentCount++;
                    I('isChoose_' . $i, 0, 'int') > 0 && $answerCount++;
                    $key++;
                }
                $contentCount == 0 && exit(returnStatus(0, L('LEAST_ONE_OPTION')));
                $answerCount == 0 && exit(returnStatus(0, L('LEAST_ONE_ANSWER')));
                if(count($data['answer'])==1){
                    $data['type']=2;
                }
            }
            //填空题
            if ($data['type'] == 0) {
                $data['answer'][] = $data['content'][] = check_post('options_1', L('ANSWER'));
            }
            $data['content']     = serialize($data['content']);
            $data['answer']      = serialize($data['answer']);
            $data['modify_time'] = time();
            $res                 = $questionModel->update($data,array('id'=>$id));
            if ($res === false) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }
        $this->assign('vo',$questionInfo);
        $this->display();
    }

    /**
     * 删除题目
     * @author Red
     * @date 2016年12月1日13:54:42
     */
    public function delete()
    {
        $id = I('id', 0, 'int');
        if ($id) {
            $questionModel = new QuestionModel();
            $res           = $questionModel->update(array('status'=>0),array('id' => $id));
            if ($res === false) {
                exit(returnStatus(0, L('OPERATE_FAIL')));
            }
            exit(returnStatus(1, L('OPERATE_SUCCESS')));
        }
        exit(returnStatus(0, L('OPERATE_FAIL')));
    }
}