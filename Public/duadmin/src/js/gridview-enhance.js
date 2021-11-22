/**
 * yiigridview的批量编辑，在按钮上添加.batch-update样式，
 * 该事件会更新按钮的url
 */
$(document).on('click', '.batch-update', function(e) {
    e.preventDefault();
    var that = $(this);
    var data = that.data();
    var gridView = $(data.target);
    var gridViewData = gridView.yiiGridView('data');
    var field = escape(gridViewData.selectionColumn);
    var ids = gridView.yiiGridView("getSelectedRows").map(function(id) {
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
 * 批量删除按钮
 * 需要在data属性配置 gridview的id
 * data-target="#gridviewId"
 */
$(document).on('click', '.del-all', function(e) {
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
                success: function(msg) {
                    window.location.reload();
                }
            });
        }
    }

});

/**
 * 刷新按钮
 */
$(document).on('click', '[data-sync]', function(event) {
    event.preventDefault();
    var targetBtn = $(this);
    $.post(targetBtn.attr('href'), function(data) {
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