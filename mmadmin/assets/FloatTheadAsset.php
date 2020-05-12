<?php
namespace app\mmadmin\assets;

use yii\web\AssetBundle;

/**
 *
 * @author dungang
 */
class FloatTheadAsset extends AssetBundle
{
    public $baseUrl = '@web/third/float-thead';
    
    public $js = [
        'jquery-floatthead.min.js',
    ];
    
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}

