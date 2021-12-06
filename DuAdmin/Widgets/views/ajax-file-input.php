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
        <button class="btn btn-default" data-toggle="duajaxupload" type="button" autocomplete="off"><?= Yii::t('da', 'Select File') ?></button>
        <input type="file" style="display: none" />
    </span>
</div>
<div class="ajax-file-input__preview-list">
    <?php if ($isImage && $src) {
        foreach ($src as $one) {
            if (is_array($one)) {
                echo Html::tag('div', '<img src="/images/file-icon.png" /><div class="ajax-file-input__remove"><i class="fa fa-trash"></i></div>', ['class' => 'ajax-file-input__image-preview', 'data-url' => $one['url'], 'data-name' => $one['name']]);
            } else {
                echo Html::tag('div', Html::img($one) . '<div class="ajax-file-input__remove"><i class="fa fa-trash"></i></div>', ['class' => 'ajax-file-input__image-preview']);
            }
        }
    } ?>
</div>
<div class="ajax-file-input__cropper-dialog">
    <div class="ajax-file-input_cropper-content">
        <div class="ajax-file-input__cropper">
            <div class="ajax-file-input__cropper-image-box">
            </div>
        </div>
        <div class="ajax-file-input__cropper-buttons">
            <button type="button" class="btn btn-default" data-dismiss="duajaxupload" autocomplete="off"><?= Yii::t('da', 'Cancel') ?></button>
            <button type="button" class="btn btn-primary" data-upload="duajaxupload" autocomplete="off"><?= Yii::t('da', 'Ok') ?></button>
        </div>
    </div>
</div>
<?= Html::endTag('div') ?>