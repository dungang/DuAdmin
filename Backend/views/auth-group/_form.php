<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Backend\Models\AuthGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-group-form">

    <?php $form = ActiveForm::begin(['id'=>'auth-group-form','enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'type')->radioList(['1'=>'角色','2'=>'权限']) ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> 保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
