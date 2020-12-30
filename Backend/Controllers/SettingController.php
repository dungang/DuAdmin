<?php
namespace Backend\Controllers;

use Backend\Components\SettingController as ComponentsSettingController;

class SettingController extends ComponentsSettingController {
    
    public function init() {
        parent::init();
        $this->isBackend = true;
    }
    
}