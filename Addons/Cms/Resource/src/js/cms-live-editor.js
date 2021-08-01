+ function($) {
    'use strict';
    var elePlaceholder = ".du-placeholder";
    var elemLayout = '.du-live-layout';
    var elemBlock = '.du-live-layout, .du-live-element';
    var elemEditor = '.du-live-editor';
    var elemEditorWorkspace = '.du-live-workspace';
    var elemToolbar = '.du-live-editor-toolbar';
    var elemDelHandle = '.du-live-editor-toolbar .du-live-del';
    var elemMoveHandle = '.du-live-editor-toolbar .du-live-move';
    var elemEditHandle = '.du-live-editor-toolbar .du-live-edit';
    var elemLiveElement = '.du-live-element';
    var elemLiveElementLayout = '.du-live-element-layout';
    var elemImageHolderClass = 'img-holder';
    var imageDialog = '#du-live-image-setting-dialog';
    var elemCtroPanel = '.du-live-editor-elements-control';
    var elemCtrolLayout = '.du-live-editor-elements-control .du-layout';
    var elemCtrolElement = '.du-live-editor-elements-control .du-element';
    var LiveEditor = function(element, options) {
        var that = this;
        this.options = options
        this.$element = $(element)
        this.$liveBlock = null;
        this.$liveElement = null;
        this.$toolbar = this.$element.find(elemToolbar);
        this.$workspace = this.$element.find(elemEditorWorkspace).sortable(options.sortable);
        this.$sortableContainer = this.$workspace;
        this.$delCtrl = this.$element.find(elemDelHandle).on("click", function(e) {
            e.preventDefault();
            that.deleteLiveBlock();
        });
        this.$editCtrl = this.$element.find(elemEditHandle).on("click", function(e) {
            e.preventDefault();
            $(this).toggleClass("active");
            that.editLiveBlock();
        });
        this.initControlDraggable();
        this.initElementPlaceHolder();
    }

    LiveEditor.DEFAULTS = {
        sortable: {
            placeholder: "ui-state-highlight",
            handle: elemMoveHandle,
            receive: function(event, ui) {
                LiveEditor.loadBlockCode(ui.helper, ui.helper);
            }
        }
    };

    LiveEditor.loadBlockCode = function(targetUI, dataUI) {
        $.get('/admin.php?r=cms/live-editor/load-code&id=' + dataUI.data('id'), function(data) {
            targetUI.replaceWith(data);
        });
    };

    LiveEditor.prototype.initControlDraggable = function() {
        $(elemCtrolLayout).draggable({
            connectToSortable: elemEditorWorkspace,
            helper: "clone",
            revert: "invalid",
            zIndex: 9999
        });
        $(elemCtrolElement).draggable({
            connectToSortable: elemLiveElementLayout,
            helper: "clone",
            revert: "invalid",
            zIndex: 9999
        });
    }

    //激活 block ,则选择parent 为sortable 容器，销毁上一个sortable容器
    LiveEditor.prototype.activeliveBlockParentSortable = function() {
        if (this.$sortableContainer) {
            this.$sortableContainer.sortable("destroy");
        }
        this.$sortableContainer = this.$liveBlock.parents();
        if (this.$sortableContainer.length > 0) {
            this.$sortableContainer.sortable(this.options.sortable);
            this.$liveBlock.find(elePlaceholder).droppable({
                drop: function(e, ui) {
                    LiveEditor.loadBlockCode($(this), ui.helper);
                },
                over: function(e, ui) {
                    $(this).addClass('active')
                }
            });
        }
    }

    LiveEditor.prototype.setActiveLiveBlock = function(block) {
        var that = this;
        //移除上一个block的dblclick事件绑定
        if (this.$liveBlock) {
            this.$liveBlock.off('dblclick');
            this.disableTextEdit(this.$liveBlock);
            this.$liveBlock = null;
        }

        this.$liveBlock = block;

        //重新绑定dblclick,操作父 layout
        this.$liveBlock.on('dblclick', function(e) {
            e.stopPropagation();
            var liveBlock = $(this);
            var parentLayout = liveBlock.parents(elemLayout);
            if (parentLayout) {
                //设置parent layout 为激活的liveBlock
                that.setActiveLiveBlock(parentLayout);
            }
        });
        this.$element.find(elemBlock).removeClass('active');
        this.$liveBlock.addClass('active');
        this.$toolbar.appendTo(this.$liveBlock);
        //启动父元素为sortable
        this.activeliveBlockParentSortable();
    }

    /**
     * 编辑模式
     */
    LiveEditor.prototype.editLiveBlock = function() {
        if (this.$liveBlock) {
            if (this.$liveBlock.hasClass(elemImageHolderClass)) {
                this.enableEditImage(this.$liveBlock);
            } else {
                if (this.$liveBlock.attr("contenteditable")) {
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
        liveElement.attr('contenteditable', false);
        liveElement.popline("destroy");
    };
    LiveEditor.prototype.enableTextEdit = function(element) {
        var liveElement = $(element);
        this.$editCtrl.addClass("active");
        liveElement.attr('contenteditable', true);
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
        var holderContainers = this.$workspace.find(elemLiveElementLayout);
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
            content: this.$workspace.html(),
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
    $(document).on('click.bs.live-editor.active-block.data-api',
        elemBlock,
        function(e) {
            e.stopPropagation();
            var block = $(this);
            if (block.hasClass('active')) {
                return;
            }
            var editor = block.parents(elemEditor);
            Plugin.call(editor, 'setActiveLiveBlock', block);
        });

    $(document).on('click.bs.live-editor.save-content.data-api', '#du-live-editor-save-button', function(e) {
        e.preventDefault();
        var editor = $(elemEditor);
        Plugin.call(editor, 'saveContent');
    });
    //auto bind
    $(elemEditor).liveEditor();
}(jQuery);