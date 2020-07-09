<?php

use yii\helpers\Html;
/* @var $model app\addons\clothes\models\YfClothes */
?>
<div class="col-xs-6 col-sm-6 col-md-3">
    <div class="thumbnail">
        <div class="img-aspect-11">
          <?= Html::img(empty($model['main_pic'])?'images/nopic.png':$model['main_pic']) ?>
        </div>
        <div class="caption">
            <h3><?=Html::a($model['title'],['/clothes/product/info','id'=>$model['id']])?></h3>
        </div>
    </div>
</div>