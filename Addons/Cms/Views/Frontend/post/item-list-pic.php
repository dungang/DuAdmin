<?php
use Addons\Cms\Models\Post;
use yii\helpers\Html;
/* @var $model Post */
?>

	<div class="row row-no-gutters">
		<div class="col-md-5 col-xs-12">
		<?php
  echo Html::a( Html::img( $model['cover'], [
      'class' => 'image lazyload',
      'alt' => $model['title'],
      'width' => '100%'
  ] ), [
      '/cms/post/show',
      'id' => $model['id']
  ] )?>
		</div>
		<div class="col-md-7 col-xs-12">
			<div class="post-info">
				<h2><?=Html::a( $model['title'], [ '/cms/post/show','id' => $model['id']] )?></h2>
				<div class="text-muted cms-post-meta">
					<span class="bg-success text-success">#<?=$model->category->name?></span>
					<span><?=\Yii::$app->formatter->asDate( $model['createdAt'] )?></span>
					<span><i class="fa fa-eye"></i> <?=$model['viewTimes']?> 阅读</span>
				</div>
				<p class="post-item-desc"><?=$model['description']?></p>
			</div>
		</div>
	</div>
