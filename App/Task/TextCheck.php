<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/4/12
 * Time: 15:21
 */

namespace App\Task;

class TextCheck extends BaseTask
{
    protected function run($taskData, $taskId, $fromWorkerId, $flags = null)
    {
        dump("任务开始" . $taskData);
    }

    protected function finish($result, $task_id)
    {
        dump("任务完成" . $result);
    }
}