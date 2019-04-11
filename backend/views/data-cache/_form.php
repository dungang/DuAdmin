<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\kit\models\DataCache */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-cache-form">

    <?php $form = ActiveForm::begin(['id'=>'sys-data-cache-form"','enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cache_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cache_handler')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expired')->textInput() ?>

    <?= $form->field($model, 'intro')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> 保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
