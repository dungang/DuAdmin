<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\PrettyUrl */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
?>
<div class="pretty-url-form">

    <?php $form = ActiveForm::begin(['id'=>'pretty-url-form','enableAjaxValidation' => true,'action'=>$action]); ?>
    <div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'name')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'express')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'weight')->textInput() . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'route')->textInput(['maxlength' => true]) . '</div>' ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da','Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
