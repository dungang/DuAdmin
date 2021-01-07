<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use DuAdmin\Widgets\DatePicker;
use DuAdmin\Models\PageBlock;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\PageBlockData */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
?>
<div class="page-block-data-form">

    <?php $form = ActiveForm::begin(['id'=>'page-block-data-form','enableAjaxValidation' => true,'action'=>$action]); ?>
    <div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'blockId')->dropDownList(PageBlock::allIdToName()) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'title')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'intro')->textarea() . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'url')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'isOuterUrl')->dropDownList([ 1 => '是', 0 => '否', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'urlText')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'filter')->textarea(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'size')->textInput() . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'orderBy')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'style')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'options')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enableCache')->dropDownList([ 1 => '是', 0 => '否', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'expiredAt')->widget(DatePicker::class) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'sort')->textInput() . '</div>' ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da','Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
