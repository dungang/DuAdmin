+ function($) {

    /**
     * checkbox list 多选 全选的功能
     * @returns 
     */
    $.fn.checkboxSelection = function() {

        return this.each(function() {
            var plugin = $(this);
            var hiddenInput = plugin.find('input[type=hidden]');
            var allCheckbox = plugin.find('input[value=all]');
            var checkboxList = plugin.find('input[type=checkbox]');
            var length = checkboxList.length;
            checkboxList.on("click", function() {
                var checkbox = $(this);
                var checkedListOld = plugin.find('input[type=checkbox]:checked');
                if (checkbox.val() == 'all') {
                    if (checkbox.prop("checked")) {
                        checkboxList.prop("checked", true);
                    } else {
                        checkboxList.prop("checked", false);
                    }
                } else {
                    var allChecked = checkboxList.prop("checked");
                    if (allChecked && checkedListOld.length < length) {
                        allCheckbox.prop("checked", false);
                    } else if (!allChecked && checkedListOld.length < (length - 1)) {
                        allCheckbox.prop("checked", false);
                    } else {
                        allCheckbox.prop("checked", true);
                    }
                }
                var data = [];
                plugin.find('input[type=checkbox]:checked').each(function(idx, checkbox) {
                    data.push($(checkbox).val());
                });
                hiddenInput.val(data.join(","));
            })
        });
    }


}(jQuery);