+ function($) {
    $(window).on('load', function() {
        var $affix = $('.nav-affix');
        var defClass = 'navbar-inverse';
        var affixClass = 'navbar-default';
        if ($affix.hasClass('navbar-default')) {
            defClass = 'navbar-default';
        }
        if (defClass == 'navbar-inverse') {
            affixClass = 'navbar-default';
        } else {
            affixClass = 'navbar-inverse';
        }
        $('.nav-affix').affix({
            offset: {
                top: 50,
                bottom: function() {
                    return (this.bottom = $('.footer').outerHeight(true))
                }
            }
        }).on('affixed.bs.affix', function() {
            if (!$(this).data('affix-one')) {
                $(this).removeClass(defClass)
                    .addClass(affixClass);
            }
        }).on("affixed-top.bs.affix", function() {
            if (!$(this).data('affix-one')) {
                $(this).removeClass(affixClass)
                    .addClass(defClass);
            }
        });
    })
}(jQuery);