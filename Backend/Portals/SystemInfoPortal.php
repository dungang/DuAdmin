<?php

namespace Backend\Portals;

use yii\base\Widget;

class SystemInfoPortal extends Widget
{
    public function run(){
        return $this->render('system-info');
    }
}