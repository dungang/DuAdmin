(function($) {

    function process(options) {
        var _this = this;
        options.data['timestamp'] = Math.round(new Date().getTime() / 1000);
        $.ajax({
            url: options.url,
            method: options.method,
            data: options.data,
            dataType: options.dataType,
            error: function(xhr, textStatus, errorThrown) {
                options.onTimeout.call(_this, options, xhr, textStatus, errorThrown);
                if (options.repeat) {
                    setTimeout(function() {
                        process.call(_this, options)
                    }, options.interval);
                }
            },
            success: function(data, textStatus) {
                if (textStatus == "success") { // 请求成功
                    options.onSuccess.call(_this, data, textStatus, options);
                    if (options.repeat) {
                        var tm = setTimeout(function() {
                            process.call(_this, options);
                            clearTimeout(tm);
                        }, options.interval);
                    }
                }
            }
        });

    }

    $.fn.longpoll = function(options) {
        return this.each(function() {
            var _this = $(this);
            var opts = $.extend({}, $.fn.longpoll.Default, options, _this.data());
            if (opts.now === true) {
                process.call(_this, opts);
            } else {
                var tm = setTimeout(function() {
                    process.call(_this, opts);
                    clearTimeout(tm);
                }, options.interval);
            }
        });
    };

    $.fn.longpoll.Default = {
        now: true, //是否立刻执行
        interval: 2000,
        dataType: 'text',
        method: 'get',
        data: {},
        repeat: true,
        onTimeout: $.noop,
        onSuccess: $.noop
    };
})(jQuery);