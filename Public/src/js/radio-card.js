+ function($) {

    $.fn.radioCard = function() {
        return this.each(function() {
            var cardContainer = $(this);
            triggerActiveCard(cardContainer);
            cardContainer.find('input[type=radio]').on("click", function(e) {
                console.log($(this).prop("checked"));
                triggerActiveCard(cardContainer);
            });
        });
    }

    function triggerActiveCard(cardContainer) {
        cardContainer.find('.radio-card').removeClass("active");
        var radio = cardContainer.find('input[type=radio]:checked');
        console.log(radio);
        if (radio.length > 0) {
            console.log(radio.parents('.radio-card'));
            radio.parents('.radio-card').addClass("active");
        }
    }

    // // role=radio-card
    // $(document).on('click', ".radio-card", function(e) {
    //     e.preventDefault();
    //     $(this).find('input[type=radio]').trigger('click');
    // });
}(jQuery);