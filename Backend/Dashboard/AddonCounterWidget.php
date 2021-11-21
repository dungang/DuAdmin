<?php

namespace Backend\Dashboard;

use Yii;
use yii\base\Widget;

class AddonCounterWidget extends Widget
{

    public function run()
    {
        $addons = require  Yii::$app->basePath . '/Config/installed-addons.php';
        return $this->render('addon-counter', [
            'count' => count($addons)
        ]);
    }
}
