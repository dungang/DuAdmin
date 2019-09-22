<?php
namespace app\backend;

use app\kit\components\Addon;

class BackendModule extends Addon
{

    public function init()
    {
        parent::init();
        \Yii::$app->user->loginUrl = [
            'backend/login'
        ];
        $this->name = '后台';
        $this->home = [
            'label' => $this->name,
            'url' => [
                '/backend/default/index'
            ]
        ];
        $this->controllerNamespace = 'app\backend\controllers';
        $this->controllerMap = [
            'setting' => [
                'class' => 'app\backend\components\SettingController',
                'is_backend_module' => true
            ]
        ];
        $this->modules = [
            'task' => [
                'class' => 'app\backend\task\TaskModule'
            ]
        ];
    }
}
