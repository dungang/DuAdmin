+ function ($) {
    $.fn.dashboardWidget = function (url) {
        return this.each(function () {
            var widget = $(this);
            var id = widget.data("dashboardWidget");
            $.get(url, {
                id: id
            }, function (data) {
                widget.html(data);
            });
        })
    }
}(jQuery);