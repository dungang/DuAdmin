<?php
namespace app\mmadmin\assets;

use yii\web\AssetBundle;

class NotifyAsset extends AssetBundle
{

    public $baseUrl = '@web/third/notifIt';

    public $js = [
        'js/notifIt.min.js'
    ];

    public $css = [
        'css/notifIt.min.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

