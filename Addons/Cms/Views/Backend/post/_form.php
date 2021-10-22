<?php

use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\AjaxFileInput;
use DuAdmin\Widgets\DefaultEditor;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \Addons\Cms\Models\Post */
/* @var $form yii\widgets\ActiveForm */
/* @var $action array */
?>

<div class="post-form">

    <?php

    $form = ActiveForm::begin([
        'id'                   => 'post-category-form',
        'enableAjaxValidation' => true,
        'action'               => $action
    ]);
    ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'content')->label(false)->widget(DefaultEditor::getEditorClass(), ['mode' => DefaultEditor::MODE_RICH]) ?>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">&nbsp;</label>
                <?= Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('da', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
            </div>
            <?= $form->field($model, 'isPublished')->checkbox() ?>
            <?= $form->field($model, 'cateId')->dropDownList(\Addons\Cms\Models\Category::getMapWidthDep()) ?>
            <?= $form->field($model, 'cover')->widget(AjaxFileInput::class, [
                'clip' => AppHelper::getSetting('cms.post.clip', 'true'), 
                'compress' => AppHelper::getSetting('cms.post.compress', 'true'), 
                'clipWidth' => AppHelper::getSetting('cms.post.clipWidth', 480), 
                'clipHeight' => AppHelper::getSetting('cms.post.clipHeight', 320)
            ]) ?>
            <?= $form->field($model, 'keywords')->textarea(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

        </div>
    </div>
    <?php

    ActiveForm::end();
    ?>
</div>