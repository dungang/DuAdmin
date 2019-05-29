<?php
use yii\helpers\Html;
?>
<div class="col-lg-3 col-xs-6">
    <div class="small-box bg-aqua">
        <div class="inner">
            <h3><?= $count ?></h3>
            <p>管理员</p>
        </div>
        <div class="icon">
            <i class="fa  fa-user-secret"></i>
        </div>
        <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['/backend/admin/index'],['class'=>'small-box-footer']) ?>
    </div>
</div>