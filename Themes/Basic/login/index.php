<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \Frontend\Forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use DuAdmin\Models\Setting;

$this->title = '登录';
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

<div class="login-box">
	<div class="login-logo">
		<?= Html::a(Html::encode($this->title), ['/']) ?>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">欢迎回来，请登录！</p>

		<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
		<?= $form->field($model, 'username')->textInput() ?>
		<?= $form->field($model, 'password')->passwordInput() ?>
		<?= $form->field($model, 'captcha')->widget('yii\captcha\Captcha', ['captchaAction' => '/site/captcha']) ?>
		<div class="row">
			<div class="col-xs-8">
				<?= $form->field($model, 'rememberMe')->checkbox() ?>
			</div>
			<!-- /.col -->
			<div class="col-xs-4">
				<?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>

			</div>
			<!-- /.col -->
		</div>
		<div style="color: #999; margin: 1em 0">
			忘记密码，请 <?= Html::a('重置密码', ['/site/request-password-reset']) ?>.
			<br>
			没有账户，请 <?= Html::a('注册', ['/signup']) ?>
		</div>
		<?php ActiveForm::end(); ?>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->
</div>