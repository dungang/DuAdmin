<?php

namespace app\backend\portals;

use yii\base\Widget;
use app\backend\assets\LunarAsset;

class Lunar extends Widget
{
    public function run(){
        LunarAsset::register($this->view);
        return $this->render('lunar');
    }

}