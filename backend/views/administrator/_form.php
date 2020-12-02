<?php

use DuAdmin\Widgets\JcropFileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Backend\Models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php $form = ActiveForm::begin(['id' => 'admin-form', 'enableAjaxValidation' => true]); ?>
    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

            <?php
            echo $form->field($model, 'avatar')->widget(JcropFileInput::className(), [
                'cropInput' => '#crop',
                'preview_h' => '200',
                'preview_w' => '200',
                'clientOptions' => [
                    'setSelect' => [
                        100,
                        100,
                        300,
                        300
                    ],
                    'aspectRatio' => 1
                    //'allowResize'=>false
                ]
            ]) ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'status')->dropDownList([0 => Yii::t('backend', 'Unactive'), 10 => Yii::t('backend', 'Active')]) ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('ma', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>