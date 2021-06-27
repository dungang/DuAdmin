<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\GenTable */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
?>
<div class="gen-table-form">

    <?php $form = ActiveForm::begin(['id'=>'gen-table-form','enableAjaxValidation' => true,'action'=>$action]); ?>
    <div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'tableName')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'tableComment')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'modelNamespace')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'modelName')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'modelBaseName')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'activeQueryBaseName')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'dbConnectionId')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enableSearchModel')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enableI18n')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'backendControllerNamespace')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'frontendControllerNamespace')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'apiControllerNamespace')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'backendControllerBase')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'frontendControllerBase')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'apiControllerBase')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'controllerName')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'backendViewPath')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'frontendViewPath')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'backendListView')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'frontendistView')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'backendActions')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'frontendActions')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'modalDailogSize')->dropDownList([ 'def' => '默认窗口', 'sm' => '小窗口', 'lg' => '大窗口', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enableUserData')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'enablePjax')->dropDownList([ '否', '是', ], ['prompt' => '']) . '</div>' ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da','Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
