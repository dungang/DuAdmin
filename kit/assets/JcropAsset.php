<?php
namespace app\kit\assets;

use yii\web\AssetBundle;

/**
 *
 * @author dungang
 */
class JcropAsset extends AssetBundle
{
    public $baseUrl = '@web/Jcrop/';
    
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

