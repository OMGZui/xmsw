<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/4/12
 * Time: 15:20
 */
namespace App\Task;

use EasySwoole\EasySwoole\Swoole\Task\AbstractAsyncTask;

class BaseTask extends AbstractAsyncTask
{
    protected function run($taskData, $taskId, $fromWorkerId, $flags = null)
    {

    }

    protected function finish($result, $task_id)
    {

    }
}