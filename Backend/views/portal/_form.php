<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Backend\Models\Portal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="portal-form">

    <?php $form = ActiveForm::begin(['id'=>'portal-form','enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_static')->checkbox() ?>

    <?= $form->field($model, 'unlimited')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> 保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
