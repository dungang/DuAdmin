<?php
namespace Backend\Controllers;

use app\backend\Components\SettingController as ComponentsSettingController;

class SettingController extends ComponentsSettingController {
    
    public function init() {
        parent::init();
        $this->is_backend_module = true;
    }
    
}