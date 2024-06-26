<?php

namespace DuAdmin\Assets;

use yii\web\AssetBundle;

class HighLightAsset extends AssetBundle
{
    public $baseUrl = '@web/third/highlight';

    public $css = [
        'styles/kimbie.dark.css'
    ];
    public $js = [
        'highlight.pack.js'
    ];
}