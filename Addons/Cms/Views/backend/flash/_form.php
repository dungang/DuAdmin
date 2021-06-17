<?php

use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\AjaxFileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\Flash */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fe-flash-form">

    <?php $form = ActiveForm::begin(['id' => 'fe-flash-form', 'enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pic')->widget(AjaxFileInput::class, [
        'clip' => AppHelper::getSetting('cms.flash.clip', 'false'),
        'compress' => AppHelper::getSetting('cms.flash.compress', 'false'),
        'clipWidth' => AppHelper::getSetting('cms.flash.clipWidth'),
        'clipHeight' => AppHelper::getSetting('cms.flash.clipHeight'),
    ]) ?>

    <?= $form->field($model, 'bgColor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('da', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>