<?php
namespace DuAdmin\Assets;

use yii\web\AssetBundle;

/**
 *
 * @author dungang
 * https://mkoryak.github.io/floatThead/
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

