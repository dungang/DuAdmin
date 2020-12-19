<?php
namespace DuAdmin\Assets;

use yii\web\AssetBundle;

class GoogleFontsSourceSansProAsset extends AssetBundle
{
    public $baseUrl = "https://fonts.googleapis.com/";
    
    public $css = [
        'css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic'
    ];
}

