<?php
use DuAdmin\Widgets\DefaultEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\PagePost */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
?>
<div class="page-post-form">

    <?php
    $form = ActiveForm::begin( [
        'id' => 'page-post-form',
        'enableAjaxValidation' => true,
        'action' => $action
    ] );
    ?>
    <div class="row">

        <?='<div class="col-xs-6">' . $form->field( $model, 'language' )->textInput( [ 'maxlength' => true,'disabled' => 'disabled'] ) . '</div>'?>

        <?='<div class="col-xs-6">' . $form->field( $model, 'title' )->textInput( [ 'maxlength' => true] ) . '</div>'?>

        <?='<div class="col-xs-12">' . $form->field( $model, 'content' )->widget( DefaultEditor::getEditorClass(), [ 'mode' => DefaultEditor::MODE_RICH] ) . '</div>'?>

    </div>
    <div class="form-group">
        <?=$form->field( $model, 'pageId' )->hiddenInput()->label( false )?>
        <?=Html::submitButton( '<i class="fa fa-save"></i> ' . Yii::t( 'da', 'Save' ), [ 'class' => 'btn btn-success'] )?>
        <?=Html::resetButton( '<i class="fa fa-reply"></i> ' . Yii::t( 'da', 'Reset' ), [ 'class' => 'btn btn-default'] )?>
    </div>

    <?php
    ActiveForm::end();
    ?>

</div>