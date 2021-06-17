<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model Backend\Models\Portal */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
?>
<div class="portal-form">

    <?php

$form = ActiveForm::begin( [
        'id' => 'portal-form',
        'enableAjaxValidation' => true,
        'action' => $action
    ] );
    ?>
    <div class="row">
    <?='<div class="col-xs-6">' . $form->field( $model, 'name' )->textInput( [ 'maxlength' => true] ) . '</div>'?>

    <?='<div class="col-xs-6">' . $form->field( $model, 'code' )->textInput( [ 'maxlength' => true] ) . '</div>'?>

    <?='<div class="col-xs-6">' . $form->field( $model, 'source' )->textInput( [ 'maxlength' => true] ) . '</div>'?>

    <?='<div class="col-xs-6">' . $form->field( $model, 'unlimited' )->textInput() . '</div>'?>

    </div>
    <div class="form-group text-right">
        <?=Html::resetButton( '<i class="fa fa-reply"></i> ' . Yii::t( 'da', 'Reset' ), [ 'class' => 'btn btn-default'] )?>
        <?=Html::submitButton( '<i class="fa fa-save"></i> ' . Yii::t( 'da', 'Save' ), [ 'class' => 'btn btn-success'] )?>
    </div>

    <?php

ActiveForm::end();
    ?>

</div>
