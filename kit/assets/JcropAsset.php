<?php
namespace app\kit\assets;

use yii\web\AssetBundle;

/**
 *
 * @author dungang
 */
class JcropAsset extends AssetBundle
{
    public $baseUrl = '@web/js/';
    
    public $js = [
        'jquery.Jcrop.min.js'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

