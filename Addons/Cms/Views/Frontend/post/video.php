<?php
use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use Addons\Cms\Widgets\ListNewestPosts;
use Addons\Cms\Assets\CmsAsset;
use Addons\Cms\Widgets\PostNav;

/* @var $this yii\web\View */
/* @var $model \Addons\Cms\Models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = [
    'label' => '内容',
    'url' => [
        '/cms'
    ]
];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $model->keywords . ',' . AppHelper::getSetting('site.keywords')
], 'keywords');
$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->description . ',' . AppHelper::getSetting('site.description')
], 'description');
CmsAsset::register($this);
?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="cms-page">
				<div class="cms-post">
					<div class="page-header">
						<h1><?= Html::encode($this->title) ?></h1>
						<div class="text-muted cms-post-meta">
                    		<span class="bg-success text-success">#<?=$model->category->name?></span> 
                    		<span><?= \Yii::$app->formatter->asDate($model['createdAt']) ?></span>
                    		<span><i class="fa fa-eye"></i> <?= $model['viewTimes'] ?> 阅读</span>
                		</div>
					</div>
					<div class="cms-post-content text-justify">
						<?= $model->content ?>
					</div>
				</div>
				<?= PostNav::widget(['id'=>$model['id']])?>
			</div>
		</div>
		<div class="col-md-4">
			<div class="cms-siderbar">
				<?= ListNewestPosts::widget() ?>
			</div>
		</div>
	</div>
</div>