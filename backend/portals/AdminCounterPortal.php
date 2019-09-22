<?php

namespace app\backend\portals;

use yii\base\Widget;
use app\kit\models\User;

class AdminCounterPortal extends Widget
{
    public function run()
    {
        $count = User::find()->where(['is_admin'=>1])->count();
        return $this->render('admin-counter',[
            'count' => $count,
        ]);
    }

}