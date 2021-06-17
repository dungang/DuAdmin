<?php
use yii\helpers\Html;
use Addons\Cms\Models\Post;
use Addons\Cms\Widgets\NewestPostsBlock;
use DuAdmin\Helpers\AppHelper;
/*@var  $models Post[] */
/* @var NewestPostsBlock $block */
?>
<?php if($block->title):?>
<h1 class="text-center"><?= $block->title?></h1>
<?php endif;?>
<div class="container">
	<div class="row fix-col-height">
		<?php foreach($models as $model) : ?>
		<div class="col-xs-6 col-sm-6 col-md-3">
			<div class="thumbnail cms-thumbnail">
                <?= Html::a(Html::img(empty($model['cover'])?'images/nopic.png':$model['cover']),['/cms/post/show','id'=>$model['id']]) ?>
				<div class="caption">
					<h5 class="text-center"><?=Html::a($model['title'],['/cms/post/show','id'=>$model['id']])?></h5>
				</div>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>
