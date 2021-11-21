<?php

use yii\helpers\Html;
?>
<div class="small-box bg-yellow">
    <div class="inner">
        <h3><?= $count ?></h3>
        <p>发布的单页</p>
    </div>
    <div class="icon">
        <i class="fa  fa-globe"></i>
    </div>
    <?= Html::a('查看 <i class="fa fa-arrow-circle-right"></i>', ['/cms/page/index'], ['class' => 'small-box-footer']) ?>
</div>