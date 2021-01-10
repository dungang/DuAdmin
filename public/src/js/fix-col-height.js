/**
 * 解决栅格系统的col高度不同导致浮动的问题
 */

 +function($){

    var FixColHeight = function(el){
        this.$element = $(el);
        console.log(this.$element)
        this.$columns = this.$element.find('[class*="col-"]');
    }

    FixColHeight.prototype.resize = function(){
        var maxHeight = 0;
        this.$columns.height('auto');
        this.$columns.each(function(){
            var $col = $(this);
            var height = $col.height();
            if(height > maxHeight) {
                maxHeight = height;
            }
        });
        this.$columns.height(maxHeight);
    }

    function Plugin(option) {
        return this.each(function () {
          var $this = $(this)
          var data = $this.data('bs.fixcolheight')
          if (!data) {
            $this.data('bs.fixcolheight', (data = new FixColHeight(this)))
          }
          if (typeof option == 'string') data[option].call(data)
        })
    }
    var old = $.fn.fixColHeight

    $.fn.fixColHeight = Plugin
    $.fn.fixColHeight.Constructor = FixColHeight
  
    // NO CONFLICT
    // =================
    $.fn.fixColHeight.noConflict = function () {
      $.fn.fixColHeight = old
      return this
    }
  // DATA-API
  // ==============
  
   var reHeightHandler = function () {
    $('.fix-col-height').each(function () {
      Plugin.call($(this),'resize');
    })
  };
   $(window).on('load.bs.fixcolheight.data-api', reHeightHandler)
   $(window).on('resize.bs.fixcolheight.data-api', reHeightHandler)
 }(jQuery);