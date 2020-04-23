<?php

use app\addons\flash\models\FeFlash;
use app\kit\widgets\Swiper;

echo Swiper::widget([
    'items'=> FeFlash::find()->orderBy('sort desc')->limit(5)->all(),
    'slideContentCallback'=>function($item,$index){
        return '<img src="'.$item['pic'].'" width="100%" height="400"/>';
    }
]);