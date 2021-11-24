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
        this.handleCreateForm();
        this.handleSelectChange();
        this.handleInputChange();
        this.handleRemove();
    }

    AdvanceSelect.prototype.init = function() {
        this.$formButton = this.$element.find('a[create-form]');
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

    AdvanceSelect.prototype.handleCreateForm = function() {
        var options = this.options;
        this.$formButton.on('click', function(e) {
            var that = $(this);
            e.preventDefault();
            layer.open({
                type: 2,
                title: options.formTitle,
                maxmin: false,
                shadeClose: true, //点击遮罩关闭层
                scrollbar: false, //屏蔽滚动条
                area: options.formArea,
                content: that.attr("href"),
            });
        });
    }

    AdvanceSelect.prototype.handleInputChange = function() {
        var url = this.options.resultLoadUrl + "?" + this.$input.attr("name") + '=' + this.$input.val();
        $.pjax({ url: url, container: '#' + this.options.pjaxId, push: false, scrollTo: false, async: false })
    }

    AdvanceSelect.prototype.handleSelectChange = function() {
        this.$select.on('change', (e) => {
            this.addOne(this.$select.val());
        })
    }

    AdvanceSelect.prototype.addOne = function(val) {
        var vals = this.$input.val();
        var ids = vals.split(',').filter((id) => { return !!id })
        ids.push(val);
        this.$input.val(ids.distinct().join(','));
        this.handleInputChange();
    }

    AdvanceSelect.prototype.handleSubmit = function(data) {
        var val = this.options.onSubmitSuccess.call(this, data);
        console.log("AdvanceSelect Handle Submit receiver val: " + val)
        if (!!val) {
            this.addOne(val);
            layer.closeAll();
        }
    }

    /**
     * 删除选择的结果
     */
    AdvanceSelect.prototype.handleRemove = function() {
        var that = this;
        this.$element.on('click', 'a[remove]', function(e) {
            e.preventDefault();
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
        inputType: 'hidden',
        resultLoadUrl: '', //选择的结果数据加载地址
        optionLoadUrl: '', //下拉框选择项数据加载地址
        pjaxId: '', //数据预览容器id
        formTitle: "添加",
        formArea: ['800px', '600px'], //layer 宽度 高度 
        onSubmitSuccess: function(data) { console.log(data) }
    }

    function Plugin(option, param) {
        return this.each(function() {
            var $this = $(this)
            var data = $this.data('bs.advanceSelect')
            if (!data) {
                var options = $.extend({}, AdvanceSelect.DEFAULTS, $this.data(), typeof option == 'object' && option);
                $this.data('bs.advanceSelect', (data = new AdvanceSelect(this, options)))
            }
            if (typeof option == 'string') data[option].call(data, param)
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