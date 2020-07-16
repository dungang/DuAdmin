<?php
namespace app\themes\basic\widgets;

use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle {

    public $sourcePath = '@app/themes/basic/assets/dist/css';

    public $css = [
        'basic.css'
    ];
}