<?php

namespace DuAdmin\Assets;

use yii\web\AssetBundle;

class NestableAsset extends AssetBundle
{
    public $baseUrl = '@web/js';

    public $js = [
        'jquery.nestable.js'
    ];

    public $depends = [
        'DuAdmin\Assets\DuAdminAsset'
    ];
}
