<?php

namespace app\mmadmin\swagger;

use yii\web\AssetBundle;

class SwaggerAsset extends AssetBundle
{

    public $baseUrl = '@web/third/swagger-ui';

    public $js = [
        'swagger-ui-bundle.js',
        'swagger-ui-standalone-preset.js',
    ];

    public $css = [
        'swagger-ui.css'
    ];

    public $depends = [];
}
