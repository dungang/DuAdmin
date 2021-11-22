<?php

use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\AjaxFileInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Frontend\Models\User */

$this->title = Yii::t('app', 'User Info');
$this->params['breadcrumbs'][] = $this->title;
AjaxModalOrNormalPanelContent::begin([
    'intro' => Yii::t('da', 'Update {0}', $this->title)
]) ?>

<?php $form = ActiveForm::begin(['id' => 'profile-form', 'enableAjaxValidation' => true]); ?>
<?= Html::activeHiddenInput($model, 'username') ?>
<div class="row">
    <div class="col-md-6">

        <?= $form->field($model, 'avatar')->widget(AjaxFileInput::class, [
            'clip' => AppHelper::getSetting('user.avatar.clip', 'true'),
            'compress' => AppHelper::getSetting('user.avatar.compress', 'true'),
            'clipWidth' => AppHelper::getSetting('user.avatar.clipWidth', 200),
            'clipHeight' => AppHelper::getSetting('user.avatar.clipHeight', 200)
        ]) ?>

        <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="col-md-6">

        <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('da', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
</div>

<?php ActiveForm::end(); ?>
<?php AjaxModalOrNormalPanelContent::end() ?>