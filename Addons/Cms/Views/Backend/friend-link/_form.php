<?php

use Addons\Cms\Models\FriendLink;
use DuAdmin\Widgets\AjaxFileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\FriendLink */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
?>
<div class="friend-link-form">

    <?php
    $form = ActiveForm::begin( [
            'id'                   => 'friend-link-form',
            'enableAjaxValidation' => true,
            'action'               => $action ] );
    ?>
    <div class="row">
        <?= '<div class="col-xs-12">' . $form->field( $model, 'name' )->textInput() . '</div>' ?>

        <?= '<div class="col-xs-6">' . $form->field( $model, 'pid' )->dropDownList( FriendLink::allIdToName( 'id', 'name', [ 'pid' => 0 ] ), [ 'prompt' => '' ] ) . '</div>' ?>

        <?= '<div class="col-xs-6">' . $form->field( $model, 'type' )->dropDownList( [ 'url' => '链接', 'email' => '邮件', 'tel' => '电话', 'qrcode' => '二维码', 'label' => '标签', 'labelurl' => '标签链接' ], [ 'prompt' => '' ] ) . '</div>' ?>

        <?= '<div class="col-xs-12">' . $form->field( $model, 'pic' )->widget( AjaxFileInput::class, [ 'clip' => 'false' ] ) . '</div>' ?>

        <?= '<div class="col-xs-12">' . $form->field( $model, 'url' )->textInput( [ 'maxlength' => true ] ) . '</div>' ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton( '<i class="fa fa-save"></i> ' . Yii::t( 'da', 'Save' ), [ 'class' => 'btn btn-success' ] ) ?>
        <?= Html::resetButton( '<i class="fa fa-reply"></i> ' . Yii::t( 'da', 'Reset' ), [ 'class' => 'btn btn-default' ] ) ?>
    </div>

    <?php
    ActiveForm::end();
    ?>

</div>