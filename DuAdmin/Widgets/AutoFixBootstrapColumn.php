<?php
namespace DuAdmin\Widgets;

use DuAdmin\Assets\MasonryAsset;
use yii\base\Widget;

class AutoFixBootstrapColumn extends Widget {
    public function run(){
        MasonryAsset::register($this->view);
        $this->view->registerJs('$(".row").masonry({itemSelector:"[class=col-*]"})');
    }
}