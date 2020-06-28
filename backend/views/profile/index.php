<?php

use app\mmadmin\widgets\AjaxFileInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\mmadmin\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\backend\forms\DynamicUser */

$this->title = Yii::t('backend', 'User Info');
$this->params['breadcrumbs'][] = $this->title;
AjaxModalOrNormalPanelContent::begin([
    'intro' => Yii::t('ma', 'Update {0}', $this->title)
]) ?>

<?php $form = ActiveForm::begin(['id' => 'profile-form', 'enableAjaxValidation' => true]); ?>
<?= Html::activeHiddenInput($model, 'username') ?>
<div class="row">
    <div class="col-md-6">
        <?php echo $form->field($model, 'avatar')->widget(AjaxFileInput::className()) ?>
        <?= $form->field($model, 'nick_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6"> 

        <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('<i class="fa fa-save"></i> ' .  Yii::t('ma', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
</div>

<?php ActiveForm::end(); ?>
<?php AjaxModalOrNormalPanelContent::end() ?>