<?php

use yii\helpers\Html;
?>
<div class="small-box bg-yellow">
    <div class="inner">
        <h3><?= $count ?></h3>
        <p><?= Yii::t('app_admin', 'Users') ?></p>
    </div>
    <div class="icon">
        <i class="fa  fa-user"></i>
    </div>
    <?= Html::a(Yii::t('da', 'View') . ' <i class="fa fa-arrow-circle-right"></i>', ['/user/index'], ['class' => 'small-box-footer']) ?>
</div>