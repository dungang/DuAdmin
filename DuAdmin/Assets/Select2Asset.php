<?php

namespace DuAdmin\Assets;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{

    public $baseUrl = '@web/third/select2';

    public $js = [
        'js/select2.min.js'
    ];

    public $css = [
        'css/select2.min.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
