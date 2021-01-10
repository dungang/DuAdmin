+function ($) {
    $(window).on('load', function () {
        $('.nav-affix').affix({
            offset: {
                top: 50,
                bottom: function () {
                    return (this.bottom = $('.footer').outerHeight(true))
                }
            }
        }).on('affixed.bs.affix', function () {
            $(this).removeClass('navbar-inverse')
                .addClass('navbar-default');
        }).on("affixed-top.bs.affix", function () {
            $(this).removeClass('navbar-default')
                .addClass('navbar-inverse');
        });
    })
}(jQuery);