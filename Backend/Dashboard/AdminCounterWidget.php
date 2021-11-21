<?php

namespace Backend\Dashboard;

use Backend\Models\Admin;
use yii\base\Widget;

class AdminCounterWidget extends Widget {

  public function run() {

    $count = Admin::find()->count();
    return $this->render( 'admin-counter', [
        'count' => $count ] );

  }
}