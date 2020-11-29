<?php
namespace app\mmadmin\assets;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle
{
    public $baseUrl = '@web';
    
    public $css = [
        'third/font-awesome/css/font-awesome.min.css',
        'backend/dist/css/main.css'
    ];
    
    public $js = [
        'backend/dist/js/main.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\validators\ValidationAsset',
        'yii\widgets\ActiveFormAsset'
    ];
}

