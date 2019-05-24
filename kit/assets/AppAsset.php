<?php
namespace app\kit\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{

    public $baseUrl = '@web';

    public $css = [
        'css/bootstrap-flatly.min.css',
        'font-awesome/css/font-awesome.min.css'
    ];

    public $js = [
        'js/app.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
