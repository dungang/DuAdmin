<<<<<<< HEAD
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Addons/Cms/Resource/src/js/cms-live-editor.js":
/*!*******************************************************!*\
  !*** ./Addons/Cms/Resource/src/js/cms-live-editor.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(n); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return; var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

+function ($) {
  'use strict';

  var toolbar = '<div class="du-live-editor-toolbar" contenteditable="false">' + '<div class="du-live-move"><i class="fa fa-arrows"></i></div>' + '<div class="du-live-del"><i class="fa fa-trash-o"></i></div>' + '<div class="du-live-edit"><i class="fa fa-edit"></i></div>' + '<div class="du-live-animate"><i class="fa fa-magic"></i></div>' + '<div class="du-live-add-bef"><i class="fa fa-plus"></i> 前</div>' + '<div class="du-live-add-aft"><i class="fa fa-plus"></i> 后</div>' + '<div class="du-live-setting"><i class="fa fa-gear"></i></div>' + '</div>';
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

  var LiveEditor = function LiveEditor(element, options) {
    var that = this;
    this.insertModel = 'none'; //before after none

    this.options = options;
    this.$element = $(element);
    this.$liveBlock = null;
    this.$toolbar = $(toolbar);
    this.$ligter = $(lighter);
    this.initControlDraggable();
    this.initOperation();
    this.initBlockStyleForm();
    this.$iframe = $('#live-iframe');
    this.$iframe.on('load', function () {
      that.loadIframe();
    });
  };

  LiveEditor.DEFAULTS = {
    sortable: {
      placeholder: "ui-state-highlight",
      handle: elemMoveHandle,
      cursorAt: {
        top: 0,
        left: 0
      },
      receive: function receive(event, ui) {
        LiveEditor.loadBlockCode(ui.helper, ui.helper);
      }
    }
  };
  LiveEditor.WysiwygEditor = {
    isActive: false,
    oldValue: '',
    doc: false,
    init: function init(doc) {
      this.doc = doc;
      $("#bold-btn").on("click", function (e) {
        doc.execCommand('bold', false, null);
        e.preventDefault();
        return false;
      });
      $("#italic-btn").on("click", function (e) {
        doc.execCommand('italic', false, null);
        e.preventDefault();
        return false;
      });
      $("#underline-btn").on("click", function (e) {
        doc.execCommand('underline', false, null);
        e.preventDefault();
        return false;
      });
      $("#strike-btn").on("click", function (e) {
        doc.execCommand('strikeThrough', false, null);
        e.preventDefault();
        return false;
      });
      $("#link-btn").on("click", function (e) {
        var url = prompt("URL", "请输入请求地址");

        if (url) {
          doc.execCommand('createLink', false, url);
        }

        e.preventDefault();
        return false;
      });
      $("#unlink-btn").on("click", function (e) {
        doc.execCommand('unlink', false, null);
        e.preventDefault();
        return false;
      });
      $("#fore-color").on("change blur", function (e) {
        doc.execCommand('foreColor', false, this.value);
        e.preventDefault();
        return false;
      });
      $("#back-color").on("change blur", function (e) {
        doc.execCommand('hiliteColor', false, this.value);
        e.preventDefault();
        return false;
      });
      $("#font-size").on("change", function (e) {
        doc.execCommand('fontSize', false, this.value);
        e.preventDefault();
        return false;
      });
      $("#font-familly").on("change", function (e) {
        doc.execCommand('fontName', false, this.value);
        e.preventDefault();
        return false;
      });
      $("#justify-btn a").on("click", function (e) {
        var command = "justify" + this.dataset.value;
        doc.execCommand(command, false, "#");
        e.preventDefault();
        return false;
      });
    },
    edit: function edit(element) {
      element.attr({
        'contenteditable': true,
        'spellcheckker': false
      });
      $("#wysiwyg-editor").show();
      this.element = element;
      this.isActive = true;
      this.oldValue = element.html();
    },
    destroy: function destroy(element) {
      element.removeAttr('contenteditable spellcheckker');
      $("#wysiwyg-editor").hide();
      this.isActive = false;
    }
  };

  LiveEditor.prototype.initOperation = function () {
    var that = this;
    $(document).on('click', '#du-live-editor-save-button', function (e) {
      e.preventDefault();
      that.saveContent();
    });
    $(document).on('click', '#du-live-editor-toushi-button', function (e) {
      e.preventDefault();
      that.$liveContent.toggleClass("toushi");
    });
    $(document).on('click', '#du-live-editor-empty-button', function (e) {
      e.preventDefault();
      that.$liveContent.empty();
      that.appendPlaceHolder(that.$liveContent);
    });
  };

  LiveEditor.prototype.loadIframe = function () {
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
    $(this.$iframeDoc).on('click', elemBlock, function (e) {
      e.stopPropagation();
      var block = $(this);
      that.setActiveLiveBlock(block);
    }).on('scroll', function (e) {
      that.locateToolbar();
    });
  };

  LiveEditor.prototype.initToolbar = function (doc) {
    var that = this;
    this.$delCtrl = $(doc).on("click", elemDelHandle, function (e) {
      e.stopPropagation();
      that.deleteLiveBlock();
    });
    this.$editCtrl = $(doc).on("click", elemEditHandle, function (e) {
      e.stopPropagation();
      that.insertModel = 'none';
      $('aside').hide();
      $(this).toggleClass("active");
      that.editLiveBlock();
    });
    this.$addBefCtrl = $(doc).on("click", '.du-live-add-bef', function (e) {
      e.stopPropagation();
      that.insertModel = 'before';
      $('aside').show();
    });
    this.$addAftCtrl = $(doc).on("click", '.du-live-add-aft', function (e) {
      e.stopPropagation();
      that.insertModel = 'after';
      $('aside').show();
    });
    this.$settingCtrl = $(doc).on("click", '.du-live-setting', function (e) {
      e.stopPropagation();
      that.insertModel = 'none';
      $('aside').hide();
      $('#du-live-block-setting-dialog').modal("show");
      that.initBlockStyleFormData();
    });
    this.$settingCtrl = $(doc).on("click", '.du-live-animate', function (e) {
      e.stopPropagation();
      that.insertModel = 'none';
      $('aside').hide();
      $('#du-live-block-animate-dialog').modal("show");
      that.initBlockAnimateFormData();
    });
    this.$toolbar.appendTo(this.$iframeBody).hide();
  };

  LiveEditor.prototype.initBlockAnimateForm = function () {
    var that = this;
    $('#du-live-block-animate-dialog').on('click', '.btn-primary', function (e) {
      e.preventDefault();
      var styles = {};
      $('#style-animate-form').serializeArray().forEach(function (o) {
        if (o.value.length > 0) {
          styles[o.name] = o.value.trim();
        }
      });
      that.$liveBlock.css(styles);
      $(this).modal("hide");
    });
  };

  LiveEditor.prototype.initBlockAnimateFormData = function () {
    if (this.$liveBlock) {
      $('#style-animate-form input').each(function () {
        var $input = $(this);
        var name = $input.attr("name");
      });
    }
  };

  LiveEditor.prototype.initBlockStyleForm = function () {
    var that = this;
    $('#du-live-block-setting-dialog').on('click', '.btn-primary', function (e) {
      e.preventDefault();
      var styles = {};
      $('#style-setting-form').serializeArray().forEach(function (o) {
        if (o.value.length > 0) {
          styles[o.name] = o.value.trim();
        }
      });
      that.$liveBlock.css(styles);
      $(this).modal("hide");
    });
  };

  LiveEditor.prototype.initBlockStyleFormData = function () {
    if (this.$liveBlock) {
      var styles = this.$liveBlock.attr("style");
      var cssInObject = styles.split(';').map(function (cur) {
        return cur.split(':');
      }).reduce(function (acc, val) {
        var _val = _slicedToArray(val, 2),
            key = _val[0],
            value = _val[1];

        key = key.replace(/-./g, function (css) {
          return css.toUpperCase()[1];
        });
        acc[key] = value;
        return acc;
      }, {});
      $('#style-setting-form input').each(function () {
        var $input = $(this);
        var name = $input.attr("name");

        if (cssInObject[name]) {
          $input.val(cssInObject[name]);
        }
      });
    }
  };

  LiveEditor.loadBlockCode = function (targetUI, dataUI) {
    $.get('/admin.php?r=cms/live-editor/load-code&id=' + dataUI.data('id'), function (data) {
      targetUI.replaceWith(data);
    });
  };

  LiveEditor.prototype.initControlDraggable = function () {
    var that = this;
    var namespace = 'click.live-editor.select-elem.insert';
    $(document).off(namespace).on(namespace, elemCtrolLayout + ',' + elemCtrolElement, function (e) {
      e.preventDefault();
      var blockEle = $(this);

      if (that.$liveBlock.hasClass('du-live-layout')) {
        if (!blockEle.hasClass('du-layout')) {
          alert("请选择布局元素，此时不能选择静态元素");
          return false;
        }
      }

      $.get('/admin.php?r=cms/live-editor/load-code&id=' + blockEle.data('id'), function (data) {
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
  };

  LiveEditor.prototype.findBlock = function ($data) {
    return $data.find('div:eq(0)');
  };

  LiveEditor.prototype.clearPlaceHolder = function () {
    if (this.$sortableContainer) {
      this.$sortableContainer.find(">" + elePlaceholder).remove();
    }
  };

  LiveEditor.prototype.focusActiveBlock = function ($data) {
    this.setActiveLiveBlock($data);
    var coor = this.$liveBlock.offset();

    if (coor && coor.top) {
      var top = coor.top - 200;
      this.$iframe[0].contentWindow.scroll(0, top);
    }
  }; //激活 block ,则选择parent 为sortable 容器，销毁上一个sortable容器


  LiveEditor.prototype.activeLiveBlockParentSortable = function () {
    if (this.$sortableContainer) {
      this.$sortableContainer.sortable("destroy");
    }

    this.$sortableContainer = this.$liveBlock.parent();

    if (this.$sortableContainer.length > 0) {
      this.$sortableContainer.sortable(this.options.sortable);
    }
  };

  LiveEditor.prototype.setActiveLiveBlock = function (block) {
    var that = this;
    this.insertModel = 'none';
    $('aside').hide(); //移除上一个block的dblclick事件绑定

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

    this.$liveBlock = block; //重新绑定dblclick,操作父 layout

    this.$liveBlock.on('dblclick', function (e) {
      e.stopPropagation();
      var liveBlock = $(this);
      var parentLayout = liveBlock.parent(elemLayout);

      if (parentLayout) {
        //设置parent layout 为激活的liveBlock
        that.setActiveLiveBlock(parentLayout);
      }
    });
    this.locateToolbar();
    this.$liveBlock.addClass('active'); //启动父元素为sortable

    this.activeLiveBlockParentSortable();
  };

  LiveEditor.prototype.locateToolbar = function () {
    if (this.$liveBlock && this.$liveBlock.length > 0) {
      var offset = this.$liveBlock.offset();
      var top = offset.top - 26;
      this.$toolbar.css({
        top: top + "px",
        left: offset.left
      }).show();
      console.log(offset);
    }
  };
  /**
   * 编辑模式
   */


  LiveEditor.prototype.editLiveBlock = function () {
    if (this.$liveBlock && this.$liveBlock.length > 0) {
      if (this.$liveBlock[0].tagName == 'A') {
        var href = prompt("请输入url", this.$liveBlock.attr('href'));

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
            console.log(this.$liveBlock.attr("contentEditable"));
            this.disableTextEdit(this.$liveBlock);
          } else {
            this.enableTextEdit(this.$liveBlock);
          }
        }
      }
    }
  }; //popline 编辑器


  LiveEditor.prototype.disableTextEdit = function (element) {
    var liveElement = $(element);
    this.$editCtrl.removeClass("active");
    liveElement.removeAttr('contentEditable');
    LiveEditor.WysiwygEditor.destroy(element);
  };

  LiveEditor.prototype.enableTextEdit = function (element) {
    var liveElement = $(element);
    this.$editCtrl.addClass("active");
    LiveEditor.WysiwygEditor.edit(element);
    liveElement.attr('contentEditable', 'true');
  }; //图片编辑器


  LiveEditor.prototype.enableEditImage = function (imageHolder) {
    var url = imageHolder.attr('src');
    var dialog = $(imageDialog);
    var input = dialog.find('input[type=text]');
    input.val(url);
    var btn = dialog.find('.confirm-btn');
    btn.off('click');
    btn.on('click', function () {
      imageHolder.attr('src', input.val());
      dialog.modal('hide');
    });
    dialog.modal('show');
  }; //图片背景编辑器


  LiveEditor.prototype.enableEditImageBg = function (imageHolder) {
    //匹配背景图
    var pattern = /url\(['"]{0,1}(.*?)['"]{0,1}\)/i;
    var match = pattern.exec(imageHolder.css('backgroundImage'));
    var url = '';

    if (match) {
      url = match[1].replace(window.location.origin, '');
    }

    var dialog = $(imageDialog);
    var input = dialog.find('input[type=text]');
    input.val(url);
    var btn = dialog.find('.confirm-btn');
    btn.off('click');
    btn.on('click', function () {
      imageHolder.css('backgroundImage', "url(" + input.val() + ")");
      dialog.modal('hide');
    });
    dialog.modal('show');
  };
  /**
   * 删除block
   */


  LiveEditor.prototype.deleteLiveBlock = function () {
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

  LiveEditor.prototype.initElementPlaceHolder = function () {
    var holderContainers = this.$liveContent.find(elemLiveElementLayout);
    holderContainers.each(function () {
      var container = $(this);

      if (container[0].children.length == 0) {
        this.appendPlaceHolder.appendTo(container);
      }
    });

    if (this.$liveContent[0].children.length == 0) {
      this.appendPlaceHolder(this.$liveContent);
    }
  };

  LiveEditor.prototype.appendPlaceHolder = function ($target) {
    $('<div class="du-placeholder"></div>').appendTo($target);
  };
  /**
   * 保存内容
   */


  LiveEditor.prototype.saveContent = function () {
    //重置工具条的位置
    this.$toolbar.appendTo(this.$element);

    if (this.$liveBlock) {
      this.$liveBlock.removeClass('active');
    }

    var data = {
      content: this.$liveContent.html()
    };
    data[yii.getCsrfParam()] = yii.getCsrfToken();
    var url = "/admin.php?r=cms/live-editor/save&pageId=" + this.options.pageId + "&language=" + this.options.language;
    $.post(url, data, function (res) {
      alert("success");
    });
  }; // MODAL PLUGIN DEFINITION
  // =======================


  function Plugin(option) {
    var args = arguments;
    return this.each(function () {
      var $this = $(this);
      var data = $this.data('bs.live-editor');
      var options = $.extend({}, LiveEditor.DEFAULTS, $this.data(), _typeof(option) == 'object' && option);
      if (!data) $this.data('bs.live-editor', data = new LiveEditor(this, options));
      if (typeof option == 'string') data[option].call(data, args[1]);
    });
  }

  var old = $.fn.liveEditor;
  $.fn.liveEditor = Plugin;
  $.fn.liveEditor.Constructor = LiveEditor; // LiveEditor NO CONFLICT
  // =================

  $.fn.liveEditor.noConflict = function () {
    $.fn.liveEditor = old;
    return this;
  }; // DATA-API
  // ==============
  //auto bind


  $(elemEditor).liveEditor();
}(jQuery);

/***/ }),

