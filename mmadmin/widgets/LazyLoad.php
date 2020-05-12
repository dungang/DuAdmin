<?php
namespace app\mmadmin\widgets;

use yii\base\Widget;
use app\mmadmin\assets\LazyLoadAsset;
use yii\helpers\Json;

/**
 *
 * @author dungang
 */
class LazyLoad extends Widget
{
    public $options = ['effect'=>'fadeIn','threshold'=>200];

    public function run()
    {
        $options = Json::encode($this->options);
        LazyLoadAsset::register($this->view);
        $this->view->registerJs("$('img.lazyload').lazyload(".$options.");");
    }
}

