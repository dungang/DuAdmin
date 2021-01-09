<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use DuAdmin\Models\Navigation;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\Navigation */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="navigation-form">

    <?php $form = ActiveForm::begin(['id'=>'navigation-form','enableAjaxValidation' => true,'action'=>$action]); ?>
    <div class="row">

    <?= '<div class="col-xs-6">' . $form->field($model, 'name')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'url')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'requireLogin')->dropDownList([ '不需要', '需要', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'isOuter')->dropDownList([ '内部地址', '外部地址', ]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'icon')->textInput(['maxlength' => true]) . '</div>' ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da','Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