/***/ "./Addons/Cms/Resource/src/less/cms-live-editor.less":
/*!***********************************************************!*\
  !*** ./Addons/Cms/Resource/src/less/cms-live-editor.less ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./Addons/Cms/Resource/src/less/cms.less":
/*!***********************************************!*\
  !*** ./Addons/Cms/Resource/src/less/cms.less ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./Addons/Doc/Resource/src/less/doc.less":
/*!***********************************************!*\
  !*** ./Addons/Doc/Resource/src/less/doc.less ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./Addons/Guide/Resource/src/less/guide.less":
/*!***************************************************!*\
  !*** ./Addons/Guide/Resource/src/less/guide.less ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./Themes/Basic/assets/src/less/basic.less":
/*!*************************************************!*\
  !*** ./Themes/Basic/assets/src/less/basic.less ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./Themes/Du/assets/src/less/du.less":
/*!*******************************************!*\
  !*** ./Themes/Du/assets/src/less/du.less ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./Themes/LingShan/assets/src/less/lingshan.less":
/*!*******************************************************!*\
  !*** ./Themes/LingShan/assets/src/less/lingshan.less ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./Themes/LongYu/assets/src/less/longyu.less":
/*!***************************************************!*\
  !*** ./Themes/LongYu/assets/src/less/longyu.less ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./Themes/XiaoSen/assets/src/less/xiaosen.less":
/*!*****************************************************!*\
  !*** ./Themes/XiaoSen/assets/src/less/xiaosen.less ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./public/duadmin/src/less/DUAdmin.less":
/*!**********************************************!*\
  !*** ./public/duadmin/src/less/DUAdmin.less ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./public/src/less/frontend.less":
/*!***************************************!*\
  !*** ./public/src/less/frontend.less ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** multi ./Addons/Cms/Resource/src/js/cms-live-editor.js ./Addons/Cms/Resource/src/less/cms.less ./Addons/Cms/Resource/src/less/cms-live-editor.less ./Addons/Doc/Resource/src/less/doc.less ./Addons/Guide/Resource/src/less/guide.less ./Themes/Basic/assets/src/less/basic.less ./Themes/Du/assets/src/less/du.less ./Themes/LingShan/assets/src/less/lingshan.less ./Themes/LongYu/assets/src/less/longyu.less ./Themes/XiaoSen/assets/src/less/xiaosen.less ./public/duadmin/src/less/DUAdmin.less ./public/src/less/frontend.less ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! D:\workspace\DuAdmin\Addons\Cms\Resource\src\js\cms-live-editor.js */"./Addons/Cms/Resource/src/js/cms-live-editor.js");
