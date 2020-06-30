<?php

use yii\helpers\Html;
/* @var $model app\addons\cms\vo\ArticleContent */
?>
<div class="col-xs-6 col-sm-6 col-md-3">
    <div class="thumbnail">
        <div class="img-aspect-11">
          <?= Html::img(empty($model['cover'])?'images/nopic.png':$model['cover']) ?>
        </div>
        <div class="caption">
            <h3><?=Html::a($model['title'],['/site/page','slug'=>$model['slug']])?></h3>
        </div>
    </div>
</div>