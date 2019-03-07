<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\kit\models\Menu;

/* @var $this yii\web\View */
/* @var $model app\kit\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pid')->dropDownList(Menu::allIdToName(),['prompt'=>[
        'text'=>'',
        'options'=>[
            'value'=>0
        ]
    ]]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_front')->checkbox() ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
