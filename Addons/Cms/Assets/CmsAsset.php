<?php

namespace Addons\Cms\Assets;

use yii\web\AssetBundle;

class CmsAsset extends AssetBundle
{

    public $sourcePath = '@Addons/Cms/Resource/dist';

    public $css = [
        'css/cms.css'
    ];

    public $depends = [
        'Frontend\Assets\AppAsset'
    ];

    public $publishOptions = [
        'publishDir' => 'cms'
    ];
}