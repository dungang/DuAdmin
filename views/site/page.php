<?php
use yii\helpers\Html;
use app\kit\models\Setting;
use app\kit\helpers\KitHelper;

/* @var $this yii\web\View */
/* @var $model app\addons\cms\models\Article */
$this->title = $model->title  . '_' . KitHelper::getSetting('site.name');
$this->params['breadcrumbs'][] = $model->title;
?>
<h1 class="text-center"><?= Html::encode($model->title) ?></h1>
<p class="text-center text-muted">
<?= Setting::getSettings('site.name') ?> 
</p>
<div class="page-content text-justify">
<?= $model->content?>
</div>