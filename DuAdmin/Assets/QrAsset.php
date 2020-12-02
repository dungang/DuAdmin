<?php
namespace DuAdmin\Assets;

use yii\web\AssetBundle;

/**
 *
 * @author dungang
 */
class QrAsset extends AssetBundle
{

    public $baseUrl = '@web/js';

    public $js = [
        'jquery.qrcode.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}

