(function ($) {

    $.fn.navbarAffix = function (defClass, affixClass) {
        return this.each(function () {
            var navbar = $(this);
            navbar.affix({
                offset: {
                    top: 50,
                    bottom: function () {
                        return (this.bottom = $('.footer').outerHeight(true))
                    }
                }
            }).on('affixed.bs.affix', function () {
                if (!$(this).data('affix-one')) {
                    $(this).removeClass(defClass)
                        .addClass(affixClass);
                }
            }).on("affixed-top.bs.affix", function () {
                if (!$(this).data('affix-one')) {
                    $(this).removeClass(affixClass)
                        .addClass(defClass);
                }
            });
        })
    }
})(jQuery);