__webpack_require__(/*! D:\workspace\DuAdmin\Addons\Cms\Resource\src\less\cms.less */"./Addons/Cms/Resource/src/less/cms.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Addons\Cms\Resource\src\less\cms-live-editor.less */"./Addons/Cms/Resource/src/less/cms-live-editor.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Addons\Doc\Resource\src\less\doc.less */"./Addons/Doc/Resource/src/less/doc.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Addons\Guide\Resource\src\less\guide.less */"./Addons/Guide/Resource/src/less/guide.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Themes\Basic\assets\src\less\basic.less */"./Themes/Basic/assets/src/less/basic.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Themes\Du\assets\src\less\du.less */"./Themes/Du/assets/src/less/du.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Themes\LingShan\assets\src\less\lingshan.less */"./Themes/LingShan/assets/src/less/lingshan.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Themes\LongYu\assets\src\less\longyu.less */"./Themes/LongYu/assets/src/less/longyu.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Themes\XiaoSen\assets\src\less\xiaosen.less */"./Themes/XiaoSen/assets/src/less/xiaosen.less");
__webpack_require__(/*! D:\workspace\DuAdmin\public\duadmin\src\less\DUAdmin.less */"./public/duadmin/src/less/DUAdmin.less");
module.exports = __webpack_require__(/*! D:\workspace\DuAdmin\public\src\less\frontend.less */"./public/src/less/frontend.less");


