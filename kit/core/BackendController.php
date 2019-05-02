<?php

namespace app\kit\core;

use app\kit\filters\AccessFilter;
use app\kit\models\EventHandler;

abstract class BackendController extends BaseController {

    public function init() {
        parent::init();
        EventHandler::registerLevel($this, 'BackendController');
        $this->module->layoutPath = '@app/backend/views/layouts';
        $this->layout = 'main';
    }

    public function behaviors() {
        $behaviors = parent::behaviors();
        //必须把行为放在第一个位置
        array_unshift($behaviors,AccessFilter::className());
        return $behaviors;
    }

    protected function loadBehaviors() {
        return $this->loadConfig("behaviors-backend.php");
    }


}
