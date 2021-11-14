+ function($) {

    /**
     * 
     * @param string el 
     * @param object options 
     */
    var AdvanceSelect = function(el, options) {
        this.options = options;
        this.$element = $(el);
        this.init();
        this.handleSelectChange();
        this.handleInputChange();
        this.handleRemove();
    }

    AdvanceSelect.prototype.init = function() {
        this.$input = this.$element.find('input[type=' + this.options.inputType + ']');
        this.$pjaxContainer = this.$element.find('div[role=data-pjax-container]');
        this.$select = this.$element.find('select');
        //https://select2.org/data-sources/formats
        this.$select.select2({
            ajax: {
                url: this.options.optionLoadUrl,
                dataType: 'json'
            }
        });
    }

    AdvanceSelect.prototype.handleInputChange = function() {
        var url = this.options.resultLoadUrl + "?" + this.$input.attr("name") + '=' + this.$input.val();
        $.pjax({ url: url, container: '#' + this.options.pjaxId, push: false, scrollTo: false })
    }

    AdvanceSelect.prototype.handleSelectChange = function() {
        this.$select.on('change', (e) => {
            var val = new String(this.$input.val());
            var ids = val.split(',').filter((id) => { return !!id })
            ids.push(this.$select.val());
            this.$input.val(ids.distinct().join(','));
            this.handleInputChange();
        })
    }

    /**
     * 删除选择的结果
     */
    AdvanceSelect.prototype.handleRemove = function() {
        var that = this;
        console.log(this.$element)
        this.$element.on('click', 'a', function(e) {
            e.preventDefault();
            console.log(e)
            var removeButton = $(this);
            if (confirm("确定移除？")) {
                var val = that.$input.val();
                ids = val.trim().split(',').filter((id) => {
                    return !!id && id != removeButton.data('val');
                });
                that.$input.val(ids.join(','));
                that.handleInputChange();
            }
        })
    }

    AdvanceSelect.DEFAULTS = {
        inputType: 'text',
        resultLoadUrl: '', //选择的结果数据加载地址
        optionLoadUrl: '', //下拉框选择项数据加载地址
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