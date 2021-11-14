<?php

use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\SimpleModal;
use yii\web\JsExpression;
use yii\widgets\Pjax;

?>
<div role="advance-select">
    <div class="clearfix">
        <div class="pull-left" style="margin-right:15px;">
            <?= AppHelper::linkButtonWithSimpleModal(
                "<i class='fa fa-plus'></i> " . $addButtonLabel,
                $addButtonRoute,
                [
                    'class'            => 'btn btn-success',
                    'data-pjax-target' => $pjaxId,
                    'data-target'      => '#' . $id . '-modal-dialog'
                ]
            ) ?>
        </div>
        <div class="pull-left"><select class="form-control" style="width:<?= $selectWidth ?>;"></select></div>
    </div>
    <?php echo  $input;
    echo Pjax::widget(['id' => $pjaxId, 'enablePushState' => false]);
    SimpleModal::begin([
        'header' => '对话框',
        'customHandleResult' => new JsExpression("function(data){
            var input = $('#${id}');
            var val = input.val();
            var ids = val.trim().split(',').filter((id) => { return !!id });
            ids.push(data.redirectUrl.id);
            input.val(ids.join(','));
            input.parent('[role=advance-select]')
                .advanceSelect('handleInputChange')
                //.advanceSelect('handleLoadSelectOptions');
        }"),
        'options' => [
            'id' => $id . '-modal-dialog',
            'data-backdrop' => 'static',
            'data-keyboard' => 'false',
        ]
    ]);
    echo "加载中 ... ";
    SimpleModal::end();
    ?>
</div>