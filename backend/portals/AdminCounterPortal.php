<?php

namespace app\backend\portals;

use yii\base\Widget;
use app\backend\models\Admin;

class AdminCounterPortal extends Widget
{
    public function run()
    {
        $count = Admin::find()->count();
        return $this->render('admin-counter',[
            'count' => $count,
        ]);
    }

}