<?php
namespace app\kit\assets;

use yii\web\AssetBundle;

class SlickCarouselAsset extends AssetBundle
{
    public $baseUrl = '@web/third/slick/';
    
    public $js = [
        'slick.min.js'
    ];
    
    public $css = [
        'slick.css',
        'slick-theme.css'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

