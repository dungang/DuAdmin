<?php
namespace app\kit\assets;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle
{
    public $baseUrl = '@web';
    
    public $css = [
        'font-awesome/css/font-awesome.min.css',
        'adminlte/css/adminlte.css',
        'css/backend.css'
    ];
    
    public $js = [
        'adminlte/js/adminlte.min.js',
        'js/backend.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}

