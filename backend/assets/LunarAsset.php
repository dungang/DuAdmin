<?php

namespace app\backend\assets;

use yii\web\AssetBundle;

class LunarAsset extends AssetBundle
{
    public function init()
    {
        if(empty($this->baseUrl)) {
            $this->sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'lunar';
        }
    }

    public $css = [
        'lunar.css',
    ];

    public $js = [
        'lunar.js',
    ];
}