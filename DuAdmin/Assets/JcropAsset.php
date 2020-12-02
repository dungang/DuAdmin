<?php
namespace DuAdmin\Assets;

use yii\web\AssetBundle;

/**
 *
 * @author dungang
 */
class JcropAsset extends AssetBundle
{
    public $baseUrl = '@web/third/Jcrop/';
    
    public $js = [
        'jquery.Jcrop.min.js'
    ];
    
    
    public $css = [
        'css/jquery.Jcrop.min.css'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

