<?php

namespace DuAdmin\Widgets;

use DuAdmin\Assets\LayerAsset;
use yii\base\Widget;
use yii\helpers\Json;

class Notify extends Widget
{
  public $timeout = 5000;
  // success, error, warning, info
  public $alertTypes = [
    'error' => 2,
    'danger' => 2,
    'exception' => 5,
    'fail' => 5,
    'success' => 1,
    'info' => 3,
    'warning' => 4
  ];

  public function run()
  {

    LayerAsset::register($this->view);
    $session = \Yii::$app->session;
    $flashes = $session->getAllFlashes();
    foreach ($flashes as $type => $flash) {
      if (isset($this->alertTypes[$type]) && $type = $this->alertTypes[$type]) {
        foreach (array_values((array) $flash) as $message) {
          $this->renderNotify($type, $message);
        }
      }
      $session->removeFlash($type);
    }
  }

  public function renderNotify($type, $msg)
  {

    $options = [
      'icon' => $type,
      'time' => $this->timeout
    ];
    $js = "layer.msg('" . $msg . "', " . Json::htmlEncode($options) . ");";
    $this->view->registerJs($js);
  }
}
