(function($) {
    'use strict';

    function isImage(type) {
        return type.substr(0, 5) == 'image';
    }

    function getExtension(fileName) {
        var index = fileName.lastIndexOf(".");
        return fileName.substr(index + 1);
    }
    var dismiss = '[data-dismiss="duajaxupload"]'
    var ok = '[data-upload="duajaxupload"]'
    var toggleElm = '[data-toggle="duajaxupload"]';
    var DuAjaxUpload = function(el, options, toggleButton) {
        var that = this;
        this.options = options;
        this.$element = $(el);
        this.formData = new FormData();

        this.$fileInput = this.$element.find('input[type="file"]');
        this.$fileInput.attr('accept', options.accept);
        this.$textInput = this.$element.find('input[type="text"]');
        this.$previewList = this.$element.find('.ajax-file-input__preview-list');

        this.$realUploadBtn = toggleButton ? toggleButton : this.$element.find(toggleElm);

        var closeCallback = function() {
            that.close();
        }
        this.$element.on('click', dismiss, closeCallback);
        var changeCallback = function(e) {
            that.file = e.currentTarget.files[0];
            that.extension = getExtension(that.file.name);
            //是图片如不设置了裁剪的高和宽度，则显示裁剪工具框，否则直接上传
            if (isImage(that.file.type)) {
                that.$dialog = that.$element.find('.ajax-file-input__cropper-dialog');
                that.$imageBox = that.$element.find('.ajax-file-input__cropper-image-box');
                that.$area = that.$dialog.find('.ajax-file-input__cropper-area');
                that.showCropper();
                that.$dialog.show();
            } else {
                that.formData.set("file", that.file);
                that.uploadFile();
            }
        }
        this.$fileInput.on('change', changeCallback);
        var okCallback = function(e) {
            that.$realUploadBtn = $(this);
            if (that.$cropper) {
                var targetImage = that.$cropper.cropper('getCroppedCanvas');
                //如果配置了压缩图片
                if (that.options.compress) {
                    targetImage = that.compress(targetImage)
                }
                targetImage.toBlob(function(blob) {
                    that.formData.set('file', blob, that.file.name);
                    that.uploadFile();
                });
            } else {
                that.formData.set('file', that.file);
                that.uploadFile();
            }
            that.close();
        }
        this.$element.on('click', ok, okCallback);
    }

    DuAjaxUpload.DEFAULTS = {
        clip: true, //是否裁剪
        imageHeight: 300, //目标图标高度，如不compress=true 表示像素，否则表示高度占比单位大小
        imageWidth: 300, //目标图片宽度，如不compress=true 表示像素，否则表示宽度度占比单位大小
        compress: true, //是否压缩,
        accept: 'image/*',
        multi: false,
        onBeforeUpload: function() {},
        onUploadProgress: function() {},
        onUploadSuccess: function() {},
        onUploadError: function() {},
        onComplete: function() {},
    }

    DuAjaxUpload.prototype.createImagePrivewBox = function(src) {
        return $('<div class="ajax-file-input__image-preview"><img src="' + src + '" /><div class="ajax-file-input__remove"><i class="fa fa-trash"></i></div></div>')
    }

    DuAjaxUpload.prototype.compress = function(img) {
        var canvas = document.createElement('canvas')
        var context = canvas.getContext('2d')
            // 设置宽高度为等同于要压缩图片的尺寸
        canvas.width = this.options.imageWidth;
        canvas.height = this.options.imageHeight;
        context.clearRect(0, 0, canvas.width, canvas.height);
        //将img绘制到画布上
        context.drawImage(img, 0, 0, canvas.width, canvas.height);
        return canvas;
    }

    DuAjaxUpload.prototype.uploadFile = function() {
        var that = this;
        if (that.$realUploadBtn) {
            $(that.$realUploadBtn).button('上传中...');
            console.log($(that.$realUploadBtn))
            console.log('uploading ...')
        }
        var fileType = this.$textInput.attr('data-type');
        var tokenUrl = this.$textInput.attr('data-token-url');
        var canProccess = this.options.onBeforeUpload.call(this.element, this.file);
        if (canProccess !== false) {
            $.get(tokenUrl, {
                fileType: fileType
            }, function(data) {
                var key = data.key + "." + that.extension;
                that.formData.set(DUA.uploader.keyName, key);
                that.formData.set(DUA.uploader.tokenName, data.token);
                $.ajax({
                    url: DUA.uploader.uploadUrl,
                    dataType: 'json',
                    type: 'POST',
                    async: false,
                    data: that.formData,
                    cache: false,
                    processData: false, // 使数据不做处理
                    contentType: false, // 不要设置Content-Type请求头
                    forceSync: false,
                    success: function(data) {
                        console.log(data);
                        that.options.onUploadSuccess.call(that, data);
                        $.showLayerMsg('上传成功！', 1, 3000);
                        var imgUrl = DUA.uploader.baseUrl + key;
                        if (that.options.multi) {
                            var oldUrls = that.$textInput.val().split(",").filter((url) => { return !!url });
                            oldUrls.push(imgUrl);
                            that.$textInput.val(oldUrls.join(","));
                            if (fileType == 'image') {
                                that.$previewList.append(that.createImagePrivewBox(imgUrl));
                            }
                        } else {
                            that.$textInput.val(imgUrl);
                            if (fileType == 'image') {
                                that.$previewList.html(that.createImagePrivewBox(imgUrl));
                            }
                        }
                        that.$fileInput.val("");
                        if (that.$realUploadBtn) {
                            that.$realUploadBtn.button('reset');
                        }
                    },
                    error: function(jqXHR) {
                        that.options.onUploadError.call(that, data);
                        $.showLayerMsg(jqXHR.responseJSON.message, 2, 3000);
                        if (that.$realUploadBtn) {
                            that.$realUploadBtn.button('reset');
                        }
                    },
                    complete: function(xhr, textStatus) {
                        that.options.onComplete.call(that, xhr, textStatus);
                    }
                });
            });
        }
    }

    DuAjaxUpload.prototype.showCropper = function() {
        var that = this;
        var reader = new FileReader();
        reader.addEventListener('load', function() {
            that.img = new Image();
            that.img.src = this.result;
            that.$imageBox.html(that.img);
            if (that.options.clip) {
                var rate = (that.options.imageWidth / that.options.imageHeight).toFixed(2);
                that.$cropper = $(that.img).cropper({
                    aspectRatio: rate
                });
            }
        });
        reader.readAsDataURL(this.file);
    }

    DuAjaxUpload.prototype.selectFile = function() {
        this.$fileInput.trigger('click');
    }

    DuAjaxUpload.prototype.close = function() {
        if (this.$dialog) {
            this.$fileInput.val("");
            this.$dialog.hide();
        }
    }

    DuAjaxUpload.prototype.remove = function($removeBtn) {
        var that = this;
        var $previewbox = $($removeBtn).closest('.ajax-file-input__image-preview');
        var src = $previewbox.find('img').attr('src');
        var inputVals = this.$textInput.val().split(",");
        //确认
        layer.confirm('确定移除?', { icon: 3, title: '提示' },
            //yes
            function(index) {
                inputVals.remove(src);
                that.$textInput.val(inputVals.join(","));
                $previewbox.remove();
                layer.close(index);
            }
        );
    }

    function Plugin(option, args) {
        return this.each(function() {
            var $this = $(this)
            var data = $this.data('bs.duAjaxUpload')
            if (!data) {
                var options = $.extend({}, DuAjaxUpload.DEFAULTS, $this.data(), typeof option == 'object' && option);
                $this.data('bs.duAjaxUpload', (data = new DuAjaxUpload(this, options)))
            }
            if (typeof option == 'string') data[option].call(data, args)
        })
    }
    var old = $.fn.duAjaxUpload

    $.fn.duAjaxUpload = Plugin
    $.fn.duAjaxUpload.Constructor = DuAjaxUpload


    // NO CONFLICT
    // =================

    $.fn.duAjaxUpload.noConflict = function() {
        $.fn.duAjaxUpload = old
        return this
    }


    // DATA-API
    // ==============
    var startHandle = function(e) {
        e.preventDefault()
        var parent = $(this).closest('[data-role="duajaxupload"]');
        Plugin.call(parent, 'selectFile', $(this))
    }
    var removeHandle = function(e) {
        e.preventDefault()
        var parent = $(this).closest('[data-role="duajaxupload"]');
        Plugin.call(parent, 'remove', $(this))
    }
    $(document).on('click.bs.duajaxupload.start-api', toggleElm, startHandle)
    $(document).on('click.bs.duajaxupload.remove-api', '.ajax-file-input__remove', removeHandle)
})(jQuery);