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

    /**
     * 分页器
     * @var boolean
     */
    public $pagination = false;

    /**
     * 导航按钮
     * @var boolean
     */
    public $navigation = false;

    /**
     * 滚动条
     * @var boolean
     */
    public $scrollbar = false;

    /**
     * 自动滑动
     * @var boolean
     */
    public $autoplay = true;


    /**
     * 循环播放
     * @var boolean
     */
    public $loop = true;

    /**
     * 内如
     * @var callable
     */
    public $slideContentCallback;

    public function run()
    {
        SwiperAsset::register($this->view);
        if ($this->pagination) {
            $this->clientOptions['pagination'] = [
                'el' => '.swiper-pagination',
            ];
        }
        if ($this->navigation) {
            $this->clientOptions['navigation'] = [
                'nextEl' => '.swiper-button-next',
                'prevEl' => '.swiper-button-prev',
            ];
        }
        if ($this->scrollbar) {
            $this->clientOptions['scrollbar'] = [
                'el' => '.swiper-scrollbar',
            ];
        }

        $this->clientOptions['autoplay'] = $this->autoplay;
        $this->clientOptions['loop'] = $this->loop;

        $this->view->registerJs(new JsExpression("new Swiper('$this->selector'," . Json::encode($this->clientOptions) . ");"));

        if (is_array($this->items) && is_callable($this->slideContentCallback)) {
            $html = '';
            foreach ($this->items as $index => $item) {
                $html .= '<div class="swiper-slide">' . call_user_func($this->slideContentCallback, $item, $index) . '</div>';
            }
            $html = '<div class="swiper-wrapper">' . $html . '</div>';
            if ($this->pagination) {
                $html .= '<div class="swiper-pagination"></div>';
            }
            if ($this->navigation) {
                $html .= '<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>';
            }
            if ($this->scrollbar) {
                $html .= '<div class="swiper-scrollbar"></div>';
            }
            return "<div class='swiper-container'>" . $html . "</div>";
        }
        return null;
    }
}
