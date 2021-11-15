+ function($) {
    //https://layui.itze.cn/doc/modules/layer.html
    var loading = null;
    $(document).on('ajaxStart', function() {
        if (!loading) {
            loading = layer.load(0, {
                shade: [0.1, '#000'] //0.1透明度的白色背景
            })
        }
    });
    $(document).on('ajaxComplete', function() {
        if (loading) {
            layer.close(loading);
            loading = null;
        }
    });
}(jQuery);