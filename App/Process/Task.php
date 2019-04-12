<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/4/12
 * Time: 15:24
 */

namespace App\Process;

use App\Task\TextCheck;
use EasySwoole\Component\Timer;
use EasySwoole\EasySwoole\Swoole\Task\TaskManager;

class Task extends BaseProcess
{
    public function onReceive(string $str)
    {
        dump("进程投递中" . $str);
    }

    public function run($arg)
    {
        dump("进程投递开始" . $arg);
        Timer::getInstance()->loop(1000 * 3, function () {
            // 投递任务
            $textTask = new TextCheck(1111);
            TaskManager::async($textTask);
        });
    }

    public function onShutDown()
    {
    }
}