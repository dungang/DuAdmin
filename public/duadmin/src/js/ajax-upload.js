+function ($) {
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
  var DuAjaxUpload = function (el, options) {
    var that = this;
    this.options = options;
    this.$element = $(el);
    this.formData = new FormData();

    this.$fileInput = this.$element.find('input[type="file"]');
    this.$textInput = this.$element.find('input[type="text"]');
    var closeCallback = function () {
      that.close();
    }
    this.$element.on('click', dismiss, closeCallback);
    var changeCallback = function (e) {
      that.file = e.currentTarget.files[0];

      that.extension = getExtension(that.file.name);
      if (isImage(that.file.type)) {
        that.$dialog = that.$element.find('.cropper-dialog');
        that.$imageBox = that.$element.find('.cropper-image-box');
        that.$area = that.$dialog.find('.cropper-area');
        that.showCropper();
        that.$dialog.show();
      } else {
        that.formData.append("file", that.file);
        that.uploadFile();
      }
    }
    this.$fileInput.on('change', changeCallback);
    var okCallback = function (e) {
      if (that.$cropper) {
        var targetImage = that.$cropper.cropper('getCroppedCanvas');
        if (that.options.compress) {
          targetImage = that.compress(targetImage)
        }
        targetImage.toBlob(function (blob) {

          that.formData.append('file', blob, that.file.name);
          that.uploadFile();
        });
      }
      that.close();
    }
    this.$element.on('click', ok, okCallback);
  }

  DuAjaxUpload.DEFAULTS = {
    imageHeight: 300, //目标图标高度，如不compress=true 表示像素，否则表示高度占比单位大小
    imageWidth: 300, //目标图片宽度，如不compress=true 表示像素，否则表示宽度度占比单位大小
    compress: true, //是否压缩
  }

  DuAjaxUpload.prototype.compress = function (img) {
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

  DuAjaxUpload.prototype.uploadFile = function () {
    var that = this;
    var fileType = this.$textInput.attr('data-type');
    var tokenUrl = this.$textInput.attr('data-token-url');
    $.get(tokenUrl, { fileType: fileType }, function (data) {
      var key = data.key + "." + that.extension;
      that.formData.append(DUA.uploader.keyName, key);
      that.formData.append(DUA.uploader.tokenName, data.token);
      $.ajax({
        url: DUA.uploader.uploadUrl,
        dataType: 'json',
        type: 'POST',
        async: false,
        data: that.formData,
        processData: false, // 使数据不做处理
        contentType: false, // 不要设置Content-Type请求头
        success: function (data) {
          //if (data.hash) {
          alert('上传成功！');
          that.$textInput.val(DUA.uploader.baseUrl + key);
          //}
        },
        error: function (response) {
          console.log(response);
        }
      });
    });
  }

  DuAjaxUpload.prototype.showCropper = function () {
    var that = this;
    var reader = new FileReader();
    reader.addEventListener('load', function () {
      that.img = new Image();
      that.img.src = this.result;
      that.$imageBox.html(that.img);
      var rate = (that.options.imageWidth / that.options.imageHeight).toFixed(2);
      that.$cropper = $(that.img).cropper({
        aspectRatio: rate
      });
    });
    reader.readAsDataURL(this.file);
  }

  DuAjaxUpload.prototype.selectFile = function () {
    this.$fileInput.trigger('click');
  }

  DuAjaxUpload.prototype.close = function () {
    if (this.$dialog) {
      this.$fileInput.val("");
      this.$dialog.hide();
    }
  }

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data = $this.data('bs.duAjaxUpload')
      if (!data) {
        var options = $.extend({}, DuAjaxUpload.DEFAULTS, $this.data(), typeof option == 'object' && option);
        console.log(options);
        $this.data('bs.duAjaxUpload', (data = new DuAjaxUpload(this, options)))
      }
      if (typeof option == 'string') data[option].call(data)
    })
  }
  var old = $.fn.duAjaxUpload

  $.fn.duAjaxUpload = Plugin
  $.fn.duAjaxUpload.Constructor = DuAjaxUpload


  // NO CONFLICT
  // =================

  $.fn.duAjaxUpload.noConflict = function () {
    $.fn.duAjaxUpload = old
    return this
  }


  // DATA-API
  // ==============
  var clickHandler = function (e) {
    e.preventDefault()
    var parent = $(this).parents('[data-role="duajaxupload"]');
    Plugin.call(parent, 'selectFile')
  }
  $(document).on('click.bs.duajaxupload.data-api', '[data-toggle="duajaxupload"]', clickHandler)
}(jQuery)