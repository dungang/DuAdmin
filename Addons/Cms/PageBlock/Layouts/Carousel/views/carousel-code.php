<?php

use Addons\Cms\Models\Flash;
use yii\helpers\Html;

/* @var Addons\Cms\Models\Flash[] $models */
/* @var Addons\Cms\Models\Flash $model */
$models = Flash::find()->getCarouselLimited( $this->context->params[ 'size' ] );
?>
<div class="swiper-container">
    <?php if ( !empty( $models ) ): ?>
        <?php foreach ( $models as $model ): ?>
            <div class="swiper-slide"><?= Html::img( $model->pic, ['alt' => $model->name, 'class' => 'lazyload'] ) ?></div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="swiper-slide"><?= Html::img( "/images/computer.jpg", ['alt' => 'demo', 'class' => 'lazyload'] ) ?></div>
    <?php endif; ?>
</div>