+function ($) {
    function calcVideoSize() {
        $('.ifra-video, .iframe-video').each(function () {
            var _this = $(this);
            var parent = _this.parent();
            var p_width = parent.width();
            var s_width = _this.attr('width');
            var width = p_width > 510 ? s_width : p_width;
            var height = width * 488 / 866;
            _this.attr('width');
            _this.attr('width', width);
            _this.attr('height', height);
        });
    }
    $(window).on('load ', calcVideoSize);
    $(window).on('resize onorientationchange', calcVideoSize);
}(jQuery);