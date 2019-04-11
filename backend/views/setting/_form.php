<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\kit\models\Setting;

/* @var $this yii\web\View */
/* @var $model app\kit\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(['id'=>'sys-setting-form','enableAjaxValidation' => true]); ?>
    <?php if (\Yii::$app->controller->is_backend_module) :?>
    <?= $form->field($model, 'category')->dropDownList(Setting::getSettingCatetory()) ?>
    <?php endif;?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'val_type')->radioList(['STR'=>'字符串','ARRY'=>'数组','ASSOC'=>'关联数组','JSON'=>'json','HTML'=>'html','P'=>'段落']) ?>
    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'hint')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
