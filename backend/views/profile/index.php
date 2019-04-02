<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\kit\widgets\JcropFileInput;
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\User */

$this->title = '用户中心';
$this->params['breadcrumbs'][] = $this->title;
AjaxModalOrNormalPanelContent::begin([
    'intro' => '修改用户信息'
])?>

    <?php $form = ActiveForm::begin(['id'=>'profile-form','enableAjaxValidation' => false,'options'=>['enctype'=>'multipart/form-data']]); ?>
	<?= Html::activeHiddenInput($model, 'crop',['id'=>'crop'])?>
    <?php

echo $form->field($model, 'avatar')->widget(JcropFileInput::className(), [
        'cropInput' => '#crop',
        'preview_h' => '200',
        'preview_w' => '200',
        'clientOptions' => [
            'setSelect' => [
                100,
                100,
                200,
                200
            ],
            'aspectRatio' => 1
            //'allowResize'=>false
        ]
    ])?>
    <?= $form->field($model, 'username')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'nick_name')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'mobile')->textInput() ?>
    <?=$form->field($model, 'status')->hiddenInput()->label(false)?>

<div class="form-group">
        <?= Html::submitButton('更新', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>
<?php AjaxModalOrNormalPanelContent::end()?>
