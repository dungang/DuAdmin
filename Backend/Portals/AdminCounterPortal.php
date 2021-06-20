<?php

namespace Backend\Portals;

use Backend\Models\Admin;
use yii\base\Widget;

class AdminCounterPortal extends Widget {

  public function run() {

    $count = Admin::find()->count();
    return $this->render( 'admin-counter', [
        'count' => $count ] );

  }
}