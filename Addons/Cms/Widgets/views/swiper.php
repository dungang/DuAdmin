<?php

use yii\helpers\Html;

/* @var $widget Addons\Cms\Widgets\Swiper */
/* @var $items Addons\Cms\Models\Flash[] */
?>
<div class='swiper-container'>
	<div class="swiper-wrapper" style="display: flex; align-items: center;">
	<?php foreach($items as $item):?>
		<div class="swiper-slide">
			<div class="img swiper-zoom-container">
				<?php if($item['url']):?>
				<?=Html::a(Html::img($item['pic']),$item['url'])?>
				<?php else :?>
				<img src="<?= $item['pic'] ?>" />
				<?php endif;?>
			</div>
		</div>
		<?php endforeach;?>
	</div>
	<!-- pagination -->
	<?php if ($widget->pagination):?>
	<div class="swiper-pagination"></div>
	<?php endif;?>
	<!-- navigations -->
	<?php if ($widget->navigation):?>
	<div class="swiper-button-prev"></div>
	<div class="swiper-button-next"></div>
	<?php endif;?>
	<!-- scrollbar -->
	<?php if ($widget->scrollbar):?>
	<div class="swiper-scrollbar"></div>
	<?php endif;?>
</div>