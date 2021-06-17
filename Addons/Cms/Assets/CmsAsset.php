<?php
namespace Addons\Cms\Assets;

use yii\web\AssetBundle;

class CmsAsset extends AssetBundle {
    public $sourcePath =  '@Addons/Cms/resource/assets/dist';

    public $css = [
        'css/cms.css',
    ];

    public $depends = [
        'Frontend\Assets\AppAsset',
    ];
}