<?php

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
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="title">
                            用户
                        </div>
                    </div>
                    <div class="tab">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="title">
                            用户
                        </div>
                    </div>
                    <div class="tab">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="title">
                            用户
                        </div>
                    </div>
                    <div class="tab">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="title">
                            用户
                        </div>
                    </div>
                    <div class="tab">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="title">
                            用户
                        </div>
                    </div>
                    <div class="tab">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="title">
                            用户
                        </div>
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