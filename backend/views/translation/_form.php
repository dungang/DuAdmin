<?php

use app\mmadmin\helpers\MAHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $source_message \app\backend\models\SourceMessage */
/* @var $messages app\backend\models\Message[] */

$form = ActiveForm::begin(['id' => 'translate-message-batch-form', 'enableAjaxValidation' => false]);
?>
<table id="batch-translate-message-form" class="table" data-index="<?= count($messages) ?>" data-target="tr">
    <tr>
        <th><?= Yii::t('ma', 'Language') ?></th>
        <th><?= Yii::t('ma', 'Translation') ?></th>
        <td></td>
    </tr>
    <?php foreach ($messages as $i => $message) : ?>
        <tr>
            <td><?= $form->field($message, "[$i]language")->dropDownList(MAHelper::getSettingAssoc('site.i18n'))->label(false) ?></td>
            <td><?= $form->field($message, "[$i]translation")->label(false) ?></td>
            <td width="90">
                <a href="javascript:void(0);" class="delete-self btn btn-sm btn-link"><i class="fa fa-trash text-danger"></i></a>
                <a href="javascript:void(0);" class="copy-self btn btn-sm btn-link"><i class="fa fa-plus"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="form-group">
    <?= Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('ma', 'Save'), ['class' => 'btn btn-success']) ?>
</div>
<?php
ActiveForm::end();
$this->registerJs("$('#batch-translate-message-form').dynamicline()");
?>