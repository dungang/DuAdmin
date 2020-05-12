<?php

use app\addons\cms\widgets\ArticleShow;
use app\addons\flash\widgets\Swiper;
use app\addons\required\widgets\RequiredFormShow;

$this->title = Yii::t('app','Home');
?>
<div style="margin-top:-20px;">
    <?= Swiper::widget() ?>
</div>

<div class="block-bar-gray">
    <div class="container">
        <h3><?= Yii::t('theme','PRODUCTION')?></h3>
        <div class="row">
            <?= ArticleShow::widget([
                'slug' => 'product-center',
                'render_callback' => function ($product) {
                    return $this->render('product-item', ['model' => $product]);
                }
            ]) ?>
        </div>
    </div>
</div>
<div class="block-bar">
    <div class="container">
        <h3><?= Yii::t('theme','CONTACT US')?></h3>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= RequiredFormShow::widget() ?>
            </div>
        </div>
    </div>
</div>