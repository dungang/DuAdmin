<?php
namespace app\mmadmin\assets;

use yii\web\AssetBundle;

class InlineAttachmentAsset extends AssetBundle
{

    public $baseUrl = '@web/third/inline-attachment/';

    public $js = [
        // 'inline-attachment.js',
        'jquery.inline-attachment.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

