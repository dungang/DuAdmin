<?php

namespace Addons\ChinaRegion;

use DuAdmin\Components\Addon as BaseAddon;
use Yii;

class Addon extends BaseAddon {

	/**
	 * 开启后台功能
	 *
	 */
    protected function initBackend()
    {
        $this->name = '中国行政区';
        $this->home = [
            'label' => $this->name,
            'url' => [
                '/china-region/default/index'
            ]
        ];
        Yii::$app->view->params['subTitle'] = $this->name;
        Yii::$app->setHomeUrl([
            '/china-region'
        ]);
        // 插件如有自定义配置，使用如下配置
        // $this->controllerMap = [
        //     'setting' => [
        //         'class' => 'Backend\Components\SettingController',
        //         'default_category' => 'china-region'
        //     ]
        // ];
    }
}
