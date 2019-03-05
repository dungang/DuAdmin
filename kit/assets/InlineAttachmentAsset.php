<?php
namespace app\kit\assets;

use yii\web\AssetBundle;

class InlineAttachmentAsset extends AssetBundle
{

    public $baseUrl = '@web/inline-attachment/';

    public $js = [
        // 'inline-attachment.js',
        'jquery.inline-attachment.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

