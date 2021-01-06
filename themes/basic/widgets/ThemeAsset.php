<?php
namespace app\themes\basic\widgets;

use yii\web\AssetBundle;
use Frontend\Assets\AppAsset;

class ThemeAsset extends AssetBundle {

    public $sourcePath = '@app/themes/basic/assets/dist/css';

    public $css = [
        'basic.css'
    ];
    
    public $depends = [
        AppAsset::class
    ];
}