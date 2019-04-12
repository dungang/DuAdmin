<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\kit\models\EventHandler */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-handler-form">

    <?php $form = ActiveForm::begin(['id'=>'event-handler-form','enableAjaxValidation' => true]); ?>
    
    <?= $form->field($model, 'is_active')->checkbox() ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'handler')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'intro')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> 保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
