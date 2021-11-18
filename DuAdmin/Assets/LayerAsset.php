<?php

namespace DuAdmin\Assets;

use yii\web\AssetBundle;

/**
 * //https://layui.itze.cn/doc/modules/layer.html
 * icon: 1 success 2 error 3 info 4 forbiden 5 no 6 ok
 */
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
