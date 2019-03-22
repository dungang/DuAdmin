<?php
namespace app\kit\assets;

use yii\web\AssetBundle;

/**
 *
 * @author dungang
 */
class FloatTheadAsset extends AssetBundle
{
    public $baseUrl = '@web/float-thead';
    
    public $js = [
        'jquery-floatthead.min.js',
    ];
    
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}

