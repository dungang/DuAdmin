
+ function ($) {

    $.fn.cateTabs = function (options) {
        return this.each(function () {
            var that = $(this);
            var def_index = 0;
            var tabs = that.find('.tabs .tab').each(function(i){
                if($(this).attr('tab-index',i).hasClass('active')){
                    def_index = i;
                };
            });
            var contents = that.find('.contents .content');
            $(contents[def_index]).addClass('active');
            tabs.on("click",function (e) {
                tabs.removeClass('active');
                var index = $(this).addClass('active').attr('tab-index');
                contents.removeClass('active');
                $(contents[index]).addClass('active');
            });
        });
    }

}(jQuery);


$(document).ready(function(){
    $('.cate-tabs').cateTabs();
});