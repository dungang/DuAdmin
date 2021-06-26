<?php
use DuAdmin\Widgets\AjaxFileInput;
use DuAdmin\Widgets\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\AdvBlock */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
?>
<div class="adv-block-form">

    <?php
    $form = ActiveForm::begin( [
        'id' => 'adv-block-form',
        'enableAjaxValidation' => true,
        'action' => $action
    ] );
    ?>
    <div class="row">
    <?='<div class="col-xs-6">' . $form->field( $model, 'name' )->textInput( [ 'maxlength' => true] ) . '</div>'?>

    <?='<div class="col-xs-6">' . $form->field( $model, 'nameCode' )->textInput( [ 'maxlength' => true] ) . '</div>'?>

    <?='<div class="col-xs-6">' . $form->field( $model, 'urlPath' )->textInput( [ 'maxlength' => true] ) . '</div>'?>

    <?='<div class="col-xs-6">' . $form->field( $model, 'pic' )->widget( AjaxFileInput::class, [ 'clip' => 'false'] ) . '</div>'?>

    <?='<div class="col-xs-6">' . $form->field( $model, 'isFlat' )->dropDownList( [ '否','是'] ) . '</div>'?>

    <?='<div class="col-xs-6">' . $form->field( $model, 'type' )->dropDownList( [ 'image' => '图片','js' => 'js代码','html' => 'html代码'], [ 'prompt' => ''] ) . '</div>'?>

    <?='<div class="col-xs-6">' . $form->field( $model, 'url' )->textInput( [ 'maxlength' => true] ) . '</div>'?>

    <?='<div class="col-xs-6">' . $form->field( $model, 'content' )->textarea() . '</div>'?>

    <?='<div class="col-xs-6">' . $form->field( $model, 'startedAt' )->widget( DatePicker::class ) . '</div>'?>

    <?='<div class="col-xs-6">' . $form->field( $model, 'endAt' )->widget( DatePicker::class ) . '</div>'?>

    </div>
    <div class="form-group">
        <?=Html::submitButton( '<i class="fa fa-save"></i> ' . Yii::t( 'da', 'Save' ), [ 'class' => 'btn btn-success'] )?>
        <?=Html::resetButton( '<i class="fa fa-reply"></i> ' . Yii::t( 'da', 'Reset' ), [ 'class' => 'btn btn-default'] )?>
    </div>

    <?php
    ActiveForm::end();
    ?>

</div>
