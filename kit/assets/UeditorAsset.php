<?php

namespace app\kit\assets;

use yii\web\AssetBundle;

class UeditorAsset extends AssetBundle
{
    public $baseUrl = '@web/ueditor';

    public $js = [
        'ueditor.config.js',
        'ueditor.all.min.js',
    ];
}
