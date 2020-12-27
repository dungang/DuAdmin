<?php
/* @var $this yii\web\View */
/* @var $model \Frontend\Forms\ContactForm */

$this->title = Yii::t('app','Contact');
$this->params['breadcrumbs'][] = $this->title;
echo $this->render("contactForm",['model'=>$model]);
?>
