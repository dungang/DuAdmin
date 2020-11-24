<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\backend\models\AuthGroup;

/* @var $this yii\web\View */
/* @var $model \app\backend\models\AuthRole */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">

    <?php $form = ActiveForm::begin(['id'=>'auth-role-form','enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'group_name')->radioList(AuthGroup::allIdToName('name','title',['type'=>AuthGroup::TYPE_ROLE])) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
