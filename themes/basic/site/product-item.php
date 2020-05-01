<?php

use yii\helpers\Html;
/* @var $model app\addons\cms\models\Article */
?>
<div class="col-sm-6 col-md-3">
    <div class="thumbnail">
        <?= Html::img($model->cover) ?>
        <div class="caption">
            <h3><?=Html::a($model->title,['/site/page','slug'=>$model->slug])?></h3>
        </div>
    </div>
</div>