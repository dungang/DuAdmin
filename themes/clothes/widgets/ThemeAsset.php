<?php
namespace app\themes\clothes\widgets;

use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle {

    public $sourcePath = '@app/themes/clothes/assets/dist/css';

    public $css = [
        'theme.css'
    ];
}