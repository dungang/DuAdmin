<?php

use yii\helpers\Html;
?>
<div class="small-box bg-green">
    <div class="inner">
        <h3><?= $count ?></h3>
        <p>文章</p>
    </div>
    <div class="icon">
        <i class="fa  fa-file-text-o"></i>
    </div>
    <?= Html::a('查看 <i class="fa fa-arrow-circle-right"></i>', ['/cms/post/index'], ['class' => 'small-box-footer']) ?>
</div>