<?php
namespace app\backend\task;

use app\kit\components\Addon;

/**
 *
 * @author dungang
 */
class TaskModule extends Addon
{
    public function init()
    {
        $this->name = '定时任务';
        $this->controllerNamespace = 'app\backend\task\controllers';
        parent::init();
    }
}

