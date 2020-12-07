<?php
namespace DuAdmin\Assets;

use yii\web\AssetBundle;
/**
 * https://github.com/naoxink/notifIt
 * @author dungang<dungang@126.com>
 * @since 2020年12月7日
 */
class NotifyAsset extends AssetBundle
{

    public $baseUrl = '@web/third/notifIt';

    public $js = [
        'js/notifIt.min.js'
    ];

    public $css = [
        'css/notifIt.min.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

