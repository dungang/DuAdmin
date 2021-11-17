<?php
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="clearfix">
    <div class="pull-left" style="margin-right:15px;">
        <?= Html::a(
            "<i class='fa fa-plus'></i> " . $addButtonLabel,
            $addButtonRoute,
            [
                'class'            => 'btn btn-success btn-sm',
                'data-pjax-target' => $pjaxId,
                'create-form'      => true,
            ]
        ) ?>
    </div>
    <div class="pull-left"><select class="form-control" style="width:<?= $selectWidth ?>;"></select></div>
</div>
<?= $input . Pjax::widget(['id' => $pjaxId, 'enablePushState' => false]); ?>