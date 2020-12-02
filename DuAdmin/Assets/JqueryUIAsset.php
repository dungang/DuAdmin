<?php

namespace DuAdmin\Assets;

use yii\web\AssetBundle;

class JqueryUIAsset extends AssetBundle
{
    public $baseUrl = '@web/js';
    
    public $js = [
        'jquery-ui.min.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}