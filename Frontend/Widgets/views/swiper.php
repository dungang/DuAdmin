<div class='swiper-container'>
	<div class="swiper-wrapper" style="display: flex; align-items: center;">
		<?php foreach($files as $file) : ?>
		<div class="swiper-slide">
			<div class="img swiper-zoom-container">
				<img src="<?=$file?>" width="100%" style="display: block;" />
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>