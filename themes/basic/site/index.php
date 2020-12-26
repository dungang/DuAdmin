<?php
use DuAdmin\Widgets\DatePicker;
use DuAdmin\Widgets\DefaultFlashSwiper;
use DuAdmin\Widgets\BasePageBlock;

/* @var yii\web\View  $this */
$this->title = Yii::t('theme', 'Home');
?>

<div class="dua bg-primary dua-banner">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-6">
				<div class="jumbotron">
					<h1>Hello, world!</h1>
					<p>For My Best Friends!</p>
					<p>
						<a class="btn btn-primary" href="#" role="button">Learn more</a>
					</p>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="show-swiper">
					<?= DefaultFlashSwiper::renderSwiper()?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php BasePageBlock::factory() ?>
