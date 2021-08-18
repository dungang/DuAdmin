<?php

namespace Addons\Cms\PageBlock\Layouts\Carousel;

use Addons\Cms\PageBlock\BaseBlockWidget;
use DuAdmin\Assets\SlickCarouselAsset;

class Carousel extends BaseBlockWidget
{
    public $type = 'layout';
    public $basePath = __DIR__;
    public $iconFile = 'carousel.png';
    public $codeFile = 'carousel-code';
    public $cssFile = 'carousel.css';
    public $jsFile = 'carousel.js';
    public $clientOptions = [
        'infinite' => true,
        'autoplay' => true,
        'speed'    => 500,
        'fade'     => true,
        'arrows'   => false,
        'cssEase'  => 'linear'
    ];

    public function registerAssets()
    {
        SlickCarouselAsset::register(\Yii::$app->view);
    }

}