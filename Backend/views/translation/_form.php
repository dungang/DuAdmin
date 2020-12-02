<?php

use DuAdmin\Helpers\AppHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $source_message Backend\Models\SourceMessage */
/* @var $messages Backend\Models\Message[] */

$form = ActiveForm::begin(['id' => 'translate-message-batch-form', 'enableAjaxValidation' => false]);
?>
<table id="batch-translate-message-form" class="table" data-index="<?= count($messages) ?>" data-target="tr">
    <tr>
        <th><?= Yii::t('da', 'Language') ?></th>
        <th><?= Yii::t('da', 'Translation') ?></th>
        <td></td>
    </tr>
    <?php foreach ($messages as $i => $message) : ?>
        <tr>
            <td><?= $form->field($message, "[$i]language")->dropDownList(AppHelper::getSettingAssoc('site.i18n'))->label(false) ?></td>
            <td><?= $form->field($message, "[$i]translation")->label(false) ?></td>
            <td width="90">
                <a href="javascript:void(0);" class="delete-self btn btn-sm btn-link"><i class="fa fa-trash text-danger"></i></a>
                <a href="javascript:void(0);" class="copy-self btn btn-sm btn-link"><i class="fa fa-plus"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="form-group">
    <?= Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('da', 'Save'), ['class' => 'btn btn-success']) ?>
</div>
<?php
ActiveForm::end();
$this->registerJs("$('#batch-translate-message-form').dynamicline()");
?>