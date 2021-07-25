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

  var LiveEditor = function LiveEditor(element, options) {
    this.options = options;
    this.$element = $(element);
    this.$liveBlock = null;
    this.$liveElement = null;
    this.$toolbar = this.$element.find(elemToolbar);
    this.$workspace = this.$element.find(elemEditorWorkspace);
    this.initWorkspaceSortable();
  };

  LiveEditor.DEFAULTS = {
    sortable: {
      placeholder: "ui-state-highlight",
      //handle: elemMoveHandle,
      receive: function receive(event, ui) {
        $.get('/admin.php?r=cms/live-editor/load-place-holder&id=' + ui.helper.data('id'), function (data) {
          ui.helper.replaceWith(data);
        });
      }
    }
  };

  LiveEditor.prototype.initWorkspaceSortable = function () {
    this.$workspace.sortable(this.options.sortable);
    this.$element.find(elemCtrolLayout).draggable({
      connectToSortable: elemEditorWorkspace,
      helper: "clone",
      revert: "invalid"
    });
    this.$element.find(elemCtrolElement).draggable({
      connectToSortable: elemElement,
      helper: "clone",
      revert: "invalid"
    });
  };

  LiveEditor.prototype.initElementBoxSortable = function () {
    if (this.$liveBlock) {
      this.$liveBlock.find(elemElement).sortable(this.options.sortable);
    }
  };

  LiveEditor.prototype.setActiveBlock = function (block) {
    this.$liveBlock = block;
    this.$element.find(elemBlock).removeClass('active');
    this.$liveBlock.addClass('active');
    this.$toolbar.appendTo(this.$liveBlock);
    this.$workspace.sortable("option", "handle", elemMoveHandle);
    this.initElementBoxSortable();
  };

  LiveEditor.prototype.settingImage = function (imageHolder) {
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

  LiveEditor.prototype.deleteBlock = function () {
    this.$liveBlock.remove();
    this.$liveBlock = null;
  };

  LiveEditor.prototype.activeLineEditor = function (element) {
    var liveElement = $(element);
    liveElement.attr('contenteditable', true);
    liveElement.popline({
      position: 'fixed'
    });
  };

  LiveEditor.prototype.saveContent = function () {
    this.$toolbar.appendTo(this.$element);

    if (this.$liveBlock) {
      this.$liveBlock.removeClass('active');
    }

    var data = {
      content: this.$workspace.html()
    };
    data[yii.getCsrfToken()] = yii.getCsrfParam();
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
    var block = $(this);
    var editor = block.parents(elemEditor);
    Plugin.call(editor, 'setActiveBlock', block);
  });
  $(document).on('click.bs.live-editor.delete-block.data-api', elemToolDel, function (e) {
    var tool = $(this);
    var editor = tool.parents(elemEditor);
    Plugin.call(editor, 'deleteBlock');
  });
  $(document).on('dblclick.bs.live-editor.edit-element.data-api', elemLiveElement, function (e) {
    var element = $(this);
    var editor = element.parents(elemEditor);
    Plugin.call(editor, 'activeLineEditor', element);
  });
  $(document).on('dblclick.bs.live-editor.setting-image.data-api', elemImageHolder, function (e) {
    e.preventDefault();
    var imageHolder = $(this);
    var editor = imageHolder.parents(elemEditor);
    Plugin.call(editor, 'settingImage', imageHolder);
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

/***/ "./public/duadmin/src/less/DUAdmin.less":
/*!**********************************************!*\
  !*** ./public/duadmin/src/less/DUAdmin.less ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./themes/Basic/assets/src/less/basic.less":
/*!*************************************************!*\
  !*** ./themes/Basic/assets/src/less/basic.less ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./themes/Du/assets/src/less/du.less":
/*!*******************************************!*\
  !*** ./themes/Du/assets/src/less/du.less ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./themes/LingShan/assets/src/less/lingshan.less":
/*!*******************************************************!*\
  !*** ./themes/LingShan/assets/src/less/lingshan.less ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./themes/LongYu/assets/src/less/longyu.less":
/*!***************************************************!*\
  !*** ./themes/LongYu/assets/src/less/longyu.less ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./themes/XiaoSen/assets/src/less/xiaosen.less":
/*!*****************************************************!*\
  !*** ./themes/XiaoSen/assets/src/less/xiaosen.less ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** multi ./Addons/Cms/Resource/src/js/cms-live-editor.js ./Addons/Cms/Resource/src/less/cms.less ./Addons/Cms/Resource/src/less/cms-live-editor.less ./themes/Basic/assets/src/less/basic.less ./themes/Du/assets/src/less/du.less ./themes/LingShan/assets/src/less/lingshan.less ./themes/LongYu/assets/src/less/longyu.less ./themes/XiaoSen/assets/src/less/xiaosen.less ./public/duadmin/src/less/DUAdmin.less ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! D:\workspace\DuAdmin\Addons\Cms\Resource\src\js\cms-live-editor.js */"./Addons/Cms/Resource/src/js/cms-live-editor.js");
__webpack_require__(/*! D:\workspace\DuAdmin\Addons\Cms\Resource\src\less\cms.less */"./Addons/Cms/Resource/src/less/cms.less");
__webpack_require__(/*! D:\workspace\DuAdmin\Addons\Cms\Resource\src\less\cms-live-editor.less */"./Addons/Cms/Resource/src/less/cms-live-editor.less");
__webpack_require__(/*! D:\workspace\DuAdmin\themes\Basic\assets\src\less\basic.less */"./themes/Basic/assets/src/less/basic.less");
__webpack_require__(/*! D:\workspace\DuAdmin\themes\Du\assets\src\less\du.less */"./themes/Du/assets/src/less/du.less");
__webpack_require__(/*! D:\workspace\DuAdmin\themes\LingShan\assets\src\less\lingshan.less */"./themes/LingShan/assets/src/less/lingshan.less");
__webpack_require__(/*! D:\workspace\DuAdmin\themes\LongYu\assets\src\less\longyu.less */"./themes/LongYu/assets/src/less/longyu.less");
__webpack_require__(/*! D:\workspace\DuAdmin\themes\XiaoSen\assets\src\less\xiaosen.less */"./themes/XiaoSen/assets/src/less/xiaosen.less");
module.exports = __webpack_require__(/*! D:\workspace\DuAdmin\public\duadmin\src\less\DUAdmin.less */"./public/duadmin/src/less/DUAdmin.less");


/***/ })

/******/ });