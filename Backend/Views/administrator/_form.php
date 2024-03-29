<?php
use DuAdmin\Widgets\AjaxFileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model Backend\Models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php

$form = ActiveForm::begin( [
        'id' => 'admin-form',
        'enableAjaxValidation' => true
    ] );
    ?>
    <div class="row">
		<div class="col-md-6">

            <?=$form->field( $model, 'username' )->textInput( [ 'maxlength' => true] )?>

            <?=$form->field( $model, 'nickname' )->textInput( [ 'maxlength' => true] )?>

            <?=$form->field( $model, 'password' )->textInput( [ 'maxlength' => true] )?>

            <?=$form->field( $model, 'avatar' )->widget( AjaxFileInput::class )?>

        </div>
		<div class="col-md-6">

            <?=$form->field( $model, 'email' )->textInput( [ 'maxlength' => true] )?>

            <?=$form->field( $model, 'mobile' )->textInput( [ 'maxlength' => true] )?>

            <?=$form->field( $model, 'status' )->dropDownList( [ 0 => Yii::t( 'app_admin', 'Unactive' ),10 => Yii::t( 'app_admin', 'Active' )] )?>

            <div class="form-group text-right">
                <?=Html::submitButton( '<i class="fa fa-save"></i> ' . Yii::t( 'da', 'Save' ), [ 'class' => 'btn btn-success'] )?>
            </div>
		</div>
	</div>

    <?php

ActiveForm::end();
    ?>

</div>