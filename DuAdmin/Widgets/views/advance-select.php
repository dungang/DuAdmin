<?php

use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\SimpleModal;
use yii\bootstrap\Html;
use yii\web\JsExpression;

?>
<div role="advance-select">
    <div class="clearfix">
        <div class="pull-left" style="margin-right:15px;">
            <?= AppHelper::linkButtonWithSimpleModal(
                "<i class='fa fa-plus'></i> 添加",
                ['/copyright/cr-owner/create'],
                [
                    'class' => 'btn btn-success',
                    'data-pjax-target' => 'test-pajx-container',
                    'data-target' => '#advance-select-modal-dialog'
                ]
            ) ?>
        </div>
        <div class="pull-left"><?= Html::dropDownList('name', null, ['是', '否'], ['class' => 'form-control']) ?></div>
    </div>
    <?= $input ?>
    <div id="test-pajx-container" data-pjax-container="" data-pjax-timeout="1000">
    </div>
    <?php
    SimpleModal::begin([
        'header' => '对话框',
        'customHandleResult' => new JsExpression("function(data){
            var input = $('#${id}');
            var val = input.val();
            ids = val.split(',');
            ids.push(data.redirectUrl.id);
            input.val(ids.join(','));
            input.parent('[role=advance-select]').advanceSelect('handleInputChange')
        }"),
        'options' => [
            'id' => 'advance-select-modal-dialog',
            'data-backdrop' => 'static',
            'data-keyboard' => 'false',
        ]
    ]);
    echo "加载中 ... ";
    SimpleModal::end();
    ?>
</div>