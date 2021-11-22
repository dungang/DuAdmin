(function($) {
    function replaceIndex(clone) {
        var regexID = /\-\d{1,}\-/gmi;
        var regexName = /\[\d{1,}\]/gmi;
        var size = this.data('index');
        var html = clone.html().replace(regexName, '[' + size + ']').replace(regexID, '-' + size + '-');
        size = size + 1;
        this.data('index', size);
        clone.html(html);
        return clone;
    }

    $.fn.dynamicLine = function(options) {
        return this.each(function() {
            var _container = $(this);
            var opts = $.extend({}, $.fn.dynamicLine.DEF, options, _container.data());
            _container.on('click', '.delete-self', function(e) {
                e.preventDefault();
                var _this = $(this);
                var target_obj = _this.parents(opts.target);
                var targets = _container.find(opts.target);
                if (targets.length > 2) {
                    target_obj.remove();
                }
            }).on('click', '.copy-self', function(e) {
                e.preventDefault();
                var _this = $(this);
                var target_obj = _this.parents(opts.target);
                var clone = target_obj.clone();
                console.log(clone);
                if (opts.onCopy) {
                    clone = opts.onCopy.call(_container, clone);
                }
                clone.insertAfter(target_obj);
            });
        });
    };

    $.fn.dynamicLine.DEF = {
        onCopy: replaceIndex
    };
})(jQuery);