<?php
namespace app\mmadmin\assets;

use yii\web\AssetBundle;

class CropperAsset extends AssetBundle {

    public $baseUrl = '@web/third/cropper';

    public $css = ['cropper.min.css'];

    public $js = [
        'cropper.min.js',
        'jquery-cropper.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset'
    ];
}