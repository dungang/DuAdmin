<?php
namespace app\backend\task;

use app\mmadmin\components\Addon;

/**
 *
 * @author dungang
 */
class TaskModule extends Addon
{
    protected function initBackend()
    {
        $this->name = '定时任务';
        $this->controllerNamespace = 'app\backend\task\controllers';
    }
}

