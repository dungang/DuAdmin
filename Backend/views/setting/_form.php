<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use DuAdmin\Models\Setting;
use Backend\Widgets\SettingSelection;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(['id'=>'sys-setting-form','enableAjaxValidation' => true]); ?>
    <?php if (\Yii::$app->controller->is_backend_module) :?>
    <?= $form->field($model, 'category')->dropDownList(Setting::getSettingCatetory()) ?>
    <?php endif;?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'valType')->radioList(['STR'=>'字符串','ARRY'=>'数组','ASSOC'=>'关联数组','JSON'=>'json','HTML'=>'html','P'=>'段落','IMAGE'=>'图片']) ?>
    <?= $form->field($model, 'value')->widget(SettingSelection::class) ?>
    <?= $form->field($model, 'hint')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
