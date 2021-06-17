<?php
use DuAdmin\Helpers\AppHelper;
use yii\helpers\Html;
use Addons\Cms\Widgets\Swiper;

/* @var $block DuAdmin\Models\PageBlockData  */
?>
<div class="dua bg-primary dua-banner">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-6">
				<div class="jumbotron">
					<h1><?=$block['title']?></h1>
					<p><?=$block['intro']?></p>
					<p>
					<?= Html::a($block['urlText'],AppHelper::parseDuAdminMenuUrl($block['url']),['role'=>'button','class'=>'btn btn-success'])?>
					</p>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="show-swiper">
					<?= Swiper::widget(['size'=>$block['size']])?>
				</div>
			</div>
		</div>
	</div>
</div>