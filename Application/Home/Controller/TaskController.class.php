<?php
namespace Home\Controller;

use Extend\Area;
use Home\Model\AdminUserModel;
use Home\Model\TaskModel;
use Home\Model\UserModel;

/**
 * 任务控制器
 * Class BaseController
 * @package Home\Controller
 */
class TaskController extends BaseController
{
    /**
     * 列表
     * @author Red
     * @date 2016年10月31日16:11:11
     */
    public function index()
    {
        if ($_POST['other'] == 'list') {
            $taskModel = new TaskModel();
            $where     = array();
            if (I('status') || I('status')==0) {
                if (I('status') == 0) {
                    $where['status'] = 0;//待发布
                }
                if (I('status') == 1) {
                    $where['status'] = 1;//准备中
                }
                if (I('status') == 2) {
                    $where['status'] = 2;//进行中
                }
                if (I('status') == 3) {
                    $where['status'] = array('in', '3,4');//已结束包含已结算
                }
                if (I('status') == 'all') {
                    $where['status'] = array('in', '0,1,2,3,4');//全部 排除已删除的
                }
            }
            if (I('area', '', 'trim')) {
                $where['work_area'] = array('like', '%' . I('area', '', 'trim') . '%');
            }
            if (I('start_time') && I('end_time')) {
                $where['issued_time'] = array('between', array(strtotime(I('start_time', '', 'trim')), strtotime(I('end_time', '', 'trim'))));
            }
            if (I('title', '', 'trim')) {
                $where['title'] = array('like', '%' . I('title', '', 'trim') . '%');
            }
            $limit = I('post.offset') . ',' . I('post.limit');
            echo json_encode($taskModel->getTaskList($where, '*', 'status,create_time desc', $limit));
            exit;
        }
        //配置列表
        $taskList = C('task_list');
        $this->assign('taskList', $taskList);
        $this->display();
    }

    /**
     * 任务详情
     * @author Red
     * @date 2016年11月14日09:50:43
     */
    public function detail()
    {
        $id = I('id', 0, 'int');
        if ($id)
            W('Task/taskDetailInfo', array($id));

    }

    /**
     * 添加
     * @author Red
     * @date 2016年10月31日16:53:07
     */
    public function add()
    {
        if (IS_POST) {
            trans_start();
            $userInfo                      = get_user_info();
            $data['business_id']           = $userInfo['business_id'];
            $data['title']                 = str_replace('/','-',check_post('title', L('TASK_TITLE')));
            $data['task_type']             = I('task_type', 0, 'int');
            $data['person_num']            = check_post('person_num', L('PERSON_NUM'));
            $data['person_type']           = I('person_type', 0, 'int');
            $data['deadline']              = strtotime(I('deadline'));
            $data['wages']                 = str_replace(' ', '', check_post('wages', L('WAGES')));
            $data['wages_type']            = I('wages_type', 0, 'int');
            $data['settlement_type']       = I('settlement_type', 0, 'int');
            $data['work_time_description'] = check_post('work_time_description', L('WORK_TIME'));
            $data['start_time']            = strtotime(I('start_time'));
            $data['end_time']              = strtotime(I('end_time'));
            $data['work_area']             = self::saveWorkArea();
            $work_area_detail              = I('area_bounds');
            $data['work_area_detail']      = serialize($work_area_detail);
            $data['place_description']     = check_post('place_description', L('PLACE_DESCRIPTION'));
            $data['work_description']      = check_post('work_description', L('WORK_DESCRIPTION'));
            $data['work_description']      = $_POST['work_description'];//tp中的I方法会过滤特殊标签，so再获取一次
            $data['contact']               = check_post('contact', L('CONTACT'));
            $data['contact_tell']          = check_post('contact_tell', L('CONTACT_TELL'));
            $data['qq']                    = check_post('qq', L('QQ'));
            $data['status']                = I('task_status', 0, 'int');
            $data['issued_time']           = $data['status'] == 0 ? 0 : time();
            $data['create_time']           = time();
            if ($data['issued_time'] != 0) {
                $data['issued_uid'] = $userInfo['id'];
            }
            if ($data['deadline'] > $data['start_time']) {
                trans_back('报名截止时间不能大于开始时间');
            }
            if ($data['start_time'] >= $data['end_time']) {
                trans_back('结束时间必须大于开始时间');
            }
            $taskModel = new TaskModel();
            $res       = $taskModel->insert($data);
            if ($res === false) {
                trans_back();
            }
            insert_task_log($res, '创建任务');
            if ($data['issued_time'] != 0) {
                insert_task_log($res, '创建任务的同时发布任务');
            }
            trans_commit();
        }
        $this->display();
    }

