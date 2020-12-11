<?php
use DuAdmin\Widgets\DatePicker;

/* @var yii\web\View  $this */
$this->title = Yii::t('theme', 'Home');
$this->registerJs("$('.input-daterange input').each(function() {
    $(this).datepicker('clearDates');
});")?>

<div class="dua">
<div class="bg-primary jumbotron">
	<h1>Hello, world!</h1>
	<p>For My Best Friends!</p>
	<p>
		<a class="btn btn-primary" href="#" role="button">Learn more</a>
	</p>
</div>
</div>
<div class="jumbotron">
	<h1>Hello, world!</h1>
	<p>For My Best Friends!</p>
	<p>
		<a class="btn btn-primary" href="#" role="button">Learn more</a>
	</p>
	<div style="width: 400px; margin: auto">
		<input type="text" class="form-control" value="02-16-2012">
  <?=DatePicker::widget(['name' => 'created_at','clientOptions' => ['multidate' => 2,'multidateSeparator' => '~']])?>
  <div class="input-group input-daterange">
			<input type="text" class="form-control" value="2012-04-05">
			<div class="input-group-addon">to</div>
			<input type="text" class="form-control" value="2012-04-19">
		</div>
	</div>
</div>
<div class="jumbotron">
	<h1>Hello, world!</h1>
	<p>For My Best Friends!</p>
	<p>
		<a class="btn btn-primary" href="#" role="button">Learn more</a>
	</p>
</div>
<div class="jumbotron">
	<h1>Hello, world!</h1>
	<p>For My Best Friends!</p>
	<p>
		<a class="btn btn-primary" href="#" role="button">Learn more</a>
	</p>
</div>
