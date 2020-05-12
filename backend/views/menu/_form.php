<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\mmadmin\models\Menu;

/* @var $this yii\web\View */
/* @var $model app\mmadmin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(['id'=>'sys-menu-form','enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'is_front')->checkbox([]) ?>
    
    <?= $form->field($model, 'require_login')->checkbox([]) ?>

    <?=$form->field($model, 'pid')->dropDownList(Menu::allIdToName('id', 'name', ['pid' => 0,'is_front' => $model->is_front]), ['prompt' => ['text' => '','options' => ['value' => 0]]])?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
