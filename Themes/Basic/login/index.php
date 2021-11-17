<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \Frontend\Forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use DuAdmin\Models\Setting;

$this->title = Yii::t('theme', 'Login');
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
		<p class="login-box-msg"><?= Yii::t('theme', 'Welcome to back,Please Login') ?></p>

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
				<?= Html::submitButton(Yii::t('theme', 'Login'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>

			</div>
			<!-- /.col -->
		</div>
		<div style="color: #999; margin: 1em 0">
			<?= Yii::t('theme', 'When forget password, Please ') . Html::a(Yii::t('theme', 'reset password'), ['/site/request-password-reset']) ?>.
			<br>
			<?= Yii::t('theme', 'When have no a account, Please ') . Html::a(Yii::t('theme', 'signup'), ['/signup']) ?>
		</div>
		<?php ActiveForm::end(); ?>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->
</div>