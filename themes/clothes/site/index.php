<?php

use app\addons\clothes\widgets\NewestClothes;
use app\addons\flash\widgets\Swiper;
use app\addons\required\widgets\RequiredFormShow;

$this->title = Yii::t('app', 'Home');
?>
<div style="margin-top:-20px;">
    <?= Swiper::widget() ?>
</div>

<div class="block-bar-gray">
    <div class="container">
        <h3><span class="h"><?= Yii::t('theme', 'Selected High Quality Suppliers') ?></span></h3>
        <div class="top-clothes">
            <div class="cate-tabs">
                <div class="tabs">
                    <div class="tab active">
                        <div class="clothes-icon tshirt"></div>
                        <div class="label">
                            T恤
                        </div>
                    </div>
                    <div class="tab">
                        <div class="clothes-icon thinhoodie"></div>
                        <div class="label">
                            薄卫衣
                        </div>
                    </div>
                    <div class="tab">
                        <div class="clothes-icon hoodie"></div>
                        <div class="label">
                            厚卫衣
                        </div>
                    </div>
                    <div class="tab">
                        <div class="clothes-icon skiwear"></div>
                        <div class="label">
                            冲锋衣
                        </div>
                    </div>
                </div>
                <div class="contents">
                    <div class="content">
                        <?= NewestClothes::widget([
                            'slug' => 'tshirt',
                            'render_callback' => function ($clothes_item) {
                                return $this->render('clothes-item', ['model' => $clothes_item]);
                            }
                        ]) ?>
                    </div>
                    <div class="content">
                        <?= NewestClothes::widget([
                            'slug' => 'thinhoodie',
                            'render_callback' => function ($clothes_item) {
                                return $this->render('clothes-item', ['model' => $clothes_item]);
                            }
                        ]) ?>
                    </div>
                    <div class="content">
                        <?= NewestClothes::widget([
                            'slug' => 'hoodie',
                            'render_callback' => function ($clothes_item) {
                                return $this->render('clothes-item', ['model' => $clothes_item]);
                            }
                        ]) ?>
                    </div>
                    <div class="content">
                        <?= NewestClothes::widget([
                            'slug' => 'skiwear',
                            'render_callback' => function ($clothes_item) {
                                return $this->render('clothes-item', ['model' => $clothes_item]);
                            }
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block-bar">
    <div class="container">
        <h3><span class="h"><?= Yii::t('theme', 'CONTACT US') ?></span></h3>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= RequiredFormShow::widget() ?>
            </div>
        </div>
    </div>
</div>