/***/ })

/******/ });
=======
!function(t){var e={};function i(o){if(e[o])return e[o].exports;var n=e[o]={i:o,l:!1,exports:{}};return t[o].call(n.exports,n,n.exports,i),n.l=!0,n.exports}i.m=t,i.c=e,i.d=function(t,e,o){i.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:o})},i.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},i.t=function(t,e){if(1&e&&(t=i(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var o=Object.create(null);if(i.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var n in t)i.d(o,n,function(e){return t[e]}.bind(null,n));return o},i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},i.p="/",i(i.s=141)}({141:function(t,e,i){i(142),i(262),i(264),i(266),i(268),t.exports=i(270)},142:function(t,e){function i(t){return(i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function o(t,e){return function(t){if(Array.isArray(t))return t}(t)||function(t,e){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var i=[],o=!0,n=!1,l=void 0;try{for(var r,a=t[Symbol.iterator]();!(o=(r=a.next()).done)&&(i.push(r.value),!e||i.length!==e);o=!0);}catch(t){n=!0,l=t}finally{try{o||null==a.return||a.return()}finally{if(n)throw l}}return i}(t,e)||function(t,e){if(!t)return;if("string"==typeof t)return n(t,e);var i=Object.prototype.toString.call(t).slice(8,-1);"Object"===i&&t.constructor&&(i=t.constructor.name);if("Map"===i||"Set"===i)return Array.from(i);if("Arguments"===i||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(i))return n(t,e)}(t,e)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function n(t,e){(null==e||e>t.length)&&(e=t.length);for(var i=0,o=new Array(e);i<e;i++)o[i]=t[i];return o}!function(t){"use strict";var e=".du-live-layout, .du-live-element, .du-placeholder",n=function(e,i){var o=this;this.insertModel="none",this.options=i,this.$element=t(e),this.$liveBlock=null,this.$toolbar=t('<div class="du-live-editor-toolbar" contenteditable="false"><div class="du-live-move"><i class="fa fa-arrows"></i></div><div class="du-live-del"><i class="fa fa-trash-o"></i></div><div class="du-live-edit"><i class="fa fa-edit"></i></div><div class="du-live-animate"><i class="fa fa-magic"></i></div><div class="du-live-add-bef"><i class="fa fa-plus"></i> 前</div><div class="du-live-add-aft"><i class="fa fa-plus"></i> 后</div><div class="du-live-setting"><i class="fa fa-gear"></i></div></div>'),this.$ligter=t('<div class="du-live-lighter"></div>'),this.initControlDraggable(),this.initOperation(),this.initBlockStyleForm(),this.$iframe=t("#live-iframe"),this.$iframe.on("load",(function(){o.loadIframe()}))};n.DEFAULTS={sortable:{placeholder:"ui-state-highlight",handle:".du-live-move",cursorAt:{top:0,left:0},receive:function(t,e){n.loadBlockCode(e.helper,e.helper)}}},n.WysiwygEditor={isActive:!1,oldValue:"",doc:!1,init:function(e){this.doc=e,t("#bold-btn").on("click",(function(t){return e.execCommand("bold",!1,null),t.preventDefault(),!1})),t("#italic-btn").on("click",(function(t){return e.execCommand("italic",!1,null),t.preventDefault(),!1})),t("#underline-btn").on("click",(function(t){return e.execCommand("underline",!1,null),t.preventDefault(),!1})),t("#strike-btn").on("click",(function(t){return e.execCommand("strikeThrough",!1,null),t.preventDefault(),!1})),t("#link-btn").on("click",(function(t){var i=prompt("URL","请输入请求地址");return i&&e.execCommand("createLink",!1,i),t.preventDefault(),!1})),t("#unlink-btn").on("click",(function(t){return e.execCommand("unlink",!1,null),t.preventDefault(),!1})),t("#fore-color").on("change blur",(function(t){return e.execCommand("foreColor",!1,this.value),t.preventDefault(),!1})),t("#back-color").on("change blur",(function(t){return e.execCommand("hiliteColor",!1,this.value),t.preventDefault(),!1})),t("#font-size").on("change",(function(t){return e.execCommand("fontSize",!1,this.value),t.preventDefault(),!1})),t("#font-familly").on("change",(function(t){return e.execCommand("fontName",!1,this.value),t.preventDefault(),!1})),t("#justify-btn a").on("click",(function(t){var i="justify"+this.dataset.value;return e.execCommand(i,!1,"#"),t.preventDefault(),!1}))},edit:function(e){e.attr({contenteditable:!0,spellcheckker:!1}),t("#wysiwyg-editor").show(),this.element=e,this.isActive=!0,this.oldValue=e.html()},destroy:function(e){e.removeAttr("contenteditable spellcheckker"),t("#wysiwyg-editor").hide(),this.isActive=!1}},n.prototype.initOperation=function(){var e=this;t(document).on("click","#du-live-editor-save-button",(function(t){t.preventDefault(),e.saveContent()})),t(document).on("click","#du-live-editor-toushi-button",(function(t){t.preventDefault(),e.$liveContent.toggleClass("toushi")})),t(document).on("click","#du-live-editor-empty-button",(function(t){t.preventDefault(),e.$liveContent.empty(),e.appendPlaceHolder(e.$liveContent)}))},n.prototype.loadIframe=function(){var i=this;this.$iframeDoc=this.$iframe.contents(),this.$iframeHtml=this.$iframeDoc.find("html"),this.$iframeBody=this.$iframeDoc.find("body"),n.WysiwygEditor.init(this.$iframeDoc[0]),this.$liveContent=this.$iframeDoc.find(".live-content"),this.$liveContent.sortable(this.options.sortable),this.$sortableContainer=this.$liveContent,this.initElementPlaceHolder(),this.$liveContent.find(".du-live-editor-toolbar").remove(),this.initToolbar(this.$iframeDoc),this.$ligter.appendTo(this.$iframeBody).hide(),t(this.$iframeDoc).on("click",e,(function(e){e.stopPropagation();var o=t(this);i.setActiveLiveBlock(o)})).on("scroll",(function(t){i.locateToolbar()}))},n.prototype.initToolbar=function(e){var i=this;this.$delCtrl=t(e).on("click",".du-live-del",(function(t){t.stopPropagation(),i.deleteLiveBlock()})),this.$editCtrl=t(e).on("click",".du-live-edit",(function(e){e.stopPropagation(),i.insertModel="none",t("aside").hide(),t(this).toggleClass("active"),i.editLiveBlock()})),this.$addBefCtrl=t(e).on("click",".du-live-add-bef",(function(e){e.stopPropagation(),i.insertModel="before",t("aside").show()})),this.$addAftCtrl=t(e).on("click",".du-live-add-aft",(function(e){e.stopPropagation(),i.insertModel="after",t("aside").show()})),this.$settingCtrl=t(e).on("click",".du-live-setting",(function(e){e.stopPropagation(),i.insertModel="none",t("aside").hide(),t("#du-live-block-setting-dialog").modal("show"),i.initBlockStyleFormData()})),this.$settingCtrl=t(e).on("click",".du-live-animate",(function(e){e.stopPropagation(),i.insertModel="none",t("aside").hide(),t("#du-live-block-animate-dialog").modal("show"),i.initBlockAnimateFormData()})),this.$toolbar.appendTo(this.$iframeBody).hide()},n.prototype.initBlockAnimateForm=function(){var e=this;t("#du-live-block-animate-dialog").on("click",".btn-primary",(function(i){i.preventDefault();var o={};t("#style-animate-form").serializeArray().forEach((function(t){t.value.length>0&&(o[t.name]=t.value.trim())})),e.$liveBlock.css(o),t(this).modal("hide")}))},n.prototype.initBlockAnimateFormData=function(){this.$liveBlock&&t("#style-animate-form input").each((function(){t(this).attr("name")}))},n.prototype.initBlockStyleForm=function(){var e=this;t("#du-live-block-setting-dialog").on("click",".btn-primary",(function(i){i.preventDefault();var o={};t("#style-setting-form").serializeArray().forEach((function(t){t.value.length>0&&(o[t.name]=t.value.trim())})),e.$liveBlock.css(o),t(this).modal("hide")}))},n.prototype.initBlockStyleFormData=function(){if(this.$liveBlock){var e=this.$liveBlock.attr("style").split(";").map((function(t){return t.split(":")})).reduce((function(t,e){var i=o(e,2),n=i[0],l=i[1];return t[n=n.replace(/-./g,(function(t){return t.toUpperCase()[1]}))]=l,t}),{});t("#style-setting-form input").each((function(){var i=t(this),o=i.attr("name");e[o]&&i.val(e[o])}))}},n.loadBlockCode=function(e,i){t.get("/admin.php?r=cms/live-editor/load-code&id="+i.data("id"),(function(t){e.replaceWith(t)}))},n.prototype.initControlDraggable=function(){var e=this,i="click.live-editor.select-elem.insert";t(document).off(i).on(i,".du-live-editor-elements-control .du-layout,.du-live-editor-elements-control .du-element",(function(i){i.preventDefault();var o=t(this);if(e.$liveBlock.hasClass("du-live-layout")&&!o.hasClass("du-layout"))return alert("请选择布局元素，此时不能选择静态元素"),!1;t.get("/admin.php?r=cms/live-editor/load-code&id="+o.data("id"),(function(i){if("before"==e.insertModel){var o=t(i);e.$liveBlock.before(o),e.clearPlaceHolder(),e.focusActiveBlock(e.findBlock(o))}else if("after"==e.insertModel){o=t(i);e.$liveBlock.after(o),e.clearPlaceHolder(),e.focusActiveBlock(e.findBlock(o))}}))}))},n.prototype.findBlock=function(t){return t.find("div:eq(0)")},n.prototype.clearPlaceHolder=function(){this.$sortableContainer&&this.$sortableContainer.find(">.du-placeholder").remove()},n.prototype.focusActiveBlock=function(t){this.setActiveLiveBlock(t);var e=this.$liveBlock.offset();if(e&&e.top){var i=e.top-200;this.$iframe[0].contentWindow.scroll(0,i)}},n.prototype.activeLiveBlockParentSortable=function(){this.$sortableContainer&&this.$sortableContainer.sortable("destroy"),this.$sortableContainer=this.$liveBlock.parent(),this.$sortableContainer.length>0&&this.$sortableContainer.sortable(this.options.sortable)},n.prototype.setActiveLiveBlock=function(e){var i=this;if(this.insertModel="none",t("aside").hide(),this.$liveBlock){if(e.is(this.$liveBlock))return;this.$liveBlock.off("dblclick"),this.$liveBlock.removeClass("active"),this.disableTextEdit(this.$liveBlock),this.$liveBlock=null}this.$liveBlock=e,this.$liveBlock.on("dblclick",(function(e){e.stopPropagation();var o=t(this).parent(".du-live-layout");o&&i.setActiveLiveBlock(o)})),this.locateToolbar(),this.$liveBlock.addClass("active"),this.activeLiveBlockParentSortable()},n.prototype.locateToolbar=function(){if(this.$liveBlock&&this.$liveBlock.length>0){var t=this.$liveBlock.offset(),e=t.top-26;this.$toolbar.css({top:e+"px",left:t.left}).show(),console.log(t)}},n.prototype.editLiveBlock=function(){if(this.$liveBlock&&this.$liveBlock.length>0)if("A"==this.$liveBlock[0].tagName){var t=prompt("请输入url",this.$liveBlock.attr("href"));t&&this.$liveBlock.attr("href",t)}else if(this.$liveBlock.hasClass("img-holder"))this.enableEditImageBg(this.$liveBlock);else if("none"!=this.$liveBlock.css("backgroundImage"))this.enableEditImageBg(this.$liveBlock);else{var e=this.$liveBlock.find(">img");e.length>0?this.enableEditImage(e):null!=this.$liveBlock.attr("contentEditable")?(console.log(this.$liveBlock.attr("contentEditable")),this.disableTextEdit(this.$liveBlock)):this.enableTextEdit(this.$liveBlock)}},n.prototype.disableTextEdit=function(e){var i=t(e);this.$editCtrl.removeClass("active"),i.removeAttr("contentEditable"),n.WysiwygEditor.destroy(e)},n.prototype.enableTextEdit=function(e){var i=t(e);this.$editCtrl.addClass("active"),n.WysiwygEditor.edit(e),i.attr("contentEditable","true")},n.prototype.enableEditImage=function(e){var i=e.attr("src"),o=t("#du-live-image-setting-dialog"),n=o.find("input[type=text]");n.val(i);var l=o.find(".confirm-btn");l.off("click"),l.on("click",(function(){e.attr("src",n.val()),o.modal("hide")})),o.modal("show")},n.prototype.enableEditImageBg=function(e){var i=/url\(['"]{0,1}(.*?)['"]{0,1}\)/i.exec(e.css("backgroundImage")),o="";i&&(o=i[1].replace(window.location.origin,""));var n=t("#du-live-image-setting-dialog"),l=n.find("input[type=text]");l.val(o);var r=n.find(".confirm-btn");r.off("click"),r.on("click",(function(){e.css("backgroundImage","url("+l.val()+")"),n.modal("hide")})),n.modal("show")},n.prototype.deleteLiveBlock=function(){this.$toolbar.hide();var t=this.$liveBlock.parent(".du-live-element-layout");(0==t.length&&(t=this.$liveBlock.parent(".live-content"),console.log(t)),this.$liveBlock.remove(),this.$liveBlock=null,t.length>0)&&(0==t.find(e).length&&this.appendPlaceHolder(t))},n.prototype.initElementPlaceHolder=function(){this.$liveContent.find(".du-live-element-layout").each((function(){var e=t(this);0==e[0].children.length&&this.appendPlaceHolder.appendTo(e)})),0==this.$liveContent[0].children.length&&this.appendPlaceHolder(this.$liveContent)},n.prototype.appendPlaceHolder=function(e){t('<div class="du-placeholder"></div>').appendTo(e)},n.prototype.saveContent=function(){this.$toolbar.appendTo(this.$element),this.$liveBlock&&this.$liveBlock.removeClass("active");var e={content:this.$liveContent.html()};e[yii.getCsrfParam()]=yii.getCsrfToken();var i="/admin.php?r=cms/live-editor/save&pageId="+this.options.pageId+"&language="+this.options.language;t.post(i,e,(function(t){alert("success")}))};var l=t.fn.liveEditor;t.fn.liveEditor=function(e){var o=arguments;return this.each((function(){var l=t(this),r=l.data("bs.live-editor"),a=t.extend({},n.DEFAULTS,l.data(),"object"==i(e)&&e);r||l.data("bs.live-editor",r=new n(this,a)),"string"==typeof e&&r[e].call(r,o[1])}))},t.fn.liveEditor.Constructor=n,t.fn.liveEditor.noConflict=function(){return t.fn.liveEditor=l,this},t(".du-live-editor").liveEditor()}(jQuery)},262:function(t,e){},264:function(t,e){},266:function(t,e){},268:function(t,e){},270:function(t,e){}});
>>>>>>> febad5cd2cd8c593904f69708fc2fb2a21dfc5ec
