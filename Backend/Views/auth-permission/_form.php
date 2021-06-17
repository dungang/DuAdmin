<?php
use Backend\Models\AuthRule;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model Backend\Models\AuthPermission */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
?>
<div class="auth-permission-form">

    <?php
    $form = ActiveForm::begin( [
        'id' => 'auth-permission-form',
        'enableAjaxValidation' => true,
        'action' => $action
    ] );
    ?>
    <div class="row">
        <?='<div class="col-xs-6">' . $form->field( $model, 'id' )->textInput( [ 'maxlength' => true] ) . '</div>'?>

        <?='<div class="col-xs-6">' . $form->field( $model, 'pid' )->textInput( [ 'maxlength' => true] ) . '</div>'?>

        <?='<div class="col-xs-6">' . $form->field( $model, 'name' )->textInput( [ 'maxlength' => true] ) . '</div>'?>

        <?='<div class="col-xs-6">' . $form->field( $model, 'ruleId' )->dropDownList( AuthRule::allIdToName() ) . '</div>'?>

    </div>
    <div class="form-group text-right">
        <?=Html::resetButton( '<i class="fa fa-reply"></i> ' . Yii::t( 'da', 'Reset' ), [ 'class' => 'btn btn-default'] )?>
        <?=Html::submitButton( '<i class="fa fa-save"></i> ' . Yii::t( 'da', 'Save' ), [ 'class' => 'btn btn-success'] )?>
    </div>

    <?php
    ActiveForm::end();
    ?>

</div>