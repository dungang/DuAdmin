+ function($) {
    'use strict';
    var elemBlock = '.du-live-block';
    var elemEditor = '.du-live-editor';
    var elemEditorWorkspace = '.du-live-workspace';
    var elemToolbar = '.du-live-editor-toolbar';
    var elemToolDel = '.du-live-del';
    var elemMoveHandle = '.du-live-editor-toolbar .du-live-move';
    var elemToolSetting = '.du-live-setting';
    var elemLiveElement = '.du-live-element';
    var elemImageHolder = '.du-live-editor .img-holder';
    var imageDialog = '#du-live-image-setting-dialog';
    var elemElement = '.du-live-element';
    var elemCtrolLayout = '.du-live-editor-elements-control .du-layout';
    var elemCtrolElement = '.du-live-editor-elements-control .du-element';
    var LiveEditor = function(element, options) {

        this.options = options
        this.$element = $(element)
        this.$liveBlock = null;
        this.$liveElement = null;
        this.$toolbar = this.$element.find(elemToolbar);
        this.$workspace = this.$element.find(elemEditorWorkspace);
        this.initWorkspaceSortable();
    }

    LiveEditor.DEFAULTS = {
        sortable: {
            placeholder: "ui-state-highlight",
            //handle: elemMoveHandle,
            receive: function(event, ui) {
                $.get('/admin.php?r=cms/live-editor/load-place-holder&id=' + ui.helper.data('id'), function(data) {
                    ui.helper.replaceWith(data);
                });
            }
        }
    };

    LiveEditor.prototype.initWorkspaceSortable = function() {
        this.$workspace.sortable(this.options.sortable);
        this.$element.find(elemCtrolLayout).draggable({
            connectToSortable: elemEditorWorkspace,
            helper: "clone",
            revert: "invalid",
        });
        this.$element.find(elemCtrolElement).draggable({
            connectToSortable: elemElement,
            helper: "clone",
            revert: "invalid",
        });
    }

    LiveEditor.prototype.initElementBoxSortable = function() {
        if (this.$liveBlock) {
            this.$liveBlock.find(elemElement).sortable(this.options.sortable);
        }
    }

    LiveEditor.prototype.setActiveBlock = function(block) {
        this.$liveBlock = block;
        this.$element.find(elemBlock).removeClass('active');
        this.$liveBlock.addClass('active');
        this.$toolbar.appendTo(this.$liveBlock);
        this.$workspace.sortable("option", "handle", elemMoveHandle);
        this.initElementBoxSortable();

    }

    LiveEditor.prototype.settingImage = function(imageHolder) {
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
    }

    LiveEditor.prototype.deleteBlock = function() {
        this.$liveBlock.remove();
        this.$liveBlock = null;
    }

    LiveEditor.prototype.activeLineEditor = function(element) {
        var liveElement = $(element);
        liveElement.attr('contenteditable', true);
        liveElement.popline({ position: 'fixed' });
    }

    LiveEditor.prototype.saveContent = function() {
        this.$toolbar.appendTo(this.$element);
        if (this.$liveBlock) {
            this.$liveBlock.removeClass('active');
        }
        var data = {
            content: this.$workspace.html(),
        };
        data[yii.getCsrfToken()] = yii.getCsrfParam();
        var url = "/admin.php?r=cms/live-editor/save&pageId=" + this.options.pageId + "&language=" + this.options.language;
        $.post(url, data, function(res) {
            alert("success")
        });
    }


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
            var block = $(this);
            var editor = block.parents(elemEditor);
            Plugin.call(editor, 'setActiveBlock', block);
        });
    $(document).on('click.bs.live-editor.delete-block.data-api',
        elemToolDel,
        function(e) {
            var tool = $(this);
            var editor = tool.parents(elemEditor);
            Plugin.call(editor, 'deleteBlock');
        });
    $(document).on('dblclick.bs.live-editor.edit-element.data-api',
        elemLiveElement,
        function(e) {
            var element = $(this);
            var editor = element.parents(elemEditor);
            Plugin.call(editor, 'activeLineEditor', element);
        });
    $(document).on('dblclick.bs.live-editor.setting-image.data-api', elemImageHolder, function(e) {
        e.preventDefault();
        var imageHolder = $(this);
        var editor = imageHolder.parents(elemEditor);
        Plugin.call(editor, 'settingImage', imageHolder);
    });
    $(document).on('click.bs.live-editor.save-content.data-api', '#du-live-editor-save-button', function(e) {
        e.preventDefault();
        var editor = $(elemEditor);
        Plugin.call(editor, 'saveContent');
    });
    //auto bind
    $(elemEditor).liveEditor();
}(jQuery);