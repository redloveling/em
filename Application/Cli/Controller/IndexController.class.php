<?php
namespace Cli\Controller;

use Extend\SendShortMessage;
use Home\Model\MessageModel;
use Home\Model\TaskModel;
use Home\Model\UserModel;
use Home\Model\UserTaskModel;
use Think\Controller;

class IndexController extends Controller
{

    public function index()
    {
        $taskModel     = new TaskModel();
        $userTaskModel = new UserTaskModel();
        $messageModel  = new MessageModel();
        $userModel     = new UserModel();
        $taskList      = $taskModel->getAll(array('status' => array('in', '1,2')), 'id,status,start_time,end_time');
        $currentTime   = time();
        foreach ($taskList as $value) {
            $taskId = $value['id'];

            //根据任务开始时间判断  任务是否进行中  用户任务是否任务中
            //--------------------------任务开始时间-------------------------------
            if ($value['status'] == 1 && $value['start_time'] <= $currentTime) {
                $userTaskList = $userTaskModel->getAll(array('status_1' => 3, 'task_id' => $taskId), 'id,user_id');
                //发送消息
                foreach ($userTaskList as $v) {
                    //消息
                    $messageModel->insertMessageFromTemplate($v['user_id'], 6, 0, 0, $taskId);

                    //user_task status=>2 进行中的状态status_2改为2（任务中） 只有报名成功的状态才发生变化
                    $userTaskModel->update(array('status_2' => 2, 'status_msg' => '任务中', 'modify_time' => time()), array('id' => $v['id']));
                    insert_user_task_log($v['user_id'], $taskId, '任务中');
                }

                //user_task 准备中的状态status_1改为2（报名失败）没有审核的
                //$userTaskModel->update(array('status_1' => 2,'modify_time'=>time()), array('status_1'=>1,'task_id' => $taskId));
                //$value['status_1']==1 && insert_task_log($taskId,'超时报名失败');
                //· 目前报名处理超时是按任务开始时间来判断的。
                //将其改为：报名申请后的3天内，超过3天算作超时。（不再与任务截止时间相关，只与用户报名申请的时间相关） 2017年3月20日10:04:57 -red
                // 如果超过工作结束时间也判定为报名失败
                $where1['status_1']    = 1;
                $where1['task_id']     = $taskId;
                $where1['create_time'] = array('lt', time() - 60 * 60 * 24 * 3);
                $userTaskList          = $userTaskModel->getAll($where1);
                foreach ($userTaskList as $v) {
                    insert_user_task_log($v['user_id'], $taskId, '超时报名失败');
                }
                $userTaskModel->update(array('status_1' => 2, 'status_msg' => '报名失败（超时）', 'modify_time' => time()), $where1);

                //task 改为进行中
                insert_task_log($taskId, '任务进行中');
                $taskModel->update(array('status' => 2), array('id' => $taskId));
                $userTaskModel->update(array('status' => 2), array('task_id' => $taskId));

            }
            //根据任务结束时间判断  任务是否结束 用户任务是否完成
            //--------------------------任务结束时间-------------------------------
            if ($value['status'] == 2 && $value['end_time'] <= $currentTime) {
                //用户任务为任务中才发送消息
                $userTaskList1 = $userTaskModel->getAll(array('status_1' => 3, 'status_2' => 2, 'task_id' => $taskId), 'id,user_id');
                //发送消息
                foreach ($userTaskList1 as $v) {
                    //app消息
                    $messageModel->insertMessageFromTemplate($v['user_id'], 7, 0, 0, $taskId);

                    //任务完成后当前人员参加过任务join_status改为2
                    $userModel->update(array('join_status' => 2), array('id' => $v['user_id']));

                    insert_user_task_log($v['user_id'], $taskId, '任务完成');
                    # 用户任务=》任务中改为任务完成
                    $userTaskModel->update(array('status_3' => 2, 'status_msg' => '任务完成'), array('id' => $v['id']));

                }
                // 因为超时设置的原因=》任务的状态已经为进行中，而用户的任务状态还是报名 so 如果超过工作结束时间也判定为报名失败
                $userTaskList2 = $userTaskModel->getAll(array('status_1' => 1, 'status' => 2, 'task_id' => $taskId), 'id,user_id');
                foreach ($userTaskList2 as $v) {
                    insert_user_task_log($v['user_id'], $taskId, '报名失败（超过任务结束时间未处理）');
                    $userTaskModel->update(array('status_1' => 2, 'status_msg' => '报名失败（超时）'), array('id' => $v['id']));
                }

                # 用户任务=》任务外改为任务失败
                $userTaskList3 = $userTaskModel->getAll(array('status_2' => 1, 'status' => 2, 'task_id' => $taskId), 'id,user_id,status_1,deny_time,black_time');
                foreach ($userTaskList3 as $v) {
                    insert_user_task_log($v['user_id'], $taskId, '任务失败（任务外->任务失败）');
                    $data['status_3'] = 1;
                    $v['deny_time'] && $data['status_msg'] = '任务失败（踢出）';
                    $v['black_time'] && $data['status_msg'] = '任务失败（拉黑）';
                    $v['status_1'] == 4 && $data['status_msg'] = '任务失败（放弃任务）';
                    $userTaskModel->update($data, array('id' => $v['id']));
                }

                //task 改为已结束
                insert_task_log($taskId, '任务结束');
                $taskModel->update(array('status' => 3), array('id' => $taskId));

                //user_task status改为3已结束
                $userTaskModel->update(array('status' => 3, 'modify_time' => time()), array('task_id' => $taskId));


                //更新任务表的任务完成数量
                $count = $userTaskModel->getCount(array('task_id' => $taskId, 'status' => 3, 'status_3' => 2));
                $taskModel->update(array('finished_count' => $count), array('id' => $taskId));
            }
        }
    }

    /**
     * 每个月15号30号结算
     * @author Red
     * @date 2017年7月28日17:19:56
     */
    public function settlement()
    {
        $currentDay = date('m', time());
        if ($currentDay <= 16) {
            $data['time'] = date('Y-m-d', time());
        } else {
            $data['time'] = date('Y-m', time()) . '-30';
        }
        $data['settlement_time'] = time();
        $data['create_time']     = time();
        M('settlement')->add($data);
        //向蒲昕发送短信提示结算
        $shortMessage = new SendShortMessage();
        $shortMessage->alisend('15756266568', 'SMS_79550052', array('date' => $data['time']));
    }
}