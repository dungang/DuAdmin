<?php
namespace DuAdmin\Assets;

use yii\web\AssetBundle;

class AutoCompleteAsset extends AssetBundle
{
    public $baseUrl = '@web/js';
   
    public $js = [
        'jquery.autocomplete.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset'
    ];
}

