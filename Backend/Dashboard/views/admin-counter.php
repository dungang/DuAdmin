<?php
use yii\helpers\Html;
?>
<div class="small-box bg-aqua">
    <div class="inner">
        <h3><?= $count ?></h3>
        <p><?= Yii::t('app_admin', 'Admins') ?></p>
    </div>
    <div class="icon">
        <i class="fa  fa-user-secret"></i>
    </div>
    <?= Html::a(Yii::t('da', 'View') . ' <i class="fa fa-arrow-circle-right"></i>', ['/administrator/index'], ['class' => 'small-box-footer']) ?>
</div>