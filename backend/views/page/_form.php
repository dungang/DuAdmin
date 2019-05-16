<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\kit\models\Page;
use app\kit\widgets\DefaultEditor;

/* @var $this yii\web\View */
/* @var $model app\kit\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(['id'=>'sys-page-form','enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pid')->dropDownList(Page::getMapWidthDep(),['prompt'=>''])?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
    echo $form->field($model, 'content')->widget(DefaultEditor::getEditorClass(),['mode'=>DefaultEditor::MODE_RICH])?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> 保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
