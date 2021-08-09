+ function($) {
    'use strict';
    var toolbar = '<div class="du-live-editor-toolbar" contenteditable="false">' +
        '<div class="du-live-move"><i class="fa fa-arrows"></i></div>' +
        '<div class="du-live-del"><i class="fa fa-trash-o"></i></div>' +
        '<div class="du-live-edit"><i class="fa fa-edit"></i></div>' +
        '<div class="du-live-add-bef"><i class="fa fa-plus"></i> 前</div>' +
        '<div class="du-live-add-aft"><i class="fa fa-plus"></i> 后</div>' +
        '</div>';

    var elePlaceholder = ".du-placeholder";
    var elemLayout = '.du-live-layout';
    var elemBlock = '.du-live-layout, .du-live-element, .du-placeholder';
    var elemEditor = '.du-live-editor';
    var elemLiveContent = '.live-content';
    var elemToolbar = '.du-live-editor-toolbar';
    var elemDelHandle = '.du-live-del';
    var elemMoveHandle = '.du-live-move';
    var elemEditHandle = '.du-live-edit';
    var elemLiveElement = '.du-live-element';
    var elemLiveElementLayout = '.du-live-element-layout';
    var elemImageHolderClass = 'img-holder';
    var imageDialog = '#du-live-image-setting-dialog';
    var elemCtroPanel = '.du-live-editor-elements-control';
    var elemCtrolLayout = '.du-live-editor-elements-control .du-layout';
    var elemCtrolElement = '.du-live-editor-elements-control .du-element';

    var LiveEditor = function(element, options) {
        var that = this;
        this.insertModel = 'none'; //before after none
        this.options = options
        this.$element = $(element)
        this.$liveBlock = null;
        this.$toolbar = $(toolbar);
        // this.$delCtrl = this.$toolbar.find(elemDelHandle).on("click", function(e) {
        //     e.stopPropagation();
        //     that.deleteLiveBlock();
        // });
        // this.$editCtrl = this.$toolbar.find(elemEditHandle).on("click", function(e) {
        //     e.stopPropagation();
        //     $(this).toggleClass("active");
        //     that.editLiveBlock();
        // });
        // this.$addBefCtrl = this.$toolbar.find('.du-live-add-bef').on("click", function(e) {
        //     e.stopPropagation();
        //     that.insertModel = 'before';
        //     console.log($('aside'));
        //     $('aside').show();
        // });
        // this.$addAftCtrl = this.$toolbar.find('.du-live-add-aft').on("click", function(e) {
        //     e.stopPropagation();
        //     that.insertModel = 'after';
        //     $('aside').show();
        // });
        this.initControlDraggable();
        this.initSaveAction();
        this.$iframe = $('#live-iframe');
        this.$iframe.on('load', function() {
            that.loadIframe();
        });

    }

    LiveEditor.DEFAULTS = {
        sortable: {
            placeholder: "ui-state-highlight",
            handle: elemMoveHandle,
            cursorAt: { top: 0, left: 0 },
            receive: function(event, ui) {
                LiveEditor.loadBlockCode(ui.helper, ui.helper);
            }
        }
    };

    LiveEditor.prototype.initSaveAction = function() {
        var that = this;
        $(document).on('click', '#du-live-editor-save-button', function(e) {
            e.preventDefault();
            that.saveContent();
        });
    }

    LiveEditor.prototype.loadIframe = function() {
        var that = this;
        this.$iframeDoc = this.$iframe.contents();
        this.$iframeHtml = this.$iframeDoc.find('html');
        this.$iframeBody = this.$iframeDoc.find('body');
        this.$liveContent = this.$iframeDoc.find(elemLiveContent);
        this.$liveContent.sortable(this.options.sortable);
        this.$sortableContainer = this.$liveContent;
        this.initElementPlaceHolder();
        this.$liveContent.find(elemToolbar).remove();
        this.initToolbar(this.$iframeDoc);
        $(this.$iframeDoc).on('click',
            elemBlock,
            function(e) {
                e.stopPropagation();
                var block = $(this);
                that.setActiveLiveBlock(block);
            });

    }

    LiveEditor.prototype.initToolbar = function(doc) {
        var that = this;
        `
        `
        this.$delCtrl = $(doc).on("click", elemDelHandle, function(e) {
            e.stopPropagation();
            that.deleteLiveBlock();
        });
        this.$editCtrl = $(doc).on("click", elemEditHandle, function(e) {
            e.stopPropagation();
            $(this).toggleClass("active");
            that.editLiveBlock();
        });
        this.$addBefCtrl = $(doc).on("click", '.du-live-add-bef', function(e) {
            e.stopPropagation();
            that.insertModel = 'before';
            console.log($('aside'));
            $('aside').show();
        });
        this.$addAftCtrl = $(doc).on("click", '.du-live-add-aft', function(e) {
            e.stopPropagation();
            that.insertModel = 'after';
            $('aside').show();
        });
    }

    LiveEditor.loadBlockCode = function(targetUI, dataUI) {
        $.get('/admin.php?r=cms/live-editor/load-code&id=' + dataUI.data('id'), function(data) {
            targetUI.replaceWith(data);
        });
    };

    LiveEditor.prototype.initControlDraggable = function() {
        var that = this;
        var namespace = 'click.live-editor.select-elem.insert';
        $(document).off(namespace).on(namespace, elemCtrolLayout + ',' + elemCtrolElement,
            function(e) {
                e.preventDefault();
                var blockEle = $(this);
                if (that.$liveBlock.hasClass('du-live-layout')) {
                    if (!blockEle.hasClass('du-layout')) {
                        alert("请选择布局元素，此时不能选择静态元素");
                        return false;
                    }
                }
                $.get('/admin.php?r=cms/live-editor/load-code&id=' + blockEle.data('id'), function(data) {
                    if (that.insertModel == 'before') {
                        var $data = $(data);
                        that.$liveBlock.before($data);
                        that.clearPlaceHolder();
                        that.focusActiveBlock($data);

                    } else if (that.insertModel == 'after') {
                        var $data = $(data);
                        that.$liveBlock.after($data);
                        that.clearPlaceHolder();
                        that.focusActiveBlock($data);
                    }
                });
            });

    }

    LiveEditor.prototype.clearPlaceHolder = function() {
        if (this.$sortableContainer) {
            this.$sortableContainer.find(elePlaceholder).remove();
        }
    }

    LiveEditor.prototype.focusActiveBlock = function($data) {
        //$data.trigger("click");
        this.setActiveLiveBlock($data);
        var coor = this.$liveBlock.offset();
        var top = coor.top - 200;
        this.$iframe[0].contentWindow.scroll(0, top);
    }

    //激活 block ,则选择parent 为sortable 容器，销毁上一个sortable容器
    LiveEditor.prototype.activeliveBlockParentSortable = function() {
        if (this.$sortableContainer) {
            this.$sortableContainer.sortable("destroy");
        }
        this.$sortableContainer = this.$liveBlock.parent();
        if (this.$sortableContainer.length > 0) {
            this.$sortableContainer.sortable(this.options.sortable);
        }
    }

    LiveEditor.prototype.setActiveLiveBlock = function(block) {
        var that = this;
        this.insertModel = 'none';
        $('aside').hide();
        //移除上一个block的dblclick事件绑定
        if (this.$liveBlock) {
            //如果激活的block和存储的一致则不处理
            if (block.attr('id') === this.$liveBlock.attr("id")) {
                return;
            }
            this.$liveBlock.off('dblclick');
            this.$liveBlock.removeClass('active');
            this.disableTextEdit(this.$liveBlock);
            this.$liveBlock = null;
        }

        this.$liveBlock = block;
        //重新绑定dblclick,操作父 layout
        this.$liveBlock.on('dblclick', function(e) {
            e.stopPropagation();
            var liveBlock = $(this);
            var parentLayout = liveBlock.parent(elemLayout);
            if (parentLayout) {
                //设置parent layout 为激活的liveBlock
                that.setActiveLiveBlock(parentLayout);
            }
        });
        //this.$element.find(elemBlock).removeClass('active');
        this.$liveBlock.addClass('active');
        this.$toolbar.appendTo(this.$liveBlock);
        //启动父元素为sortable
        this.activeliveBlockParentSortable();
    }

    /**
     * 编辑模式
     */
    LiveEditor.prototype.editLiveBlock = function() {
        if (this.$liveBlock && this.$liveBlock.length > 0) {
            if (this.$liveBlock.hasClass(elemImageHolderClass)) {
                this.enableEditImage(this.$liveBlock);
            } else {
                if (this.$liveBlock.attr("contentEditable") != 'false') {
                    this.disableTextEdit(this.$liveBlock);
                } else {
                    this.enableTextEdit(this.$liveBlock);
                }
            }
        }
    };
    //popline 编辑器
    LiveEditor.prototype.disableTextEdit = function(element) {
        var liveElement = $(element);
        this.$editCtrl.removeClass("active");
        liveElement.attr('contentEditable', 'false');
        liveElement.popline("destroy");
    };
    LiveEditor.prototype.enableTextEdit = function(element) {
        var liveElement = $(element);
        this.$editCtrl.addClass("active");
        liveElement.attr('contentEditable', 'true');
        liveElement.popline({ position: 'fixed' });
    };
    //图片编辑器
    LiveEditor.prototype.enableEditImage = function(imageHolder) {
        //匹配背景图
        var pattern = /url\(['"]{0,1}(.*?)['"]{0,1}\)/i;
        var match = pattern.exec(imageHolder.css('backgroundImage'))
        var url = ''
        if (match) {
            url = match[1].replace(window.location.origin, '');
        }
        var dialog = $(imageDialog);
        var input = dialog.find('input[type=text]');
        input.val(url);
        var btn = dialog.find('.confirm-btn');
        btn.off('click');
        btn.on('click', function() {
            imageHolder.css('backgroundImage', "url(" + input.val() + ")");
            dialog.modal('hide');
        });
        dialog.modal('show');
    };

    /**
     * 删除block
     */
    LiveEditor.prototype.deleteLiveBlock = function() {
        this.$toolbar.appendTo(this.$element);
        var parent = this.$liveBlock.parent(elemLiveElementLayout);
        this.$liveBlock.remove();
        this.$liveBlock = null;
        if (parent.length > 0 && parent[0].children.length == 0) {
            $('<div class="du-placeholder"></div>').appendTo(parent);
        }
    };

    LiveEditor.prototype.initElementPlaceHolder = function() {
        var holderContainers = this.$liveContent.find(elemLiveElementLayout);
        holderContainers.each(function() {
            var container = $(this);
            if (container[0].children.length == 0) {
                $('<div class="du-placeholder"></div>').appendTo(container);
            }
        })
    };

    /**
     * 保存内容
     */
    LiveEditor.prototype.saveContent = function() {
        //重置工具条的位置
        this.$toolbar.appendTo(this.$element);
        if (this.$liveBlock) {
            this.$liveBlock.removeClass('active');
        }
        var data = {
            content: this.$liveContent.html(),
        };
        data[yii.getCsrfParam()] = yii.getCsrfToken();
        var url = "/admin.php?r=cms/live-editor/save&pageId=" + this.options.pageId + "&language=" + this.options.language;
        $.post(url, data, function(res) {
            alert("success")
        });
    };


    // MODAL PLUGIN DEFINITION
    // =======================

    function Plugin(option) {
        var args = arguments;
        return this.each(function() {
            var $this = $(this)
            var data = $this.data('bs.live-editor')
            console.log(data);
            var options = $.extend({}, LiveEditor.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('bs.live-editor', (data = new LiveEditor(this, options)))
            if (typeof option == 'string') data[option].call(data, args[1])
        })
    }

    var old = $.fn.liveEditor

    $.fn.liveEditor = Plugin
    $.fn.liveEditor.Constructor = LiveEditor


    // LiveEditor NO CONFLICT
    // =================

    $.fn.liveEditor.noConflict = function() {
        $.fn.liveEditor = old
        return this
    }

    // DATA-API
    // ==============

    //auto bind
    $(elemEditor).liveEditor();
}(jQuery);