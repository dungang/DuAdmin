<?php

use Backend\Widgets\SettingSelection;
use DuAdmin\Models\DictData;
use DuAdmin\Models\Setting;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Setting */
/* @var $form ActiveForm */
?>

<div class="setting-form">

    <?php
    $form = ActiveForm::begin( [
            'id'                   => 'sys-setting-form',
            'enableAjaxValidation' => true
        ] );
    ?>
    <?php if ( Yii::$app->controller->categoryDict ) : ?>
        <?= $form->field( $model, 'subCategory' )->dropDownList( DictData::getDataLabels( Yii::$app->controller->categoryDict ) ) ?>
    <?php endif; ?>
    <?= $form->field( $model, 'title' )->textInput( [ 'maxlength' => true ] ) ?>
    <?= $form->field( $model, 'name' )->textInput( [ 'maxlength' => true ] ) ?>
    <?= $form->field( $model, 'valType' )->radioList( [ 'STR' => '字符串', 'BOOL' => 'bool', 'ARRY' => '数组', 'ASSOC' => '关联数组', 'JSON' => 'json', 'HTML' => 'html', 'P' => '段落', 'IMAGE' => '图片' ] ) ?>
    <?= $form->field( $model, 'value' )->widget( SettingSelection::class ) ?>
    <?= $form->field( $model, 'hint' )->textInput( [ 'maxlength' => true ] ) ?>

    <div class="form-group text-right">
        <?= Html::resetButton( '<i class="fa fa-reply"></i> ' . Yii::t( 'da', 'Reset' ), [ 'class' => 'btn btn-default' ] ) ?>
        <?= Html::submitButton( '<i class="fa fa-save"></i> ' . Yii::t( 'da', 'Save' ), [ 'class' => 'btn btn-success' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>