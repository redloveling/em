<?php
/**
 * Created by PhpStorm.
 * User: Red
 * Date: 2016/10/14
 * Time: 10:52
 */
namespace Extend;
class AutoLoad
{
    public function load()
    {
        ignore_user_abort();
        //即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行.

        set_time_limit(3000);
        //执行时间为无限制，php默认的执行时间是30秒，通过set_time_limit(0)可以让程序无限制的执行下去

        $interval =  50;
        //每隔5分钟运行
        for($i=0;$i<=10;$i++){

            echo '测试'.time().'<br/>';
            sleep($interval);// 等待5s
        }

    }
}

?>