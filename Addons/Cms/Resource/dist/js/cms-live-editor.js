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

+function ($) {
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

  var LiveEditor = function LiveEditor(element, options) {
    var that = this;
    this.options = options;
    this.$element = $(element);
    this.$liveBlock = null;
    this.$liveElement = null;
    this.$toolbar = this.$element.find(elemToolbar);
    this.$workspace = this.$element.find(elemEditorWorkspace).sortable(options.sortable);
    this.$sortableContainer = this.$workspace;
    this.$delCtrl = this.$element.find(elemDelHandle).on("click", function (e) {
      e.preventDefault();
      that.deleteLiveBlock();
    });
    this.$editCtrl = this.$element.find(elemEditHandle).on("click", function (e) {
      e.preventDefault();
      $(this).toggleClass("active");
      that.editLiveBlock();
    });
    this.initControlDraggable();
  };

  LiveEditor.DEFAULTS = {
    sortable: {
      placeholder: "ui-state-highlight",
      handle: elemMoveHandle,
      receive: function receive(event, ui) {
        LiveEditor.loadBlockCode(ui.helper, ui.helper);
      }
    }
  };

  LiveEditor.loadBlockCode = function (targetUI, dataUI) {
    $.get('/admin.php?r=cms/live-editor/load-code&id=' + dataUI.data('id'), function (data) {
      targetUI.replaceWith(data);
    });
  };

  LiveEditor.prototype.initControlDraggable = function () {
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
  }; //激活 block ,则选择parent 为sortable 容器，销毁上一个sortable容器


  LiveEditor.prototype.activeliveBlockParentSortable = function () {
    if (this.$sortableContainer) {
      this.$sortableContainer.sortable("destroy");
    }

    this.$sortableContainer = this.$liveBlock.parents();

    if (this.$sortableContainer.length > 0) {
      this.$sortableContainer.sortable(this.options.sortable);
      this.$liveBlock.find(elePlaceholder).droppable({
        drop: function drop(e, ui) {
          LiveEditor.loadBlockCode($(this), ui.helper);
        },
        over: function over(e, ui) {
          $(this).addClass('active');
        }
      });
    }
  };

  LiveEditor.prototype.setActiveLiveBlock = function (block) {
    var that = this; //移除上一个block的dblclick事件绑定

    if (this.$liveBlock) {
      this.$liveBlock.off('dblclick');
      this.disableTextEdit(this.$liveBlock);
      this.$liveBlock = null;
    }

    this.$liveBlock = block; //重新绑定dblclick,操作父 layout

    this.$liveBlock.on('dblclick', function (e) {
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
    this.$toolbar.appendTo(this.$liveBlock); //启动父元素为sortable

    this.activeliveBlockParentSortable();
  };
  /**
   * 编辑模式
   */


  LiveEditor.prototype.editLiveBlock = function () {
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
  }; //popline 编辑器


  LiveEditor.prototype.disableTextEdit = function (element) {
    var liveElement = $(element);
    this.$editCtrl.removeClass("active");
    liveElement.attr('contenteditable', false);
    liveElement.popline("destroy");
  };

  LiveEditor.prototype.enableTextEdit = function (element) {
    var liveElement = $(element);
    this.$editCtrl.addClass("active");
    liveElement.attr('contenteditable', true);
    liveElement.popline({
      position: 'fixed'
    });
  }; //图片编辑器


  LiveEditor.prototype.enableEditImage = function (imageHolder) {
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
    this.$toolbar.appendTo(this.$element);
    var parent = this.$liveBlock.parent();
    this.$liveBlock.remove();
    this.$liveBlock = null;

    if (parent.hasClass(elemLiveElementLayout)) {
      if ($.trim(parent.html()) == '') {
        $('<div class="du-placeholder"></div>').appendTo(parent);
      }
    }
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
      content: this.$workspace.html()
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


  $(document).on('click.bs.live-editor.active-block.data-api', elemBlock, function (e) {
    e.stopPropagation();
    var block = $(this);

    if (block.hasClass('active')) {
      return;
    }

    var editor = block.parents(elemEditor);
    Plugin.call(editor, 'setActiveLiveBlock', block);
  });
  $(document).on('click.bs.live-editor.save-content.data-api', '#du-live-editor-save-button', function (e) {
    e.preventDefault();
    var editor = $(elemEditor);
    Plugin.call(editor, 'saveContent');
  }); //auto bind

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

/***/ 0:
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** multi ./Addons/Cms/Resource/src/js/cms-live-editor.js ./Addons/Cms/Resource/src/less/cms.less ./Addons/Cms/Resource/src/less/cms-live-editor.less ./Themes/Basic/assets/src/less/basic.less ./Themes/Du/assets/src/less/du.less ./Themes/LingShan/assets/src/less/lingshan.less ./Themes/LongYu/assets/src/less/longyu.less ./Themes/XiaoSen/assets/src/less/xiaosen.less ./public/duadmin/src/less/DUAdmin.less ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! D:\workspace\DuAdmin\Addons\Cms\Resource\src\js\cms-live-editor.js */"./Addons/Cms/Resource/src/js/cms-live-editor.js");
__webpack_require__(/*! D:\workspace\DuAdmin\Addons\Cms\Resource\src\less\cms.less */"./Addons/Cms/Resource/src/less/cms.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Addons\Cms\Resource\src\less\cms-live-editor.less */"./Addons/Cms/Resource/src/less/cms-live-editor.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Themes\Basic\assets\src\less\basic.less */"./Themes/Basic/assets/src/less/basic.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Themes\Du\assets\src\less\du.less */"./Themes/Du/assets/src/less/du.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Themes\LingShan\assets\src\less\lingshan.less */"./Themes/LingShan/assets/src/less/lingshan.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Themes\LongYu\assets\src\less\longyu.less */"./Themes/LongYu/assets/src/less/longyu.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Themes\XiaoSen\assets\src\less\xiaosen.less */"./Themes/XiaoSen/assets/src/less/xiaosen.less");
module.exports = __webpack_require__(/*! D:\workspace\DuAdmin\public\duadmin\src\less\DUAdmin.less */"./public/duadmin/src/less/DUAdmin.less");


/***/ })

/******/ });