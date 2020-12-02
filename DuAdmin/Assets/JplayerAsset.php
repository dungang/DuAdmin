<?php
namespace DuAdmin\Assets;

use yii\web\AssetBundle;

/**
 *
 * @author dungang
 */
class JplayerAsset extends AssetBundle
{
    public $baseUrl = '@web/third/jplayer/js';
    
    public $js = [
        'jquery.jplayer.min.js',
    ];
    
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}

