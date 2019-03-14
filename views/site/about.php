<?php

use app\kit\models\Setting;

/* @var $this yii\web\View */
$this->title = '欢迎您';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name'=>'keywords',
    'content'=> Setting::getSettings('site.keywords')
]);
$this->registerMetaTag([
    'name'=>'description',
    'content'=>Setting::getSettings('site.description'),
]);
?>

<div class="jumbotron">
	<h1>
		白猿<small style="vertical-align: top;">&reg;</small>
	</h1>
	<p style="font-size: 40px;" class="text-muted">每一款软件都是一只灵兽<p>
	<p>dungang@126.com</p>
</div>