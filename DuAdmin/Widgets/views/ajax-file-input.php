<?php
/* @var string $input */
/* @var string $src */
/* @var boolean $isImage */
/* @var array $options */

use yii\helpers\Html;

$options['class'] = 'ajax-file-input';
$options['data-role'] = 'duajaxupload';
?>
<?= Html::beginTag('div', $options) ?>
<div class='input-group'>
	<?= $input ?>
	<span class="input-group-btn">
		<button class="btn btn-default" data-toggle="duajaxupload" type="button"><?= Yii::t('da', 'Select File') ?></button>
		<input type="file" style="display: none" />
	</span>
</div>
<?php if ($isImage && $src) : ?>
	<div class="image-preview">
		<?= Html::img($src) ?>
	</div>
<?php endif; ?>
<div class="cropper-dialog">
	<div class="cropper">
		<div class="cropper-image-box">
		</div>
	</div>
	<div class="cropper-buttons">
		<button type="button" class="btn btn-default" data-dismiss="duajaxupload"><?= Yii::t('da', 'Cancel') ?></button>
		<button type="button" class="btn btn-primary" data-upload="duajaxupload"><?= Yii::t('da', 'Ok') ?></button>
	</div>
</div>
<?= Html::endTag('div') ?>