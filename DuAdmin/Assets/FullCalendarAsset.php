<?php
namespace DuAdmin\Assets;

use yii\web\AssetBundle;

class FullCalendarAsset extends AssetBundle
{

    public $baseUrl = '@web/fullcalendar/';

    public $js = [
        'fullcalendar.min.js',
        'locale/zh-cn.js',
    ];

    public $css = [
        'fullcalendar.min.css'
    ];

    public $depends = [
        'DuAdmin\Assets\MomentAsset'
    ];
}

