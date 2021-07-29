if ($) {
    $(document).ready(function() {
        $('.swiper-container').each(function() {
            var slick = $(this);
            var options = slick.parents('.du-live-layout').data('options');
            slick.slick(options);
        });
    });
}