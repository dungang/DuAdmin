<?= $input ?>
<input type="file" style="display: none" multiple />
<button type="button" class="btn btn-primary images-upload-input__upload">上传</button>
<button type="button" class="btn btn-default images-upload-input__select">选择</button>
<div class="images-upload-input__image-list">
    <div class="images-upload-input__image uploading" data-id="0">
        <div class="images-upload-input__icon"><img src="/images/file.png"></div>
        <div class="images-upload-input__name">image</div>
        <div class="images-upload-input__status"><i class="fa fa-spinner"></i></div>
        <div class="images-upload-input__remove"><i class="fa fa-trash"></i></div>
    </div>
    <div class="images-upload-input__image error" data-id="1">
        <div class="images-upload-input__icon"><img src="/images/file.png"></div>
        <div class="images-upload-input__name">image</div>
        <div class="images-upload-input__status"><i class="fa fa-frown-o"></i></div>
        <div class="images-upload-input__remove"><i class="fa fa-trash"></i></div>
    </div>
</div>