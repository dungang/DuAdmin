<?php

namespace app\backend\portals;

use yii\base\Widget;

class SystemInfoPortal extends Widget
{
    public function run(){
        return $this->render('system-info');
    }
}