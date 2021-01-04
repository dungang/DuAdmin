<?php
/* @var string $input */
?>
<div class="ajax-file-input" data-role="duajaxupload">
	<div class='input-group'>
		<?= $input ?>
		<span class="input-group-btn">
			<button class="btn btn-default" data-toggle="duajaxupload" type="button"><?= Yii::t('da', 'Select File') ?></button>
			<input type="file" style="display: none" />
		</span>
	</div>
	<div class="cropper-dialog">
		<div class="cropper-image-box">
			<img class="croper-image" src="" />
		</div>
		<div class="cropper-buttons">
			<button type="button" class="btn btn-default" data-dismiss="ajax-upload">取消</button>
			<button type="button" class="btn btn-primary">确定</button>
		</div>
	</div>
</div>