<?php

use DuAdmin\Helpers\AppHelper;
use yii\helpers\Html;
/* @var $tree array */
?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="site-info">
                    <h1><?= AppHelper::getSetting('site.name') ?></h1>
                    <p><?= AppHelper::getSetting('site.description') ?></p>
                    <?= date('Y') ?> &copy; <?= Html::encode(Yii::t('app', AppHelper::getSetting('site.company'))) ?>
                    <?= AppHelper::getSetting('site.beian') ?> <?= AppHelper::powered() ?></p>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="site-link">
                    <div class="row">
                        <div class="col-sm-4">
                            <h4>联系我们</h4>
                            <div class="footer-link">
                                商务合作: <?= AppHelper::getSetting('site.phone'); ?>
                            </div>
                            <div class="footer-link">
                                意见反馈: <?= AppHelper::getSetting('site.email'); ?>
                            </div>
                        </div>
                        <?php if (is_array($tree)) : ?>
                        <?php foreach ($tree as $link) : ?>
                        <div class="col-sm-4">
                            <h4><?= $link['name'] ?></h4>
                            <?php if (isset($link['children']) && is_array($link['children'])) : ?>
                            <?php foreach ($link['children'] as $child) : ?>
                            <div class="footer-link">
                                <?= Html::a($child['name'], $child['url'], ['target' => '_blank']) ?>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>