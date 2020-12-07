<?php
namespace DuAdmin\Assets;

use yii\web\AssetBundle;

class DUAdminAsset extends AssetBundle
{
    public $baseUrl = '@web';
    
    public $css = [
        'third/font-awesome/css/font-awesome.min.css',
        'duadmin/dist/css/DUAdmin.css'
    ];
    
    public $js = [
        'js/jquery.form.min.js',
        'duadmin/dist/js/DUAdmin.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\validators\ValidationAsset',
        'yii\widgets\ActiveFormAsset',
        'DuAdmin\Assets\NotifyAsset',
    ];
}

