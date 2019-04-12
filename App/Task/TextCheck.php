<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/4/12
 * Time: 15:21
 */

namespace App\Task;

use Co\Redis;

class TextCheck extends BaseTask
{
    protected function run($taskData, $taskId, $fromWorkerId, $flags = null)
    {
        dump("任务开始" . $taskData);
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379, 0.5);
        $taskNum = $redis->get('taskNum');
        if ($taskNum == 5) {
            return true;
        }
        return false;
    }

    protected function finish($result, $task_id)
    {
        dump("任务完成" . $result);
    }
}