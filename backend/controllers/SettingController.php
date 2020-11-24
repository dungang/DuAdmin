<?php
namespace app\backend\controllers;

use app\backend\components\SettingController as ComponentsSettingController;

class SettingController extends ComponentsSettingController {
    
    public function init() {
        parent::init();
        $this->is_backend_module = true;
    }
    
}