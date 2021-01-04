+function($){
    'use strict';
    function isImage(type){
        return type.substr(0,5) == 'image';
     }
    var dismiss = '[data-dismiss="ajax-upload"]'
    var DuAjaxUpload   = function (el) {
        this.$element = $(el);
        this.$element.on('click', dismiss, this.close);
        this.$element.on('change','input[type="file"]',this.upload);
    }

    DuAjaxUpload.prototype.upload = function(e) {
        var file = e.currentTarget.files[0];
        if(isImage(file.type)) {
            console.log(e)
            $(e.delegateTarget).find('.cropper-dialog').show();
        }
    }

    DuAjaxUpload.prototype.selectFile = function(){
        console.log(this.$element);
        this.$element.find('input[type="file"]').trigger('click');
    }

    DuAjaxUpload.prototype.close = function(e) {
        e.preventDefault();
        var $this = $(this);
        $this.parents('.cropper-dialog').hide();
    }

    function Plugin(option) {
        return this.each(function () {
          var $this = $(this)
          var data  = $this.data('bs.duAjaxUpload')
    
          if (!data) $this.data('bs.duAjaxUpload', (data = new DuAjaxUpload(this)))
          if (typeof option == 'string') data[option].call(data)
        })
      }
var old = $.fn.duAjaxUpload

  $.fn.duAjaxUpload             = Plugin
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
    Plugin.call(parent,'selectFile')
  }
  $(document).on('click.bs.duajaxupload.data-api', '[data-toggle="duajaxupload"]',clickHandler)
}(jQuery)