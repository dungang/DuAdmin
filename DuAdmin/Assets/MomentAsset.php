<?php
namespace DuAdmin\Assets;

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

