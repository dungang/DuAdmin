<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\mmadmin\models\UserExtProperty */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-ext-property-form">

    <?php $form = ActiveForm::begin(['id'=>'user-ext-property-form','enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'field')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_length')->textInput() ?>

    <?= $form->field($model, 'hint')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_required')->checkbox() ?>

    <?= $form->field($model, 'input_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'input_value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> 保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
