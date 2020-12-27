<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \Frontend\Forms\ContactForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
?>
<div class="site-contact container">

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<h1 class="text-center"><?= Yii::t('app','Contact')?></h1>
			<p><?= Yii::t('app','If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.')?></p>
            <?php $form = ActiveForm::begin(['id' => 'contact-form','action'=>['/site/contact']]); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <?=$form->field($model, 'verifyCode')->widget(Captcha::className(), ['template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>'])?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('da','Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
	</div>

</div>
