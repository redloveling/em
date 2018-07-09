<?php
namespace Home\Controller;

/**
 * 主控制器
 * Class IndexController
 * @package Home\Controller
 */
class IndexController extends BaseController {
    public function index(){
    	//print_r(strtotime("2017-7-15"));exit();
        $this->display();
    }
}