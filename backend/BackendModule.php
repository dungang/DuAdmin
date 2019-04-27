<?php
namespace app\backend;

use app\kit\components\Addon;

class BackendModule extends Addon
{

    public function init()
    {
        $this->name = '系统';
        $this->controllerNamespace = 'app\backend\controllers';
        $this->controllerMap = [
            'setting' => [
                'class' => 'app\backend\components\SettingController',
                'is_backend_module'=>true,
            ]
        ];
        parent::init();
        $this->modules = [
            'task'=> [
                'class' => 'app\backend\task\TaskModule',
            ]
        ];
    }
}

