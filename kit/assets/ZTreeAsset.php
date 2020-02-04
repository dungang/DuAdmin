<?php

namespace app\kit\assets;

use yii\web\AssetBundle;

class ZTreeAsset extends AssetBundle
{
    public $baseUrl = '@web/third/zTree';

    public $css = [
        'css/metroStyle/metroStyle.css'
    ];

    public $js = [
        'js/jquery.ztree.all.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}