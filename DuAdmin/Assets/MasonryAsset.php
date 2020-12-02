<?php
namespace DuAdmin\Assets;

use yii\web\AssetBundle;

/**
 *
 * @author dungang
 */
class MasonryAsset extends AssetBundle
{
    public $baseUrl = '@web';
    
    public $js = [
        'js/masonry.pkgd.min.js'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

