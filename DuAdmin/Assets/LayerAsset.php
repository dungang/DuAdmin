<?php

namespace DuAdmin\Assets;

use yii\web\AssetBundle;

class LayerAsset extends AssetBundle
{

    public $baseUrl = '@web/third/layer-v3.5.1/layer';

    public $css = [
        'theme/default/layer.css'
    ];

    public $js = [
        'layer.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
