<?php
use Addons\Cms\Assets\CmsAsset;
use Addons\Cms\Widgets\AdvBlockWidget;
use Addons\Cms\Widgets\ListNewestPosts;
use Addons\Cms\Widgets\PostNav;
use DuAdmin\Helpers\AppHelper;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model \Addons\Cms\Models\Post */
/* @var $category \Addons\Cms\Models\Category */
$this->title = $model->title;
if ( $category ) {
  $this->params['breadcrumbs'][] = [
      'label' => $category->name,
      'url' => [
          '/cms/post',
          'slug' => $category->slug
      ]
  ];
}
$this->registerMetaTag( [
    'name' => 'keywords',
    'content' => $model->keywords . ',' . AppHelper::getSetting( 'site.keywords' )
], 'keywords' );
$this->registerMetaTag( [
    'name' => 'description',
    'content' => $model->description . ',' . AppHelper::getSetting( 'site.description' )
], 'description' );
CmsAsset::register( $this );
?>
<?=AdvBlockWidget::widget( [ 'nameCode' => 'post','urlPath' => \Yii::$app->request->getPathInfo()] )?>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="cms-page">
				<div class="cms-post">
					<div class="page-header">
						<h1><?=Html::encode( $this->title )?></h1>
						<div class="text-muted cms-post-meta">
							<span class="bg-success text-success">#<?=$model->category->name?></span>
							<span><?=\Yii::$app->formatter->asDate( $model['createdAt'] )?></span>
							<span><i class="fa fa-eye"></i> <?=$model['viewTimes']?> 阅读</span>
						</div>
					</div>
					<div class="cms-post-content">
						<?=Html::img( $model->cover, [ 'width' => '100%'] )?>
						<div class="content  text-justify">
						<?=$model->content?>
						</div>
					</div>
					<?=PostNav::widget( [ 'id' => $model['id']] )?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="cms-siderbar">
				<?=ListNewestPosts::widget()?>
			</div>
		</div>
	</div>
</div>