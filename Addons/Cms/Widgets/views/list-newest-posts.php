<?php

use Addons\Cms\Models\Post;
use yii\helpers\Html;

/* @var $models Post[] */
/* @var $model Post */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        最新更新
    </div>
    <div class="panel-body">
        <ul class="list-items">
            <?php foreach ( $models as $model ): ?>
                <li class="post-item">
                    <?= Html::a( $model->title, [ '/cms/post/show', 'id' => $model->id ] ) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>