/**
 * 批量加载
 */
(function($) {
    $.fn.batchLoad = function(options) {
        return this.each(function() {
            var _this = $(this);
            var opts = $.extend({}, $.fn.batchLoad.Default, options, _this.data());
            var url = _this.attr('href');
            var hasQuery = url.indexOf('?') > -1;
            _this.on('click', function(e) {
                e.preventDefault();
                var idObjs = $('input[name=' + opts.key + '\\[\\]]:checked').map(function(idx, obj) {
                    return obj.value;
                });

                if (idObjs.length == 0) {
                    alert("请选择加载的条目，否则不能进行操作");
                } else {
                    var ids = $.makeArray(idObjs);
                    if (hasQuery) {
                        url += '&id=' + ids.join();
                    } else {
                        url += '?id' + ids.join();
                    }

                    $.get(url, function(response) {
                        var modal = $(opts.modal);
                        modal.find('.modal-content').html(response);
                        modal.modal('show');
                    });

                }
            });
        });
    };
    $.fn.batchLoad.Default = {
        key: 'id',
        modal: '#modal-dialog'
    };
})(jQuery);