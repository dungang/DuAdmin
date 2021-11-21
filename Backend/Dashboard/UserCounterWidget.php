<?php

namespace Backend\Dashboard;

use Frontend\Models\User;
use yii\base\Widget;

class UserCounterWidget extends Widget
{

    public function run()
    {

        $count = User::find()->count();
        return $this->render('user-counter', [
            'count' => $count
        ]);
    }
}
