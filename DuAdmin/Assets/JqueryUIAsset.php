<?php


namespace DuAdmin\Assets;


class JqueryUIAsset extends \yii\web\AssetBundle
{
    public $baseUrl = '@web/third/jquery-ui';

    public $js = [
        'jquery-ui.min.js'
    ];

    public $css = [
        'jquery-ui.min.css',
        'jquery-ui.structure.min.css',
        'jquery-ui.theme.min.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}