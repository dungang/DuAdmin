<?php
use DuAdmin\Models\Menu;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\Menu */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
// $action = isset($action)?$action:'';
?>

<div class="menu-form">

    <?php
    $form = ActiveForm::begin( [
        'id' => 'sys-menu-form',
        'enableAjaxValidation' => true,
        'action' => $action
    ] );
    ?>
	<?=$form->field( $model, 'requireAuth' )->checkbox( [ ] )?>

    <?=$form->field( $model, 'pid' )->dropDownList( Menu::allIdToName( 'id', 'name', [ 'pid' => 0] ), [ 'prompt' => [ 'text' => '','options' => [ 'value' => 0]]] )?>

    <?=$form->field( $model, 'name' )->textInput( [ 'maxlength' => true] )?>

    <?=$form->field( $model, 'url' )->textInput( [ 'maxlength' => true] )?>

    <?=$form->field( $model, 'icon' )->textInput( [ 'maxlength' => true] )?>

    <div class="form-group text-right">
        <?=Html::resetButton( '<i class="fa fa-reply"></i> ' . Yii::t( 'da', 'Reset' ), [ 'class' => 'btn btn-default'] )?>
        <?=Html::submitButton( '<i class="fa fa-save"></i> ' . Yii::t( 'da', 'Save' ), [ 'class' => 'btn btn-success'] )?>
    </div>
    <?php
    ActiveForm::end();
    ?>

</div>
