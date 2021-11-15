+ function($) {
    var SimpleModal = function(el, options) {
        this.options = options;
        this.$modal = $(el);
        this.$pjaxContainer = null;
        this.$pjaxId = null;
        this.handleHidden();
        this.handleShow();
        this.handleSubmit();
    }

    SimpleModal.prototype.handleHidden = function() {
        // 清空对象
        this.$modal.on('hidden.bs.modal', (e) => {
            this.$modal.data('bs.modal', null);
            this.$modal.find('.modal-body').empty();
            this.$modal.find('script').remove();
            this.$modal.find('link').remove();
            this.$pjaxContainer = null;
            this.pjaxId = null;
        });
    }

    SimpleModal.prototype.handleShow = function() {
        // 根据属性调整modal窗口大小
        this.$modal.on('show.bs.modal', (e) => {
            var targetBtn = $(e.relatedTarget);
            if (targetBtn.attr('data-toggle') == 'modal') {
                this.pjaxId = targetBtn.data("pjax-target");
                if (this.pjaxId) {
                    this.$pjaxContainer = $('#' + this.pjaxId);
                } else {
                    this.$pjaxContainer = targetBtn.parents('[data-pjax-container]');
                    this.pjaxId = this.$pjaxContainer.attr("id");
                }
                if (this.options.debug) {
                    console.log('simple modal debug: pjax container');
                    console.log(this.$pjaxContainer);
                }
                var size = targetBtn.data('modal-size');
                $(e.target).find('.modal-dialog').removeClass('modal-sm modal-lg').addClass(size ? size : '');
            }
        });
    }

    SimpleModal.prototype.handleSubmit = function() {
        //阻拦默认的表单提交事件，自动替换为pjax请求
        this.$modal.on('submit', 'form', (event) => {
            event.preventDefault();
            $(event.target).ajaxSubmit({
                headers: { 'AJAX-SUBMIT': 'AJAX-SUBMIT' },
                success: (data) => {
                    var type = "error";
                    if (data.status == 'success') {
                        //自定义处理结果
                        if (typeof this.options.customHandleResult == 'function') {
                            this.options.customHandleResult.call(this, data);
                        } else {
                            if (this.$pjaxContainer && this.$pjaxContainer.length > 0) {
                                this.handleResult(data);
                            } else {
                                window.location.reload();
                            }
                        }
                        this.$modal.modal('hide');
                        type = "success";
                    }
                    if (this.options.debug) {
                        console.log('simple modal debug: notify');
                        console.log(type);
                        console.log(data);
                    }
                    notif({ type: type, msg: data.message, position: this.options.notifyPosition, timeout: this.options.timeout });
                }
            });
        });
    }

    SimpleModal.prototype.handleResult = function(response) {
        if (this.options.debug) {
            var pjaxId = this.$pjaxContainer.attr('id');
            console.log('simple modal debug: pjax id');
            console.log(pjaxId);
        }
        if (!!this.pjaxId) {
            var url = this.$pjaxContainer.data("url");
            if (url) {
                $.pjax({ url: url, container: '#' + this.pjaxId });
            } else {
                $.pjax.reload('#' + this.pjaxId);
            }
        } else {
            console.log("pjax not container id");
        }
    }

    SimpleModal.DEFAULTS = {
        debug: false, //是否调试
        notifyPosition: 'center', //通知位置
        customHandleResult: false,
        timeout: 3000
    }

    function Plugin(option) {
        return this.each(function() {
            var $this = $(this)
            var data = $this.data('bs.simpleModal')
            if (!data) {
                var options = $.extend({}, SimpleModal.DEFAULTS, $this.data(), typeof option == 'object' && option);
                $this.data('bs.simpleModal', (data = new SimpleModal(this, options)))
            }
            if (typeof option == 'string') data[option].call(data)
        })
    }
    var old = $.fn.simpleModal

    $.fn.simpleModal = Plugin
    $.fn.simpleModal.Constructor = SimpleModal


    // NO CONFLICT
    // =================

    $.fn.simpleModal.noConflict = function() {
        $.fn.simpleModal = old
        return this
    }

}(jQuery)