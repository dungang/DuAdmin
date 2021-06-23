<?php

namespace DuAdmin\Assets;

use yii\web\AssetBundle;

class DuAdminAsset extends AssetBundle {

  public $baseUrl = '@web';

  public $css = [
      'third/font-awesome/css/font-awesome.min.css',
      'duadmin/dist/css/DUAdmin.css'
  ];

  public $js = [
      'js/jquery.form.min.js',
      'js/holder.min.js',
      'duadmin/dist/js/DUAdmin.js'
  ];

  public $depends = [
      '\yii\web\YiiAsset',
      '\yii\bootstrap\BootstrapPluginAsset',
      '\yii\validators\ValidationAsset',
      '\yii\widgets\ActiveFormAsset',
      '\DuAdmin\Assets\GoogleFontsSourceSansProAsset',
      '\DuAdmin\Assets\NotifyAsset'
  ];
}

