<?php

namespace app\kit\widgets;

use yii\base\Widget;
use yii\helpers\Json;
use app\kit\assets\ZTreeAsset;

class ZTree extends Widget
{
    public $settings;

    public $nodes =[];

    public function run(){
        
        ZTreeAsset::register($this->view);
        $id = $this->getId();
        $settings = Json::encode($this->settings?: new \stdClass());
        $nodes = Json::encode($this->nodes);
        $this->view->registerJs("$.fn.zTree.init($('#{$id}'),$settings,$nodes);");
    }
}