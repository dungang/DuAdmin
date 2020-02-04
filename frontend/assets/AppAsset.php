<?php
namespace app\frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{

    public $baseUrl = '@web';

    public $css = [
       //'css/bootstrap-flatly.min.css',
       'third/font-awesome/css/font-awesome.min.css',
       'css/site.css'
    ];

    public $js = [
        'js/app.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
