<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Addons\Cms\Models\Category;
use DuAdmin\Helpers\AppHelper;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['id'=>'category-form','action'=>$action, 'enableAjaxValidation' => true]); ?>
    <div class="row">
    <?= '<div class="col-xs-6">' . $form->field($model, 'pid')->dropDownList(Category::getMapWidthDep(),['prompt'=>'']) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'slug')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'name')->textInput(['maxlength' => true]) . '</div>' ?>

    <?= '<div class="col-xs-6">' . $form->field($model, 'template')->dropDownList(AppHelper::getSettingAssoc('cms.post.templates'),['prompt'=>'']) . '</div>' ?>

    <?= '<div class="col-xs-12">' . $form->field($model, 'intro')->textInput(['maxlength' => true]) . '</div>' ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da','Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('<i class="fa fa-reply"></i> ' .  Yii::t('da','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
