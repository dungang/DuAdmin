<?php
namespace app\kit\assets;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle
{
    public $baseUrl = '@web';
    
    public $css = [
        'third/font-awesome/css/font-awesome.min.css',
        'third/adminlte/css/adminlte.css',
        'css/backend.css'
    ];
    
    public $js = [
        'third/adminlte/js/adminlte.js',
        'js/backend.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\validators\ValidationAsset',
        'yii\widgets\ActiveFormAsset'
    ];
}

