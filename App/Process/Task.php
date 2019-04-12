<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/4/12
 * Time: 15:24
 */

namespace App\Process;

use App\Task\TextCheck;
use Co\Redis;
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
            go(function () {
                $redis = new Redis();
                $redis->connect('127.0.0.1', 6379, 0.5);
                $redis->set('taskNum', 1);
                $redis->incr('taskNum');
            });
        });
    }

    public function onShutDown()
    {
    }
}