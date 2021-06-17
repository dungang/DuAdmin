<?php
use Addons\Cms\Models\Post;
use yii\helpers\Html;

/* @var $model Post */
?>
<div class="media">
	<div class="media-left">
        <?php
        echo Html::a(Html::img($model['cover'], [
            'class' => 'media-object',
            'alt' => $model['title'],
            'height' => '160',
            'width' => '240'
        ]), [
            '/cms/post/show',
            'id' => $model['id']
        ])?>
    </div>
	<div class="media-body">
		<h3 class="media-heading"><?= Html::a($model['title'], ['/cms/post/show', 'id' => $model['id']]) ?></h3>
		<div class="text-muted cms-post-meta">
    		<span class="bg-success text-success">#<?=$model->category->name?></span> 
    		<span><?= \Yii::$app->formatter->asDate($model['createdAt']) ?></span>
    		<span><i class="fa fa-eye"></i> <?= $model['viewTimes'] ?> 阅读</span>
		</div>
		<p class="post-item-desc"><?= $model['description'] ?></p>
	</div>
</div>