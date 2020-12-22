<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use DuAdmin\Models\Menu;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\Menu */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array  */
//$action = isset($action)?$action:'';
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(['id'=>'sys-menu-form','enableAjaxValidation' => true,'action'=>$action]); ?>

    <?= $form->field($model, 'isFront')->checkbox([]) ?>
    
    <?= $form->field($model, 'requireAuth')->checkbox([]) ?>

    <?=$form->field($model, 'pid')->dropDownList(Menu::allIdToName('id', 'name', ['pid' => 0,'isFront' => $model->isFront]), ['prompt' => ['text' => '','options' => ['value' => 0]]])?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('da','Create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