    /**
     * 编辑
     * @author Red
     * @date 2016年11月8日18:02:20
     */
    public function edit()
    {
        $id        = I('id', 0, 'int');
        $taskModel = new TaskModel();
        $taskInfo  = $taskModel->getById($id);
        if (IS_POST && $id) {
            trans_start();
            $userInfo                      = get_user_info();
            $data['business_id']           = $userInfo['business_id'];
            $data['title']                 = str_replace('/','-',check_post('title', L('TASK_TITLE')));
            $data['task_type']             = I('task_type', 0, 'int');
            $data['person_num']            = check_post('person_num', L('PERSON_NUM'));
            $data['person_type']           = I('person_type', 0, 'int');
            $data['deadline']              = strtotime(I('deadline'));
            $data['wages']                 = str_replace(' ', '', check_post('wages', L('WAGES')));
            $data['wages_type']            = I('wages_type', 0, 'int');
            $data['settlement_type']       = I('settlement_type', 0, 'int');
            $data['work_time_description'] = check_post('work_time_description', L('WORK_TIME'));
            $data['start_time']            = strtotime(I('start_time'));
            $data['end_time']              = strtotime(I('end_time'));
            $data['work_area']             = self::saveWorkArea();
            $work_area_detail              = I('area_bounds');
            $data['work_area_detail']      = serialize($work_area_detail);
            $data['place_description']     = check_post('place_description', L('PLACE_DESCRIPTION'));
            $data['work_description']      = check_post('work_description', L('WORK_DESCRIPTION'));
            $data['work_description']      = $_POST['work_description'];//tp中的I方法会过滤特殊标签，so再获取一次
            $data['contact']               = check_post('contact', L('CONTACT'));
            $data['contact_tell']          = check_post('contact_tell', L('CONTACT_TELL'));
            $data['qq']                    = check_post('qq', L('QQ'));
            $data['status']                = I('task_status', 0, 'int');
            $data['issued_time']           = $data['status'] == 0 ? 0 : time();
            $data['modify_time']           = time();
            if ($data['issued_time'] != 0) {
                $data['issued_uid'] = $userInfo['id'];
                insert_task_log($id, '编辑任务的同时发布任务');
            }
            if ($data['deadline'] > $data['start_time']) {
                trans_back('报名截止时间不能大于开始时间');
            }
            if ($data['start_time'] >= $data['end_time']) {
                trans_back('结束时间必须大于开始时间');
            }
            if (false === $taskModel->update($data, array('id' => $id))) {
                trans_back();
            }
            insert_task_log($id, '编辑任务');
            trans_commit();
        }
        $this->assign('vo', $taskInfo);
        $this->display();
    }

    /**
     * 工作区域
     * @author Red
     * @date 2017年2月21日13:48:25
     * @return string
     */
    private function saveWorkArea()
    {
        $area      = '';
        $areaModel = new Area();
        foreach ($_POST['area_1'] as $k => $v) {
            if (!$_POST['area_1'][$k] || $_POST['area_1'][$k] == '--请选择--') {
                exit(returnStatus(0, '请选择第' . ($k + 1) . '个区域的省'));
            }
            $area .= trim($_POST['area_1'][$k]) . ',';
            if (!$_POST['area_2'][$k]) {
                exit(returnStatus(0, '请选择第' . ($k + 1) . '个区域的市'));
            }
            $area .= trim($_POST['area_2'][$k]) . ',';
            if (!$_POST['area_3'][$k]) {
                exit(returnStatus(0, '请选择第' . ($k + 1) . '个区域的区'));
            }
            $area .= trim($_POST['area_3'][$k]) . ';';
            //从高德地图上抓取省市区三级行政区域便于搜索
            if (trim($_POST['area_3'][$k]) != '不定') {
                $areaModel->insetArea(trim($_POST['area_1'][$k]), trim($_POST['area_2'][$k]), trim($_POST['area_3'][$k]));
            }
        }

        return rtrim($area, ';');
    }

    /**
     * 发布任务(变为准备中)
     * @author Red
     * @date
     */
    public function issued()
    {
        $id = I('id', 0, 'int');
        if ($id) {
            trans_start();
            $taskModel = new TaskModel();
            if (false === $taskModel->update(array('status' => 1, 'issued_uid' => get_user_id(), 'issued_time' => time()), array('id' => $id))) {
                trans_back();
            }
            insert_task_log($id, '发布任务');
            trans_commit();
        }
        trans_back();
    }

    /**
     * 删除任务
     * @author Red
     * @date 2017年3月9日16:03:32
     */
    public function delTask()
    {
        $id = I('id', 0, 'int');
        if ($id) {
            trans_start();
            $taskModel = new TaskModel();
            if (false === $taskModel->update(array('status' => 100), array('id' => $id))) {
                trans_back();
            }
            insert_task_log($id, '删除任务');
            trans_commit();
        }
        trans_back();
    }

}