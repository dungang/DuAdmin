<?php
namespace app\mmadmin\assets;

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
        'app\mmadmin\assets\MomentAsset'
    ];
}

