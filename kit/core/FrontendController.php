<?php

namespace app\kit\core;

use app\kit\models\EventHandler;

abstract class FrontendController extends BaseController {

    public function init() {
        parent::init();
        EventHandler::registerLevel($this, 'FrontendController');
    }

    public function behaviors() {
        $bs = parent::behaviors();
        $bs['post_rate_limit'] = 'app\kit\filters\PostRateLimitFilter';
        return $bs;
    }

    protected function loadBehaviors() {
        return $this->loadConfig("behaviors-frontend.php");
    }

}
