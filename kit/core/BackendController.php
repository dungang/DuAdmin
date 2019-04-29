<?php

namespace app\kit\core;

use app\kit\filters\AccessFilter;
use app\kit\filters\SaveRouteFilter;
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
        if (YII_ENV_DEV) {
            $behaviors['saveRoute'] = SaveRouteFilter::className();
        }
        $behaviors[AccessFilter::ID] = AccessFilter::className();
        return $behaviors;
    }

    protected function loadBehaviors() {
        return $this->loadConfig("behaviors-backend.php");
    }


}
