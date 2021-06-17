<?php
use yii\helpers\Html;
/* @var $model Addons\Cms\Models\Post */
?>
<div class="col-sm-6 col-md-4">
	<div class="thumbnail">
		<?=Html::img($model->cover .'_thumb.png',['height'=>'200'])?>
    	<div class="caption">
			<h3><?=Html::a($model->title, ['show','id' => $model->id])?></h3>
			<p class="text-primary"><?=\Yii::$app->formatter->asDate($model->created_at )?></p>
		</div>
	</div>
</div>