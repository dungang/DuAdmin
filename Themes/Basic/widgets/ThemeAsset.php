<?php

namespace app\Themes\Basic\widgets;

use Frontend\Assets\AppAsset;
use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle {

  public $sourcePath = '@app/Themes/Basic/assets/dist/css';

  public $css = [
      'basic.css'
  ];

  public $depends = [
      AppAsset::class
  ];
}