<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use DuAdmin\Widgets\DefaultEditor;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\MailTemplate */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
?>
<div class="mail-template-form">

    <?php $form = ActiveForm::begin(['id'=>'mail-template-form','enableAjaxValidation' => false,'action'=>$action]); ?>
    <div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'code')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'title')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-12">' . $form->field($model, 'varsInfo')->textarea(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-12">' . $form->field($model, 'content')->widget(DefaultEditor::getEditorClass(),['mode' => DefaultEditor::MODE_RICH]) . '</div>' ?>


    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da','Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
