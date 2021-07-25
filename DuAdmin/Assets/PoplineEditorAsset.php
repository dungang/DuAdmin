<?php


namespace DuAdmin\Assets;


class PoplineEditorAsset extends \yii\web\AssetBundle
{
    public $baseUrl = '@web/third/popline';

    public $js = [
        'scripts/jquery.popline.js',
        'scripts/plugins/jquery.popline.link.js',
        'scripts/plugins/jquery.popline.blockformat.js',
        'scripts/plugins/jquery.popline.blockquote.js',
        'scripts/plugins/jquery.popline.email.js',
        'scripts/plugins/jquery.popline.justify.js',
        'scripts/plugins/jquery.popline.decoration.js',
        'scripts/plugins/jquery.popline.list.js',
        'scripts/plugins/jquery.popline.backcolor.js',
    ];

    public $css = [
        'themes/default.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}