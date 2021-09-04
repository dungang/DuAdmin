+
function($) {
    'use strict';
    var toolbar = '<div class="du-live-editor-toolbar" contenteditable="false">' +
        '<div class="du-live-move"><i class="fa fa-arrows"></i></div>' +
        '<div class="du-live-del"><i class="fa fa-trash-o"></i></div>' +
        '<div class="du-live-edit"><i class="fa fa-edit"></i></div>' +
        '<div class="du-live-animate"><i class="fa fa-magic"></i></div>' +
        '<div class="du-live-add-bef"><i class="fa fa-plus"></i> 前</div>' +
        '<div class="du-live-add-aft"><i class="fa fa-plus"></i> 后</div>' +
        '<div class="du-live-setting"><i class="fa fa-gear"></i></div>' +
        '</div>';
    var lighter = '<div class="du-live-lighter"></div>';
    var elePlaceholder = ".du-placeholder";
    var elemLayout = '.du-live-layout';
    var elemBlock = '.du-live-layout, .du-live-element, .du-placeholder';
    var elemEditor = '.du-live-editor';
    var elemLiveContent = '.live-content';
    var elemToolbar = '.du-live-editor-toolbar';
    var elemDelHandle = '.du-live-del';
    var elemMoveHandle = '.du-live-move';
    var elemEditHandle = '.du-live-edit';
    var elemLiveElementLayout = '.du-live-element-layout';
    var elemImageHolderClass = 'img-holder';
    var imageDialog = '#du-live-image-setting-dialog';
    var elemCtrolLayout = '.du-live-editor-elements-control .du-layout';
    var elemCtrolElement = '.du-live-editor-elements-control .du-element';

    var LiveEditor = function(element, options) {
        var that = this;
        this.insertModel = 'none'; //before after none
        this.options = options
        this.$element = $(element)
        this.$liveBlock = null;
        this.$toolbar = $(toolbar);
        this.$ligter = $(lighter);
        this.initControlDraggable();
        this.initOperation();
        this.initBlockStyleForm();
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

    LiveEditor.WysiwygEditor = {

        isActive: false,
        oldValue: '',
        doc: false,

        init: function(doc) {
            this.doc = doc;
            $("#bold-btn").on("click", function(e) {
                doc.execCommand('bold', false, null);
                e.preventDefault();
                return false;
            });

            $("#italic-btn").on("click", function(e) {
                doc.execCommand('italic', false, null);
                e.preventDefault();
                return false;
            });

            $("#underline-btn").on("click", function(e) {
                doc.execCommand('underline', false, null);
                e.preventDefault();
                return false;
            });

            $("#strike-btn").on("click", function(e) {
                doc.execCommand('strikeThrough', false, null);
                e.preventDefault();
                return false;
            });

            $("#link-btn").on("click", function(e) {
                var url = prompt("URL", "请输入请求地址");
                if (url) {
                    doc.execCommand('createLink', false, url);
                }
                e.preventDefault();
                return false;
            });


            $("#unlink-btn").on("click", function(e) {
                doc.execCommand('unlink', false, null);
                e.preventDefault();
                return false;
            });

            $("#fore-color").on("change blur", function(e) {
                doc.execCommand('foreColor', false, this.value);
                e.preventDefault();
                return false;
            });


            $("#back-color").on("change blur", function(e) {
                doc.execCommand('hiliteColor', false, this.value);
                e.preventDefault();
                return false;
            });

            $("#font-size").on("change", function(e) {
                doc.execCommand('fontSize', false, this.value);
                e.preventDefault();
                return false;
            });

            $("#font-familly").on("change", function(e) {
                doc.execCommand('fontName', false, this.value);
                e.preventDefault();
                return false;
            });

            $("#justify-btn a").on("click", function(e) {
                var command = "justify" + this.dataset.value;
                doc.execCommand(command, false, "#");
                e.preventDefault();
                return false;
            });
        },

        edit: function(element) {
            element.attr({ 'contenteditable': true, 'spellcheckker': false });
            $("#wysiwyg-editor").show();

            this.element = element;
            this.isActive = true;
            this.oldValue = element.html();
        },

        destroy: function(element) {
            element.removeAttr('contenteditable spellcheckker');
            $("#wysiwyg-editor").hide();
            this.isActive = false;
        }
    }

    LiveEditor.prototype.initOperation = function() {
        var that = this;
        $(document).on('click', '#du-live-editor-save-button', function(e) {
            e.preventDefault();
            that.saveContent();
        });
        $(document).on('click', '#du-live-editor-toushi-button', function(e) {
            e.preventDefault();
            that.$liveContent.toggleClass("toushi");
        });
        $(document).on('click', '#du-live-editor-empty-button', function(e) {
            e.preventDefault();
            that.$liveContent.empty();
            that.appendPlaceHolder(that.$liveContent);
        });
    };

    LiveEditor.prototype.loadIframe = function() {
        var that = this;
        this.$iframeDoc = this.$iframe.contents();
        this.$iframeHtml = this.$iframeDoc.find('html');
        this.$iframeBody = this.$iframeDoc.find('body');
        LiveEditor.WysiwygEditor.init(this.$iframeDoc[0]);
        this.$liveContent = this.$iframeDoc.find(elemLiveContent);
        this.$liveContent.sortable(this.options.sortable);
        this.$sortableContainer = this.$liveContent;
        this.initElementPlaceHolder();
        this.$liveContent.find(elemToolbar).remove();
        this.initToolbar(this.$iframeDoc);
        this.$ligter.appendTo(this.$iframeBody).hide();
        $(this.$iframeDoc).on('click',
            elemBlock,
            function(e) {
                e.stopPropagation();
                var block = $(this);
                that.setActiveLiveBlock(block);
            }).on('scroll', function(e) {
            that.locateToolbar();
        })

    }

    LiveEditor.prototype.initToolbar = function(doc) {
        var that = this;
        this.$delCtrl = $(doc).on("click", elemDelHandle, function(e) {
            e.stopPropagation();
            that.deleteLiveBlock();
        });
        this.$editCtrl = $(doc).on("click", elemEditHandle, function(e) {
            e.stopPropagation();
            that.insertModel = 'none';
            $('aside').hide();
            $(this).toggleClass("active");
            that.editLiveBlock();
        });
        this.$addBefCtrl = $(doc).on("click", '.du-live-add-bef', function(e) {
            e.stopPropagation();
            that.insertModel = 'before';
            $('aside').show();
        });
        this.$addAftCtrl = $(doc).on("click", '.du-live-add-aft', function(e) {
            e.stopPropagation();
            that.insertModel = 'after';
            $('aside').show();
        });
        this.$settingCtrl = $(doc).on("click", '.du-live-setting', function(e) {
            e.stopPropagation();
            that.insertModel = 'none';
            $('aside').hide();
            $('#du-live-block-setting-dialog').modal("show");
            that.initBlockStyleFormData();
        });
        this.$settingCtrl = $(doc).on("click", '.du-live-animate', function(e) {
            e.stopPropagation();
            that.insertModel = 'none';
            $('aside').hide();
            $('#du-live-block-animate-dialog').modal("show");
            that.initBlockAnimateFormData();
        });
        this.$toolbar.appendTo(this.$iframeBody).hide();
    }

    LiveEditor.prototype.initBlockAnimateForm = function() {
        var that = this;
        $('#du-live-block-animate-dialog').on('click', '.btn-primary', function(e) {
            e.preventDefault();
            var styles = {};
            $('#style-animate-form').serializeArray().forEach((o) => {
                if (o.value.length > 0) {
                    styles[o.name] = o.value.trim();
                }
            });
            that.$liveBlock.css(styles);
            $(this).modal("hide");
        })
    }

    LiveEditor.prototype.initBlockAnimateFormData = function() {
        if (this.$liveBlock) {
            $('#style-animate-form input').each(function() {
                var $input = $(this);
                var name = $input.attr("name");
            });
        }
    }

    LiveEditor.prototype.initBlockStyleForm = function() {
        var that = this;
        $('#du-live-block-setting-dialog').on('click', '.btn-primary', function(e) {
            e.preventDefault();
            var styles = {};
            $('#style-setting-form').serializeArray().forEach((o) => {
                if (o.value.length > 0) {
                    styles[o.name] = o.value.trim();
                }
            });
            that.$liveBlock.css(styles);
            $(this).modal("hide");
        })
    }

    LiveEditor.prototype.initBlockStyleFormData = function() {
        if (this.$liveBlock) {
            var styles = this.$liveBlock.attr("style");
            const cssInObject = styles.split(';').map(cur => cur.split(':')).reduce((acc, val) => {
                let [key, value] = val;
                key = key.replace(/-./g, css => css.toUpperCase()[1])
                acc[key] = value;
                return acc;
            }, {});
            $('#style-setting-form input').each(function() {
                var $input = $(this);
                var name = $input.attr("name");
                if (cssInObject[name]) {
                    $input.val(cssInObject[name]);
                }
            });
        }
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
                        that.focusActiveBlock(that.findBlock($data));

                    } else if (that.insertModel == 'after') {
                        var $data = $(data);
                        that.$liveBlock.after($data);
                        that.clearPlaceHolder();
                        that.focusActiveBlock(that.findBlock($data));
                    }
                });
            });

    }

    LiveEditor.prototype.findBlock = function($data) {
        return $data.find('div:eq(0)');
    }

    LiveEditor.prototype.clearPlaceHolder = function() {
        if (this.$sortableContainer) {
            this.$sortableContainer.find(">" + elePlaceholder).remove();
        }
    }

    LiveEditor.prototype.focusActiveBlock = function($data) {
        this.setActiveLiveBlock($data);
        var coor = this.$liveBlock.offset();
        if (coor && coor.top) {
            var top = coor.top - 200;
            this.$iframe[0].contentWindow.scroll(0, top);
        }
    }

    //激活 block ,则选择parent 为sortable 容器，销毁上一个sortable容器
    LiveEditor.prototype.activeLiveBlockParentSortable = function() {
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
            if (block.is(this.$liveBlock)) {
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
        this.locateToolbar();
        this.$liveBlock.addClass('active');

        //启动父元素为sortable
        this.activeLiveBlockParentSortable();
    }

    LiveEditor.prototype.locateToolbar = function() {
        if (this.$liveBlock && this.$liveBlock.length > 0) {
            var offset = this.$liveBlock.offset();
            var top = offset.top - 26;
            this.$toolbar.css({
                top: top + "px",
                left: offset.left
            }).show();
            console.log(offset);
        }
    }


    /**
     * 编辑模式
     */
    LiveEditor.prototype.editLiveBlock = function() {
        if (this.$liveBlock && this.$liveBlock.length > 0) {
            if (this.$liveBlock[0].tagName == 'A') {
                let href = prompt("请输入url", this.$liveBlock.attr('href'));
                if (href) {
                    this.$liveBlock.attr('href', href);
                }
            } else if (this.$liveBlock.hasClass(elemImageHolderClass)) {
                this.enableEditImageBg(this.$liveBlock);
            } else if (this.$liveBlock.css('backgroundImage') != 'none') {
                this.enableEditImageBg(this.$liveBlock);
            } else {
                var $img = this.$liveBlock.find('>img');
                if ($img.length > 0) {
                    this.enableEditImage($img);
                } else {
                    if (this.$liveBlock.attr("contentEditable") != undefined) {
                        console.log(this.$liveBlock.attr("contentEditable"))
                        this.disableTextEdit(this.$liveBlock);
                    } else {
                        this.enableTextEdit(this.$liveBlock);
                    }
                }
            }
        }
    };
    //popline 编辑器
    LiveEditor.prototype.disableTextEdit = function(element) {
        var liveElement = $(element);
        this.$editCtrl.removeClass("active");
        liveElement.removeAttr('contentEditable');
        LiveEditor.WysiwygEditor.destroy(element);
    };
    LiveEditor.prototype.enableTextEdit = function(element) {
        var liveElement = $(element);
        this.$editCtrl.addClass("active");
        LiveEditor.WysiwygEditor.edit(element);
        liveElement.attr('contentEditable', 'true');
    };

    //图片编辑器
    LiveEditor.prototype.enableEditImage = function(imageHolder) {
        var url = imageHolder.attr('src');
        var dialog = $(imageDialog);
        var input = dialog.find('input[type=text]');
        input.val(url);
        var btn = dialog.find('.confirm-btn');
        btn.off('click');
        btn.on('click', function() {
            imageHolder.attr('src', input.val());
            dialog.modal('hide');
        });
        dialog.modal('show');
    };

    //图片背景编辑器
    LiveEditor.prototype.enableEditImageBg = function(imageHolder) {
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
        this.$toolbar.hide();
        var parent = this.$liveBlock.parent(elemLiveElementLayout);

        if (parent.length == 0) {
            parent = this.$liveBlock.parent(".live-content");
            console.log(parent);
        }
        this.$liveBlock.remove();
        this.$liveBlock = null;
        if (parent.length > 0) {
            var elems = parent.find(elemBlock);
            if (elems.length == 0) {
                this.appendPlaceHolder(parent);
            }
        }
    };

    LiveEditor.prototype.initElementPlaceHolder = function() {
        var holderContainers = this.$liveContent.find(elemLiveElementLayout);
        holderContainers.each(function() {
            var container = $(this);
            if (container[0].children.length == 0) {
                this.appendPlaceHolder.appendTo(container);
            }
        });
        if (this.$liveContent[0].children.length == 0) {
            this.appendPlaceHolder(this.$liveContent);
        }
    };

    LiveEditor.prototype.appendPlaceHolder = function($target) {
        $('<div class="du-placeholder"></div>').appendTo($target);
    }

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