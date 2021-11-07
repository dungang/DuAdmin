/**
 * 联动选择下拉框 data-parent-id //默认上级值 data-parent //上级对象，和 parent-id二选一 data-url
 * //加载数据的地址 data-param //加载数据的参数 data-value //默认初始值，并不代表事最终逻辑值 data-queue
 * //顺序执行的对象队列
 */
Date.prototype.format = function (fmt) {
    var o = {
        "M+": this.getMonth() + 1, //月份
        "d+": this.getDate(), //日
        "h+": this.getHours(), //小时
        "m+": this.getMinutes(), //分
        "s+": this.getSeconds(), //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds() //毫秒
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
};

+

function ($) {

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
            alert('连级下拉框参数配置不正确:' + $self.attr('name'));
        }
        if (isNotEmptyObject(param)) {
            $.getJSON(data.url, param, function (res) {
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

    $.fn.linkageSelect = function () {
        $(document).off('change.site.linkage');
        initRoot();
        $(document).on('change.site.linkage', 'select[data-linkage]', function () {
            var subs = $(this).data('queue');
            if (!!subs) {
                var queue = subs.split(',');
                process(queue);
            }
        });
    }
}(jQuery);

+

function ($) {

    function process(options) {
        var _this = this;
        options.data['timestamp'] = Math.round(new Date().getTime() / 1000);
        $.ajax({
            url: options.url,
            method: options.method,
            data: options.data,
            dataType: options.dataType,
            error: function (xhr, textStatus, errorThrown) {
                options.onTimeout.call(_this, options, xhr, textStatus, errorThrown);
                if (options.repeat) {
                    setTimeout(function () {
                        process.call(_this, options)
                    }, options.interval);
                }
            },
            success: function (data, textStatus) {
                if (textStatus == "success") { // 请求成功
                    options.onSuccess.call(_this, data, textStatus, options);
                    if (options.repeat) {
                        var tm = setTimeout(function () {
                            process.call(_this, options);
                            clearTimeout(tm);
                        }, options.interval);
                    }
                }
            }
        });

    }

    $.fn.longpoll = function (options) {
        return this.each(function () {
            var _this = $(this);
            var opts = $.extend({}, $.fn.longpoll.Default, options, _this.data());
            if (opts.now === true) {
                process.call(_this, opts);
            } else {
                var tm = setTimeout(function () {
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
}(jQuery);

+

function ($) {
    $.fn.batchLoad = function (options) {
        return this.each(function () {
            var _this = $(this);
            var opts = $.extend({}, $.fn.batchLoad.Default, options, _this.data());
            var url = _this.attr('href');
            var hasQuery = url.indexOf('?') > -1;
            _this.click(function (e) {
                e.preventDefault();
                var idObjs = $('input[name=' + opts.key + '\\[\\]]:checked').map(function (idx, obj) {
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

                    $.get(url, function (response) {
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
}(jQuery);

+

function ($) {
    /**
     * Create or Delete a Row of List
     */
    $.fn.listrowcd = function (options) {
        return this.each(function () {
            var _this = $(this);
            var opts = $.extend({}, $.fn.listrowcd.Default, options, _this.data());
            // delete button
            _this.find(opts.delBtn).click(function (e) {
                e.preventDefault();
                var _delBtn = $(this);
                var _row = _delBtn.parents(opts.row);
                _row.fadeToggle('slow', function () {
                    _row.remove();
                });
            });
            _this.find(opts.createBtn).click(function (e) {
                e.preventDefault();
                var _createBtn = $(this);
                var _rows = _this.find(opts.row);
                var _lastRow = $(_rows[_rows.length - 1]);
                _lastRow.clone(true).insertAfter(_lastRow);
            });
        });
    };

    $.fn.listrowcd.Default = {
        delBtn: '.btn-del',
        createBtn: '.btn-create',
        row: 'tr',
    };
}(jQuery);

+

function ($) {
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

    $.fn.dynamicline = function (options) {
        return this.each(function () {
            var _container = $(this);
            var opts = $.extend({}, $.fn.dynamicline.DEF, options, _container.data());
            _container.on('click', '.delete-self', function (e) {
                e.preventDefault();
                var _this = $(this);
                var target_obj = _this.parents(opts.target);
                var targets = _container.find(opts.target);
                if (targets.length > 2) {
                    target_obj.remove();
                }
            }).on('click', '.copy-self', function (e) {
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

    $.fn.dynamicline.DEF = {
        onCopy: replaceIndex
    };
}(jQuery);

+

function ($) {
    'use strict';

    $.fn.sizeList = function () {
        return this.each(function () {
            var _this = $(this);
            var hiddenInput = _this.find('input[type=hidden]');
            var checkboxList = _this.find('input[type=checkbox]');
            checkboxList.change(function () {
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
}(jQuery);

/**
 * Created by dungang
 */
+

function ($) {

    'use strict';

    $.fn.selectBox = function () {
        return this.each(function () {
            var _this = $(this);
            var id = _this.attr('id');
            var sourceSearchInput = $('#' + id + '-source-search');
            var targetSearchInput = $('#' + id + '-target-search');
            var sourceSelect = $('#' + id + '-source');
            var targetSelect = $('#' + id + '-target');
            var yesButton = $('#' + id + '-btn-yes');
            var noButton = $('#' + id + '-btn-no');

            targetSelect.on('update', function () {
                targetSelect
                    .find('option')
                    .attr('selected', true);
            });

            sourceSearchInput.keyup(function () {
                var filter = sourceSearchInput.val().trim();
                sourceSelect.find('option').each(function () {
                    var _option = $(this);
                    if (_option.text().indexOf(filter) < 0) {
                        _option.attr('selected', false)
                            .css({
                                display: 'none'
                            });
                    } else {
                        _option.css({
                            display: 'block'
                        });
                    }
                });
            });

            targetSearchInput.keyup(function () {
                var filter = targetSearchInput.val().trim();
                targetSelect.find('option').each(function () {
                    var _option = $(this);
                    if (_option.text().indexOf(filter) < 0) {
                        _option.attr('selected', false)
                            .css({
                                display: 'none'
                            });
                    } else {
                        _option.css({
                            display: 'block'
                        });
                    }
                });
                targetSelect.trigger('update');
            });

            yesButton.click(function () {
                sourceSelect
                    .find('option:selected')
                    .appendTo(targetSelect);
                targetSelect.trigger('update');
            });

            noButton.click(function () {
                targetSelect
                    .find('option:selected')
                    .appendTo(sourceSelect);
            });

            targetSelect.trigger('update');

        });
    };

}(jQuery);
/**
 * yiigridview的批量编辑，在按钮上添加.batch-update样式，
 * 该事件会更新按钮的url
 */
$(document).on('click', '.batch-update', function (e) {
    e.preventDefault();
    var that = $(this);
    var data = that.data();
    var gridView = $(data.target);
    var gridViewData = gridView.yiiGridView('data');
    var field = escape(gridViewData.selectionColumn);
    var ids = gridView.yiiGridView("getSelectedRows").map(function (id) {
        return field + '=' + escape(id);
    });

    if (ids.length == 0) {
        alert('请选择条目，否则不能进行操作');
    } else {
        var reg = new RegExp('&?' + field + '=[\/a-zA-Z0-9]+', 'g');
        var baseUrl = that.data('url').replace(reg, '');
        baseUrl = baseUrl + '&' + ids.join('&');
        console.log(baseUrl);
        that.attr('href', baseUrl);
        $('#modal-dialog').modal({
            remote: baseUrl,

        });
    }
});

/**
 * 需要在data属性配置 gridview的id
 * data-target="#gridviewId"
 */
$(document).on('click', '.del-all', function (e) {
    e.preventDefault();
    var that = $(this);
    var data = that.data();
    var ids = $(data.target).yiiGridView("getSelectedRows");


    if (ids.length == 0) {
        alert('请选择条目，否则不能进行操作');
    } else {
        var params = {};
        if (!data.pk) {
            data.pk = 'id';
        }
        params[data.pk] = ids;
        if (confirm('确认删除么？')) {
            $.ajax({
                method: "POST",
                url: that.attr('href'),
                data: params,
                success: function (msg) {
                    window.location.reload();
                }
            });
        }
    }

});

$(document).on('submit', '.enable-ajax-form form', function (event) {
    event.preventDefault();
    var aform = $(event.target);
    var pjaxContainer = aform.parents('[data-pjax-container]');
    aform.ajaxSubmit({
        headers: {
            'AJAX-SUBMIT': 'AJAX-SUBMIT'
        },
        success: function (data) {
            var type = "error";
            if (data.status == 'success') {
                if (pjaxContainer) {
                    var pjaxId = pjaxContainer.attr('id');
                    $.pjax.reload('#' + pjaxId);
                }
                type = "success";
            }
            notif({
                type: type,
                msg: data.message,
                position: 'center',
                timeout: 3000
            });
        }
    });
});

$(document).on('click', '[data-sync]', function (event) {
    event.preventDefault();
    var targetBtn = $(this);
    $.post(targetBtn.attr('href'), function (data) {
        if (data.status == 'success') {
            var pjaxContainer = targetBtn.parents('[data-pjax-container]');
            if (pjaxContainer) {
                var pjaxId = pjaxContainer.attr('id');
                if (pjaxId != undefined) {
                    $.pjax.reload('#' + pjaxId);
                }
            }
        }
    });
});