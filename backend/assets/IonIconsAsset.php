<?php

namespace app\backend\assets;

use yii\web\AssetBundle;

class IonIconsAsset extends AssetBundle
{
    public function init()
    {
        if(empty($this->baseUrl)) {
            $this->sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'ionicons';
        }
    }

    public $css = [
        'css/ionicons.min.css',
    ];
}