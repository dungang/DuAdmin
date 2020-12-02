<?php
namespace DuAdmin\Assets;

use yii\web\AssetBundle;

class TreeGridAsset extends AssetBundle
{

    public $baseUrl = '@web/third/jquery-treegrid';

    public $js = [
        'js/jquery.treegrid.min.js'
    ];

    public $css = [
        'css/jquery.treegrid.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

