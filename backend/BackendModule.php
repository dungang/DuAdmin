<?php
namespace app\backend;

use yii\base\Module;

class BackendModule extends Module
{
    public function init() {
        parent::init();
        $this->controllerNamespace = 'app\backend\controllers';
        $this->viewPath = '@app/themes/backend';
        $this->layout = 'backend';
    }
}

