<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \Frontend\Forms\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
?>
<div class="site-contact">
    <h1 class="text-center du-live-element"><?= Yii::t('app', 'Contact') ?></h1>
    <div class="contact-form">
        <p><?= Yii::t('app', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.') ?>
        </p>
        <?php
        $form = ActiveForm::begin([
            'id' => 'contact-form',
            'action' => [
                '/site/contact'
            ],
            'validateOnBlur' => false
        ]);
        ?>
        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'fullName')->textInput() ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'email') ?>
            </div>
        </div>

        <?= $form->field($model, 'subject') ?>

        <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::class, ['template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>']) ?>

        <div class="form-group">
            <?= Html::submitButton('<i class="fa fa-send"></i> ' . Yii::t('da', 'Submit'), ['class' => 'btn btn-primary btn-block btn-lg', 'name' => 'contact-button']) ?>
        </div>

        <?php
        ActiveForm::end();
        ?>
    </div>
</div>