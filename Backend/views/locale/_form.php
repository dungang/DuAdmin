<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Backend\Models\SourceMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="source-message-form">

    <?php $form = ActiveForm::begin(['id'=>'source-message-form','enableAjaxValidation' => true]); ?>
    <div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'category')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'message')->textarea(['rows' => 6]) . '</div>' ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da','Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
