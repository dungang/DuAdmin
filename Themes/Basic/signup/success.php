<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use DuAdmin\Models\Setting;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup Success';
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
<div class="page-panel">
    <h2><?= Html::encode($this->title) ?></h2>
    <p>
        Thank you for registration.
    </p>
    <p>
        Please check your inbox for verification email <?= $encodeEmail ?>.
    </p>
</div>