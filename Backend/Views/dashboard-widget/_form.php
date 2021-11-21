<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\DashboardWidget */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
?>
<div class="dashboard-widget-form">

    <?php $form = ActiveForm::begin(['id'=>'dashboard-widget-form','enableAjaxValidation' => false,'action'=>$action]); ?>
    <div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'name')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'widget')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'args')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'argsInfo')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'status')->textInput() . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'sort')->textInput() . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'type')->textInput(['maxlength' => true]) . '</div>' ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da','Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
