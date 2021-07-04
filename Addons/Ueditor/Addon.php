<?php

namespace Addons\Ueditor;

use DuAdmin\Components\Addon as BaseAddon;

class Addon extends BaseAddon {

    protected function initBackend() {
        $this->defaultRoute = "setting/index";
        $this->name = '百度编辑器';
        $this->home = [
            'label' => $this->name,
            'url'   => [
                '/ueditor/setting/index'
            ]
        ];
        $this->controllerMap = [
            'setting' => [
                'class'           => 'Backend\Components\SettingController',
                'defaultCategory' => 'addon-ueditor'
            ]
        ];
    }

}
