<?php

use app\addons\flash\models\FeFlash;
use app\kit\widgets\Swiper;
?>
<div style="margin-top:-20px;">
<?=Swiper::widget([
    'items'=> FeFlash::find()->orderBy('sort desc')->limit(5)->all(),
    'pagination'=>false,
    'slideContentCallback'=>function($item,$index){
        return '<img src="'.$item['pic'].'" width="100%" style="display:block;max-height:390px;"/>';
    }
])?>
</div>