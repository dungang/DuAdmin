<?php
namespace app\kit\widgets;

use yii\base\Widget;
use yii\web\JsExpression;
use yii\helpers\Json;
use app\kit\assets\SwiperAsset; 

class Swiper extends Widget
{

    public $clientOptions = [];

    public $selector = '.swiper-container';

    public function run()
    {
        SwiperAsset::register($this->view);
        $this->view->registerJs(new JsExpression("new Swiper('$this->selector'," . Json::encode($this->clientOptions) . ")"));
    }
}

