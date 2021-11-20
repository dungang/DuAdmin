<?php

use yii\helpers\Html;
/* @var Addons\Cms\Models\Flash[] $models */
/* @var Addons\Cms\Models\Flash $model */
?>
<div class="<?= $widget->className ?>">
  <?php
  foreach ($models as $model) :
  ?>
    <div class="<?= $widget->slideClassName ?>"><?= Html::img($model['pic']) ?></div>
  <?php
  endforeach;
  ?>
</div>