<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\kit\widgets\JcropFileInput;
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\backend\forms\DynamicUser */

$this->title = '用户中心';
$this->params['breadcrumbs'][] = $this->title;
AjaxModalOrNormalPanelContent::begin([
    'intro' => '修改用户信息'
]) ?>

<?php $form = ActiveForm::begin(['id' => 'profile-form', 'enableAjaxValidation' => true, 'options' => ['enctype' => 'multipart/form-data']]); ?>
<?= Html::hiddenInput('crop', '', ['id' => 'crop']) ?>
<?= Html::activeHiddenInput($model->model, 'username') ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model->model, 'nick_name')->textInput() ?>
        <?= $form->field($model->model, 'password')->passwordInput() ?>
        <?= $form->field($model->model, 'email')->textInput() ?>
        <?= $form->field($model->model, 'tel')->textInput() ?>
        <?php
        echo $form->field($model->model, 'avatar')->widget(JcropFileInput::className(), [
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
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model->model, 'mobile')->textInput() ?>
        <?= $form->field($model->model, 'dingding')->textInput() ?>
        <?= $form->field($model->model, 'wechat')->textInput() ?>
        <?= $form->field($model->model, 'qq')->textInput() ?>
        <?= $form->field($model->model, 'wangwang')->textInput() ?>
    </div>

    <?php foreach ($model->getDynamicProperties() as $property) : ?>
        <div class="col-md-6">
            <?= $form->field($model, $property->field)->input($property->input_type) ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="form-group">
    <?= Html::submitButton('更新', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
<?php AjaxModalOrNormalPanelContent::end() ?>