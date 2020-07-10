<?php
namespace app\themes\clothes\widgets;

use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle {

    public $sourcePath = '@app/themes/clothes/assets/dist';

    public $css = [
        'css/clothes.css'
    ];

    public $js = ['js/theme.js'];
}