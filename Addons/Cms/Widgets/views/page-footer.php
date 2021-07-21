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
                    <h1><?= AppHelper::getSetting( 'site.name' ) ?></h1>
                    <p><?= AppHelper::getSetting( 'site.description' ) ?></p>
                    <?= date( 'Y' ) ?>
                    &copy; <?= Html::encode( Yii::t( 'app', AppHelper::getSetting( 'site.company' ) ) ) ?>
                    <?= AppHelper::powered() ?></p>
                    <p><?= Html::a( AppHelper::getSetting( 'site.beian' ), 'https://beian.miit.gov.cn' ) ?> </p>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="site-link">
                    <div class="row">
                        <?php if ( is_array( $tree ) ) : ?>
                            <?php foreach ( $tree as $link ) : ?>
                                <div class="col-sm-4">
                                    <div class="friend-links-box">
                                        <h4><?= $link[ 'name' ] ?></h4>
                                        <?php if ( isset( $link[ 'children' ] ) && is_array( $link[ 'children' ] ) ) : ?>
                                            <?php foreach ( $link[ 'children' ] as $child ) : ?>
                                                <div class="footer-link">
                                                    <?php if ( $child[ 'type' ] === 'url' ) : ?>
                                                        <?= Html::a( $child[ 'name' ], $child[ 'url' ], ['target' => '_blank'] ) ?>
                                                    <?php elseif ( $child[ 'type' ] === 'qrcode' ) : ?>
                                                        <div class="qrcode-box">
                                                            <div class="name"><?= $child[ 'name' ] ?></div>
                                                            <?= Html::img( $child[ 'pic' ], ['class' => 'qrcode'] ) ?>
                                                        </div>
                                                    <?php elseif ( $child[ 'type' ] === 'labelurl' ) : ?>
                                                        <?= $child[ 'name' ] ?>: <?= Html::a( $child[ 'url' ], $child[ 'url' ] ) ?>
                                                    <?php else : ?>
                                                        <?= $child[ 'name' ] ?>: <?= $child[ 'url' ] ?>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>