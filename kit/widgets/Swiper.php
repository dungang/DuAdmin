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

    public $items;

    public $pagination;

    public $navigation;

    public $scrollbar;

    public $slideContentCallback;

    public function run()
    {
        SwiperAsset::register($this->view);
        if($this->pagination instanceof JsExpression) {
            $this->clientOptions['pagination'] = $this->pagination;
        }
        if($this->navigation instanceof JsExpression) {
            $this->clientOptions['navigation'] = $this->navigation;
        }
        if($this->scrollbar instanceof JsExpression) {
            $this->clientOptions['scrollbar'] = $this->scrollbar;
        }
        $this->view->registerJs(new JsExpression("new Swiper('$this->selector'," . Json::encode($this->clientOptions) . ");"));
 
        if(is_array($this->items) && is_callable($this->slideContentCallback)) {
            $html = '';
            foreach($this->items as $index=>$item){
                $html .= '<div class="swiper-slide">'.call_user_func($this->slideContentCallback,$item,$index).'</div>';
            }
            $html = '<div class="swiper-wrapper">' . $html . '</div>';
            if($this->pagination) {
                $html .= '<div class="swiper-pagination"></div>';
            }
            if($this->navigation) {
                $html .= '<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>';
            }
            if($this->scrollbar) {
                $html .= '<div class="swiper-scrollbar"></div>';
            }
            return "<div class='swiper-container'>". $html ."</div>";
        }
        return null;
    }
}

