<?php
namespace Home\Controller;

use Home\Model\AdminNodeModel;
use Think\Controller;

/**
 * 控制器基类
 * Class BaseController
 * @package Home\Controller
 */
class BaseController extends Controller
{
    public function _initialize()
    {
        //登录检测
        if (!get_access_user()) {
            //关闭所有弹框
            echo "<script type='text/javascript'>layer.closeAll();</script>";
            $this->redirect('Public/login');
        }
        //权限判断
        self::judge_access();
        $this->assign('web_icon', C('WEB_ICON'));
        $this->assign('web_title', C('WEB_TITLE'));
    }

    /**
     * 权限判断
     * @author Red
     * @date 2016年12月28日11:29:55
     */
    private function judge_access()
    {
        $userInfo      = get_user_info();
        $nodeModel     = new AdminNodeModel();
        $url           = $_SERVER['REQUEST_URI'];
        $code          = str_replace('/home', '', rtrim(strtolower(substr($url, 10)), '/'));
        $nodeInfo      = $nodeModel->getOne(array('type' => 2, 'code' => $code));
        $accessNodeIds = $nodeModel->getAdminUserAccessNodeIds();
        //print_r($code!='/index' && $code!='/index.html');
        //print_r(!in_array($nodeInfo['id'], explode(',', $accessNodeIds)));exit;
        if ($code == '/index' || $code == '/index.html') {
        } else {
            if ($nodeInfo && !in_array($nodeInfo['id'], explode(',', $accessNodeIds)) && !$userInfo['isSuper']) {
                $this->redirect('home/index');
            }
        }

    }
}