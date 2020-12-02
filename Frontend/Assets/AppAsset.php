<?php
namespace Frontend\Assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{

    public $baseUrl = '@web';

    public $css = [
       'third/font-awesome/css/font-awesome.min.css',
    ];

    public $js = [
        'js/app.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
