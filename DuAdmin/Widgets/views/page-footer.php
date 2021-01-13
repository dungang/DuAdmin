<?php

use DuAdmin\Helpers\AppHelper;
use yii\helpers\Html;

?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-5 col-sm-offset-1">
                <h1><?= AppHelper::getSetting('site.name') ?></h1>
                <p><?= AppHelper::getSetting('site.description') ?></p>
                <?= date('Y') ?> &copy; <?= Html::encode(Yii::t('app', AppHelper::getSetting('site.company'))) ?>
                <?= AppHelper::getSetting('site.beian') ?> <?= AppHelper::powered() ?></p>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="footer-link">
                            <?= Html::a(Yii::t('app', 'About Us'), ['/about-us'], ['target' => '_blank']) ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="footer-link">
                            <?= Html::a(Yii::t('app', 'Contact Us'), ['/contact-us'], ['target' => '_blank']) ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="footer-link">
                            <?= Html::a(Yii::t('app', 'Gitee'), 'https://gitee.com/dungang/DuAdmin', ['target' => '_blank']) ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="footer-link">
                            <?= Html::a(Yii::t('app', 'GitHub'), 'https://github.com/dungang/DuAdmin', ['target' => '_blank']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>