<?php

namespace Addons\Ueditor\Assets;

use yii\web\AssetBundle;

class UeditorAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'ueditor';

    public $js = [
        'ueditor.config.js',
        'ueditor.all.min.js',
    ];

    public $publishOptions = [
        'publishDir' => 'ueditor'
    ];
}