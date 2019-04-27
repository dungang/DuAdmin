<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\kit\forms\PostRateLimitForm */
/* @var $form yii\widgets\ActiveForm */
Modal::begin([
    'id' => 'limited-captcha',
    'header' => '人机验证',
    'clientOptions' => [
        'show' => true
    ]
]);
?>
<div class="alert alert-danger" role="alert">
	<strong>警告</strong> 请求的频率太快，请输入验证码，验证通过之后才可以继续！
</div>
<div class="row">
	<div class="col-sm-3"> 
    <?php $form = ActiveForm::begin(); ?>
    <?=$form->field($model, 'captcha')->widget(Captcha::className(), ['captchaAction' => '/site/captcha'])?>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-check"></i> 验证', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
<?php Modal::end()?>