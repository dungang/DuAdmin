<?php
namespace app\mmadmin\assets;

use yii\web\AssetBundle;

/**
 *
 * @author dungang
 */
class LazyLoadAsset extends AssetBundle
{

    public $baseUrl = '@web/js';

    public $js = [
        'jquery.lazyload.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

