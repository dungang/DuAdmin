<?php
namespace app\kit\assets;

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

