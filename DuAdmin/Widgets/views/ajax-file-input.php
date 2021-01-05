<?php
/* @var string $input */
/* @var array $options */

use yii\helpers\Html;

$options['class'] = 'ajax-file-input';
$options['data-role'] = 'duajaxupload';
?>
<?=Html::beginTag('div', $options)?>
<div class='input-group'>
	<?= $input ?>
	<span class="input-group-btn">
		<button class="btn btn-default" data-toggle="duajaxupload" type="button"><?= Yii::t('da', 'Select File') ?></button>
		<input type="file" style="display: none" />
	</span>
</div>
<div class="cropper-dialog">
	<div class="cropper">
		<div class="cropper-image-box">
		</div>
	</div>
	<div class="cropper-buttons">
		<button type="button" class="btn btn-default" data-dismiss="duajaxupload">取消</button>
		<button type="button" class="btn btn-primary" data-upload="duajaxupload">确定</button>
	</div>
</div>
<?=Html::endTag('div')?>