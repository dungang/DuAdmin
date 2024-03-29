<?php

use DuAdmin\Helpers\AppHelper;
use yii\helpers\Html;

?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="site-info">
                    <h1><?= AppHelper::getSetting('site.name') ?></h1>
                    <p><?= AppHelper::getSetting('site.description') ?></p>
                    <?= date('Y') ?>
                    &copy; <?= Html::encode(Yii::t('app', AppHelper::getSetting('site.company'))) ?>
                    <?= AppHelper::powered() ?></p>
                    <p><?= Html::a(AppHelper::getSetting('site.beian'), 'https://beian.miit.gov.cn') ?> </p>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="site-link">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="friend-links-box">
                                <h4>联系我们</h4>
                                <div class="footer-link">
                                    商务合作: <?= AppHelper::getSetting('site.phone'); ?>
                                </div>
                                <div class="footer-link">
                                    意见反馈: <?= AppHelper::getSetting('site.email'); ?>
                                </div>
                                <div class="footer-link">
                                    <div class="qrcode-box">
                                        <div class="name">微信</div>
                                        <?= Html::img(AppHelper::getSetting('site.qr'), ['class' => 'qrcode']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="friend-links-box">
                                <h4>服务条款</h4>
                                <div class="footer-link">
                                    <?= Html::a(Yii::t('app', 'About Us'), ['/about-us'], ['target' => '_blank']) ?>
                                </div>
                                <div class="footer-link">
                                    <?= Html::a(Yii::t('app', 'Contact Us'), ['/contact-us'], ['target' => '_blank']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="friend-links-box">
                                <h4>友情连接</h4>
                                <div class="footer-link">
                                    <?= Html::a(Yii::t('app', 'Gitee'), 'https://gitee.com/dungang/DuAdmin', ['target' => '_blank']) ?>
                                </div>
                                <div class="footer-link">
                                    <?= Html::a(Yii::t('app', 'GitHub'), 'https://github.com/dungang/DuAdmin', ['target' => '_blank']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>