<?php
use Addons\Cms\Models\Page;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\Page */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
?>
<div class="page-form">

    <?php
    $form = ActiveForm::begin( [
        'id' => 'page-form',
        'enableAjaxValidation' => true,
        'action' => $action
    ] );
    ?>
    <div class="row">
        <?='<div class="col-xs-6">' . $form->field( $model, 'slug' )->textInput( [ 'maxlength' => true] ) . '</div>'?>
        <?='<div class="col-xs-6">' . $form->field( $model, 'pid' )->dropDownList( Page::allIdToName( 'id', 'title', [ 'pid' => 0] ), [ 'prompt' => ''] ) . '</div>'?>
        <?='<div class="col-xs-12">' . $form->field( $model, 'title' )->textInput() . '</div>'?>
        <?='<div class="col-xs-12">' . $form->field( $model, 'template' )->dropDownList( [ 'page' => '默认','empty' => '空白'] ) . '</div>'?>
    </div>
    <div class="form-group">
        <?=Html::submitButton( '<i class="fa fa-save"></i> ' . Yii::t( 'da', 'Save' ), [ 'class' => 'btn btn-success'] )?>
        <?=Html::resetButton( '<i class="fa fa-reply"></i> ' . Yii::t( 'da', 'Reset' ), [ 'class' => 'btn btn-default'] )?>
    </div>

    <?php
    ActiveForm::end();
    ?>

</div>