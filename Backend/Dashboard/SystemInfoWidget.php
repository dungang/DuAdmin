<?php

namespace Backend\Dashboard;

use yii\base\Widget;

class SystemInfoWidget extends Widget
{
    public function run()
    {
        return $this->render('system-info');
    }
}
