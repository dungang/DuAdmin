<?php

use yii\helpers\Html;
?>
<div class="small-box bg-red">
    <div class="inner">
        <h3><?= $count ?></h3>
        <p><?= Yii::t('app_admin', 'Addons') ?></p>
    </div>
    <div class="icon">
        <i class="fa  fa-cubes"></i>
    </div>
    <?= Html::a(Yii::t('da', 'View') . ' <i class="fa fa-arrow-circle-right"></i>', ['/addon/index'], ['class' => 'small-box-footer']) ?>
</div>