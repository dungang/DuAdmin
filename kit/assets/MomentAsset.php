<?php
namespace app\kit\assets;

use yii\web\AssetBundle;

class MomentAsset extends AssetBundle
{
    public $baseUrl = '@web/js/';
    
    public $js = [
        'moment.min.js'
    ];
  
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

