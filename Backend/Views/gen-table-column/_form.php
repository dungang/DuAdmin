<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\GenTableColumn */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
?>
<div class="gen-table-column-form">

    <?php $form = ActiveForm::begin(['id'=>'gen-table-column-form','enableAjaxValidation' => true,'action'=>$action]); ?>
    <div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'tableId')->textInput() . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'field')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'comment')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'tips')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enableRequired')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enableList')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enableQuery')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enableSearch')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'sortable')->dropDownList([ 'desc' => '从大到小', 'asc' => '从小到大', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'widgetType')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'dictType')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'sort')->textInput() . '</div>' ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da','Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
