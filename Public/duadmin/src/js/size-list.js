(function($) {
    'use strict';

    $.fn.sizeList = function() {
        return this.each(function() {
            var _this = $(this);
            var hiddenInput = _this.find('input[type=hidden]');
            var checkboxList = _this.find('input[type=checkbox]');
            checkboxList.on('change', function() {
                var items = [];
                for (var i = 0; i < checkboxList.length; i++) {
                    if (checkboxList[i].checked) {
                        items.push(checkboxList[i].value);
                    }
                }
                hiddenInput.val(items.join(','));
            });
        });
    };
})(jQuery);