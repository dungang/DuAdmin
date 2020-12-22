<?php
/* @var string $input */
 ?>
<div class='input-group ajax-file-input'>
	<?= $input ?>
	<span class="input-group-btn">
		<button class="btn btn-default" type="button"><?=Yii::t('da','Select File')?></button>
		<input type="file" style="display: none" />
	</span>
</div>