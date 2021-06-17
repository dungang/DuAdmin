<?php

use yii\helpers\Html;
/* @var $model Addons\Cms\Models\Post */
?>
<div class="col-xs-6 col-sm-6 col-md-4">
    <div class="thumbnail cms-thumbnail">
        <?= Html::a(Html::img(empty($model['cover']) ? 'images/nopic.png' : $model['cover']), ['/cms/post/show', 'id' => $model['id']]) ?>
        <div class="caption">
            <h5 class="text-center"><?= Html::a($model['title'], ['/cms/post/show', 'id' => $model['id']]) ?></h5>
        </div>
    </div>
</div>