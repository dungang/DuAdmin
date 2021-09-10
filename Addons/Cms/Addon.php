<?php

namespace Addons\Cms;

use DuAdmin\Components\Addon as BaseAddon;
use Yii;

/**
 *
 * @author dungang
 */
class Addon extends BaseAddon {

    protected function initBackend() {

        $this->name = '内容系统';
        Yii::$app->view->params['subTitle'] = $this->name;
        $this->home = [
            'label' => $this->name,
            'url'   => [
                '/cms/post/index'
            ]
        ];
        $this->defaultRoute = 'post';
        $this->controllerMap = [
            'setting' => [
                'class'           => 'Backend\Components\SettingController',
                'defaultCategory' => 'addon-cms'
            ]
        ];
    }

    protected function initFrontend() {

        $this->defaultRoute = 'post';
    }

}
