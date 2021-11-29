(function($) {

    function isNotEmptyObject(e) {
        var t;
        for (t in e)
            return true;
        return false;
    }

    function assembleOptions(data, value) {
        var options = '';
        for (var p in data) {
            var txt = data[p];
            //数组Array进行原型prototype扩展后带来的for in遍历问题
            if (typeof txt == 'function') {
                continue;
            }
            if (p == value) {
                options += "<option value='" + p + "' selected >" + txt + "</option>";
            } else {
                options += "<option value='" + p + "'>" + txt + "</option>";
            }
        }
        return options;
    }

    function process(queue) {
        var select = queue.shift();
        if (select == null)
            return;
        $self = $(select);
        var data = $self.data();
        $self.empty(); // 清空自己
        var param = {};
        if (data.parentId != null && data.param) {
            param[data.param] = data.parentId;
        } else if (data.parent && data.param) {
            var parent = $(data.parent);
            var parent2 = $(parent.data('parent'));
            if (parent && data.url && parent.val() != null) {
                param[data.param] = parent.val();
            } else if (parent2 && data.url && parent2.val() != null) {
                param[data.param] = parent2.val();
            }
        } else {
            //alert('连级下拉框参数配置不正确:' + $self.attr('name'));
            $.showLayerMsg('连级下拉框参数配置不正确:' + $self.attr('name'),2,3000)
            return;
        }
        if (isNotEmptyObject(param)) {
            $.getJSON(data.url, param, function(res) {
                $self.append(assembleOptions(res, data.value));
                process(queue);
            });
        }
    }

    function initRoot() {
        var root = $('select[data-linkage=root]');
        if (root.length > 0) {
            var queue = [root];
            var subs = root.data('queue').split(',');
            if (!!subs) {
                for (var sub of subs) {
                    queue.push(sub);
                }
            }
            process(queue);
        }
    }

    $.fn.linkageSelect = function() {
        $(document).off('change.site.linkage');
        initRoot();
        $(document).on('change.site.linkage', 'select[data-linkage]', function() {
            var subs = $(this).data('queue');
            if (!!subs) {
                var queue = subs.split(',');
                process(queue);
            }
        });
    }
})(jQuery);