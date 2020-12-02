<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Backend\Models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(['id'=>'message-form','enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'translation')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da','Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
