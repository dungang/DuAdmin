+ function($) {

    var AdvanceSelect = function(el, options) {
        this.options = options;
        this.$element = $(el);
        this.init();
        this.handleSelectChange();
    }

    AdvanceSelect.prototype.init = function() {
        this.$input = this.$element.find('input[type=hidden]');
        this.$select = this.$element.find('select');
        this.$pjaxContainer = this.$element.find('div[role=data-pjax-container]');
    }

    AdvanceSelect.prototype.handleInputChange = function() {
        var url = this.options.url + "?" + this.$input.attr("name") + '=' + this.$input.val();
        $.pjax({ url: url, container: '#' + this.options.pjaxId })
    }

    AdvanceSelect.prototype.handleSelectChange = function() {
        this.$select.on('change', (e) => {
            var val = this.$input.val();
            ids = val.trim().split(',').filter((id) => {!!id });
            ids.push(this.$select.val());
            this.$input.val(ids.join(','));
            this.handleInputChange();
        })
    }

    AdvanceSelect.DEFAULTS = {
        url: '', //数据加载地址
        pjaxId: '', //数据预览容器id
    }

    function Plugin(option) {
        return this.each(function() {
            var $this = $(this)
            var data = $this.data('bs.advanceSelect')
            if (!data) {
                var options = $.extend({}, AdvanceSelect.DEFAULTS, $this.data(), typeof option == 'object' && option);
                $this.data('bs.advanceSelect', (data = new AdvanceSelect(this, options)))
            }
            if (typeof option == 'string') data[option].call(data)
        })
    }
    var old = $.fn.advanceSelect

    $.fn.advanceSelect = Plugin
    $.fn.advanceSelect.Constructor = AdvanceSelect


    // NO CONFLICT
    // =================

    $.fn.advanceSelect.noConflict = function() {
        $.fn.advanceSelect = old
        return this
    }
}(jQuery)