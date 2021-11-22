<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use DuAdmin\Models\Setting;
use DuAdmin\Widgets\AgreementWidget;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Setting::getSettings('site.keywords')
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => Setting::getSettings('site.description')
]);
?>
<div class="register-box">
    <div class="register-logo">
        <?= Html::a(Html::encode($this->title), ['/']) ?>
    </div>
    <!-- /.register-logo -->
    <div class="register-box-body">
        <p class="register-box-msg">欢迎回来，请注册！</p>

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'agreement')->label(false)->widget(AgreementWidget::class,[
            'title' => '《平台注册协议》',
            'href' => 'https://www.baidu.com'
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

        <div style="color: #999; margin: 1em 0">
            我有账户，请 <?= Html::a('登录', ['/login']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>