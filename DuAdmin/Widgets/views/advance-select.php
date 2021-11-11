<?php

use DuAdmin\Helpers\AppHelper;
use yii\bootstrap\Html;

?>
<div>
    <div class="clearfix">
        <div class="pull-left" style="margin-right:15px;"><?= AppHelper::linkButtonWithSimpleModal("<i class='fa fa-plus'></i> 添加", ['create'],['class'=>'btn btn-success']) ?></div>
        <div class="pull-left"><?= Html::dropDownList('name', null, ['是', '否'],['class'=>'form-control']) ?></div>
    </div>
    <?= $content ?>
</div>