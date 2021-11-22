+ function($) {
    /**
     * layer ui 的表单的强化，将表单的submit拦截为ajax请求
     * 成功之后，触发父窗口指定的元素的submitSuccess事件方法
     * @returns 
     */
    $.fn.layerFormPage = function() {
        return this.each(function() {
            var that = $(this);
            var parentHtmlId = that.data("targetHtmlId");
            //阻拦默认的表单提交事件，自动替换为ajax请求
            that.on('submit', 'form', (event) => {
                event.preventDefault();
                $(event.target).ajaxSubmit({
                    headers: { 'AJAX-SUBMIT': 'AJAX-SUBMIT' },
                    success: (data) => {
                        var type = "error";
                        if (data.status == 'success') {
                            type = "success";
                        }
                        showMsg(data.message, type == "success" ? 1 : 2, 3000);
                        if (data.status == 'success') {
                            //自定义处理结果
                            //每个窗口的jquery 对象是不一样的，必须应用父窗口的jquery
                            var parentElement = window.parent.jQuery(parentHtmlId, window.parent.document);
                            if (parentElement.length == 0) {
                                showMsg("表单页的定义的父窗口的容器Id错误:" + parentHtmlId, 2, 3000);
                            }
                            parentElement.advanceSelect('handleSubmit', data);
                        }
                    },
                    error: (xhr, status, error) => {
                        showMsg(xhr.responseJSON.message, 2, 3000);
                    }
                });
            });
        });
    }

    function showMsg(message, icon, timeout) {
        layer.msg(message, {
            skin: 'layui-layer-molv',
            icon: icon,
            time: timeout
        });
    }
}(jQuery)