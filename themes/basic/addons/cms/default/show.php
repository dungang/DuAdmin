<?php

use yii\helpers\Html;
use app\mmadmin\models\Setting;
use app\mmadmin\helpers\KitHelper;
use app\mmadmin\widgets\HighLight;

/* @var $this yii\web\View */
/* @var $model app\addons\cms\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = [
	'label' => '内容',
	'url' => [
		'/cms'
	]
];
$this->params['breadcrumbs'][] = $this->title;

$user = app\mmadmin\models\User::findOne([
	'id' => $model->user_id
]);

$this->registerMetaTag([
	'name' => 'keywords',
	'content' => $model->keywords . ',' . KitHelper::getSetting('site.keywords')
], 'keywords');
$this->registerMetaTag([
	'name' => 'description',
	'content' => $model->description . ',' . KitHelper::getSetting('site.description')
], 'description');
?>

<div class="container">
	<div class="row">
		<div class="col-md-9">
			<div class="article">
				<h1 class="text-center"><?= Html::encode($this->title) ?></h1>
				<p class="text-center text-muted">
					<?= Setting::getSettings('site.name') ?>
					<?= \Yii::$app->formatter->asDate($model->created_at) ?>
				</p>
				<p class="alert alert-warning" role="alert"><?= $model->description ?></p>
				<div class="page-content text-justify">
					<?= Html::img($model->cover, ['width' => '100%']) ?>
					<?= $model->content ?>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1 class="panel-title">分类</h1>
				</div>
				<div class="panel-body">
				</div>
			</div>
		</div>
	</div>
</div>

<?php HighLight::widget() ?>