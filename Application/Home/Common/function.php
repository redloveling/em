<?php

/**
 * 时间距离
 * @author Red
 * @date 2016年11月14日16:49:32
 * @param $endTime
 * @param int $starTime
 * @return string
 */
function get_deadline($endTime, $starTime = 0,$line=false)
{
    //计算天数
    $timeDiff = $endTime - ($starTime ? $starTime : time());
    $days     = intval($timeDiff / 86400);
    //计算小时数
    $remain = $timeDiff % 86400;
    $hours  = intval($remain / 3600);
    //计算分钟数
    $remain = $remain % 3600;
    $mins   = intval($remain / 60);
    if($line){
        return $days . "-" . $hours . "-" . $mins . "-";
    }
    return $days . "天" . $hours . "小时" . $mins . "分钟";
}



/**
 * 星星闪耀
 * @author Red
 * @date 2016年11月22日15:26:36
 * @param $num
 * @return string
 */
function get_star($num)
{
    $star1 = '';
    $star2 = '';
    $str1 = '<img src="'.__ROOT__.'/public/images/ic_star_light.png">';
    $str2 = '<img src="'.__ROOT__.'/public/images/ic_star_gary.png">';

    for ($i = 1; $i <= $num; $i++) {
        $star1 .= $str1;
    }
    for ($i = 0; $i < 5-$num; $i++) {
        $star2 .= $str2;
    }
    return $star1.$star2;
}

/**
 * 附件上传方法
 * @author Red
 * @date 2016年5月9日15:22:34
 * @param $nameArr
 * @param $type
 * @param $taskId
 * @return bool|string
 */
function addFile($nameArr, $type = 0, $taskId = 0)
{
    if (is_array($nameArr)) {
        $ids = '';
        foreach ($nameArr as $value) {
            $fileArr = getFileArr($value);
            if ($fileArr['file_name']) {
                foreach ($fileArr['file_name'] as $k => $val) {
                    $data                  = array();
                    $data['file_name']     = $val;
                    $data['file_key']      = $value;
                    $data['type']          = $type;
                    $data['case_id']       = $taskId;
                    $data['file_location'] = $fileArr['file_url'][$k];
                    $data['file_type']     = $fileArr['file_type'][$k];
                    $data['file_size']     = $fileArr['file_size'][$k];
                    $data['description']   = $fileArr['file_description'][$k];
                    $data['add_time']      = time();
                    $data['create_uid']    = get_user_id();
                    $type == 1 && $data['description'] = I('description' . substr($value, 11), '', 'trim');
                    $attachmentModel = new \Home\Model\AttachmentModel();
                    $res             = $attachmentModel->insert($data);
                    if ($res === false) {
                        return false;
                    } else {
                        if (!empty ($ids)) {
                            $ids .= ',';
                        }
                        $ids .= $res;
                    }
                }
            }
        }

        return $ids;
    } else {
        return false;
    }
}

/**
 * 获取附件数据
 * @author Red
 * @date 2016年5月9日15:22:54
 * @param $fileName
 * @return mixed
 */
function getFileArr($fileName)
{

    $data['file_name'] = $_POST[$fileName . '_name'];
    $data['file_url']  = $_POST[$fileName . '_url'];
    $data['file_size'] = $_POST[$fileName . '_fileSize'];
    $data['file_type'] = $_POST[$fileName . '_fileType'];
    $data['file_description'] = $_POST[$fileName . '_description'];//强行加上的~￥#5@

    return $data;
}

/**
 * 根据身份证号码算出年龄
 * @author Red
 * @date 2016年12月26日11:37:39
 * @param $idCard
 * @return float
 */
function get_age_by_id_card($idCard)
{
    $date  = strtotime(substr($idCard, 6, 8));//获得出生年月日的时间戳
    $today = strtotime('today');//获得今日的时间戳
    $diff  = floor(($today - $date) / 86400 / 365);//得到两个日期相差的大体年数
    //strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比
    return strtotime(substr($idCard, 6, 8) . ' +' . $diff . 'years') > $today ? ($diff + 1) : $diff;
}