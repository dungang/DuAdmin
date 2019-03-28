<?php
namespace app\kit\widgets;

use yii\base\Widget;
use app\kit\assets\LazyLoadAsset;

/**
 *
 * @author dungang
 */
class LazyLoad extends Widget
{

    public function run()
    {
        LazyLoadAsset::register($this->view);
        $this->view->registerJs("$('img.lazyload').lazyload()");
    }
}

