<?php

use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $prevModel \Addons\Cms\Models\Post */
/* @var $nextModel \Addons\Cms\Models\Post */
?>

<nav aria-label="...">
    <ul class="pager cms-pager">
        <?php if ($prevModel) : ?>
            <li class="previous">
                <?= Html::a('<span aria-hidden="true">&larr;</span> '  . \Yii::t('da', 'Previous Post'), ['show', 'id' => $prevModel['id']]) ?>
            </li>
        <?php else : ?>
            <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> <?= \Yii::t('da', 'No More') ?></a></li>
        <?php endif; ?>
        <?php if ($nextModel) : ?>
            <li class="next">
                <?= Html::a('<span aria-hidden="true">&rarr;</span> ' . \Yii::t('da', 'Next Post'), ['show', 'id' => $nextModel['id']]) ?>
            </li>
        <?php else : ?>
            <li class="next disabled"><a href="#"><span aria-hidden="true">&rarr;</span> <?= \Yii::t('da', 'No More') ?></a></li>
        <?php endif; ?>
    </ul>
</nav>