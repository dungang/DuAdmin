<?php

use app\addons\flash\helpers\FlashHelpers;
use app\addons\flash\models\FeFlash;
use app\kit\widgets\Swiper;
?>
<div style="margin-top:-20px;">
<?=Swiper::widget([
    'items'=> FeFlash::find()->orderBy('sort desc')->limit(5)->all(),
    'pagination'=>false,
    'slideContentCallback'=>function($item,$index){
        if($item['bg_color']) {
            return '<div style="width:100%;height:390px;'.FlashHelpers::gradient_radial().'"></div>';
        }
        return '<img src="'.$item['pic'].'" width="100%" style="display:block;max-height:390px;"/>';
    }
])?>
</div>