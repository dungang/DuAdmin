<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\Cron */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cron-form">

    <?php
    $form = ActiveForm::begin( [
        'id' => 'sys-cron-form',
        'enableAjaxValidation' => true
    ] );
    ?>

    <?=$form->field( $model, 'task' )->textInput( [ 'maxlength' => true] )?>

    <?=$form->field( $model, 'mhdmd' )->textInput( [ 'maxlength' => true] )?>

    <?=$form->field( $model, 'jobScript' )->textInput( [ 'maxlength' => true] )?>

    <?=$form->field( $model, 'param' )->textarea( [ 'maxlength' => true] )?>

    <?=$form->field( $model, 'intro' )->textarea( [ 'maxlength' => true] )?>

    <?=$form->field( $model, 'isActive' )->checkbox()?>

    <div class="form-group text-right">
        <?=Html::submitButton( '<i class="fa fa-save"></i> 保存', [ 'class' => 'btn btn-success'] )?>
    </div>

    <?php
    ActiveForm::end();
    ?>

</div>
