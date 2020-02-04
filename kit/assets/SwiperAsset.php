<?php
namespace app\kit\assets;

use yii\web\AssetBundle;

/**
 *
 * @author dungang
 */
class SwiperAsset extends AssetBundle
{
    
    public $baseUrl = '@web/third/swiper/';
    
    public $js = [
        'js/swiper.min.js',
        'js/swiper.animate1.0.3.min.js'
    ];
    
    public $css = [
        'css/swiper.min.css',
        'css/animate.min.css'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

