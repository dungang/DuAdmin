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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Public/src/js/advance-select.js":
/*!*****************************************!*\
  !*** ./Public/src/js/advance-select.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

+function ($) {
  /**
   * 
   * @param string el 
   * @param object options 
   */
  var AdvanceSelect = function AdvanceSelect(el, options) {
    this.options = options;
    this.$element = $(el);
    this.init();
    this.handleCreateForm();
    this.handleSelectChange();
    this.handleInputChange();
    this.handleRemove();
  };

  AdvanceSelect.prototype.init = function () {
    this.$formButton = this.$element.find('a[create-form]');
    this.$input = this.$element.find('input[type=' + this.options.inputType + ']');
    this.$pjaxContainer = this.$element.find('div[role=data-pjax-container]');
    this.$select = this.$element.find('select'); //https://select2.org/data-sources/formats

    this.$select.select2({
      ajax: {
        url: this.options.optionLoadUrl,
        dataType: 'json'
      }
    });
  };

  AdvanceSelect.prototype.handleCreateForm = function () {
    var options = this.options;
    this.$formButton.on('click', function (e) {
      var that = $(this);
      e.preventDefault();
      layer.open({
        type: 2,
        title: options.formTitle,
        maxmin: false,
        shadeClose: true,
        //点击遮罩关闭层
        scrollbar: false,
        //屏蔽滚动条
        area: options.formArea,
        content: that.attr("href")
      });
    });
  };

  AdvanceSelect.prototype.handleInputChange = function () {
    var url = this.options.resultLoadUrl + "?" + this.$input.attr("name") + '=' + this.$input.val();
    $.pjax({
      url: url,
      container: '#' + this.options.pjaxId,
      push: false,
      scrollTo: false,
      async: false
    });
  };

  AdvanceSelect.prototype.handleSelectChange = function () {
    var _this = this;

    this.$select.on('change', function (e) {
      _this.addOne(_this.$select.val());
    });
  };

  AdvanceSelect.prototype.addOne = function (val) {
    var vals = this.$input.val();
    var ids = vals.split(',').filter(function (id) {
      return !!id;
    });
    ids.push(val);
    this.$input.val(ids.distinct().join(','));
    this.handleInputChange();
  };

  AdvanceSelect.prototype.handleSubmit = function (data) {
    var val = this.options.onSubmitSuccess.call(this, data);
    console.log("AdvanceSelect Handle Submit receiver val: " + val);

    if (!!val) {
      this.addOne(val);
      layer.closeAll();
    }
  };
  /**
   * 删除选择的结果
   */


  AdvanceSelect.prototype.handleRemove = function () {
    var that = this;
    this.$element.on('click', 'a[remove]', function (e) {
      e.preventDefault();
      var removeButton = $(this);

      if (confirm("确定移除？")) {
        var val = that.$input.val();
        ids = val.trim().split(',').filter(function (id) {
          return !!id && id != removeButton.data('val');
        });
        that.$input.val(ids.join(','));
        that.handleInputChange();
      }
    });
  };

  AdvanceSelect.DEFAULTS = {
    inputType: 'hidden',
    resultLoadUrl: '',
    //选择的结果数据加载地址
    optionLoadUrl: '',
    //下拉框选择项数据加载地址
    pjaxId: '',
    //数据预览容器id
    formTitle: "添加",
    formArea: ['800px', '600px'],
    //layer 宽度 高度 
    onSubmitSuccess: function onSubmitSuccess(data) {
      console.log(data);
    }
  };

  function Plugin(option, param) {
    return this.each(function () {
      var $this = $(this);
      var data = $this.data('bs.advanceSelect');

      if (!data) {
        var options = $.extend({}, AdvanceSelect.DEFAULTS, $this.data(), _typeof(option) == 'object' && option);
        $this.data('bs.advanceSelect', data = new AdvanceSelect(this, options));
      }

      if (typeof option == 'string') data[option].call(data, param);
    });
  }

  var old = $.fn.advanceSelect;
  $.fn.advanceSelect = Plugin;
  $.fn.advanceSelect.Constructor = AdvanceSelect; // NO CONFLICT
  // =================

  $.fn.advanceSelect.noConflict = function () {
    $.fn.advanceSelect = old;
    return this;
  };
}(jQuery);

/***/ }),

/***/ "./Public/src/js/affix-navbar.js":
/*!***************************************!*\
  !*** ./Public/src/js/affix-navbar.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  $.fn.navbarAffix = function (defClass, affixClass) {
    return this.each(function () {
      var navbar = $(this);
      navbar.affix({
        offset: {
          top: 50,
          bottom: function bottom() {
            return this.bottom = $('.footer').outerHeight(true);
          }
        }
      }).on('affixed.bs.affix', function () {
        if (!$(this).data('affix-one')) {
          $(this).removeClass(defClass).addClass(affixClass);
        }
      }).on("affixed-top.bs.affix", function () {
        if (!$(this).data('affix-one')) {
          $(this).removeClass(affixClass).addClass(defClass);
        }
      });
    });
  };
})(jQuery);

/***/ }),

/***/ "./Public/src/js/checkbox-selection.js":
/*!*********************************************!*\
  !*** ./Public/src/js/checkbox-selection.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

+function ($) {
  /**
   * checkbox list 多选 全选的功能
   * @returns 
   */
  $.fn.checkboxSelection = function () {
    return this.each(function () {
      var plugin = $(this);
      var hiddenInput = plugin.find('input[type=hidden]');
      var allCheckbox = plugin.find('input[value=all]');
      var checkboxList = plugin.find('input[type=checkbox]');
      var length = checkboxList.length;
      checkboxList.on("click", function () {
        var checkbox = $(this);
        var checkedListOld = plugin.find('input[type=checkbox]:checked');

        if (checkbox.val() == 'all') {
          if (checkbox.prop("checked")) {
            checkboxList.prop("checked", true);
          } else {
            checkboxList.prop("checked", false);
          }
        } else {
          var allChecked = checkboxList.prop("checked");

          if (allChecked && checkedListOld.length < length) {
            allCheckbox.prop("checked", false);
          } else if (!allChecked && checkedListOld.length < length - 1) {
            allCheckbox.prop("checked", false);
          } else {
            allCheckbox.prop("checked", true);
          }
        }

        var data = [];
        plugin.find('input[type=checkbox]:checked').each(function (idx, checkbox) {
          data.push($(checkbox).val());
        });
        hiddenInput.val(data.join(","));
      });
    });
  };
}(jQuery);

/***/ }),

/***/ "./Public/src/js/extend.js":
/*!*********************************!*\
  !*** ./Public/src/js/extend.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _createForOfIteratorHelper(o) { if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (o = _unsupportedIterableToArray(o))) { var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var it, normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(n); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

/**
 * js lib extend 扩展
 */
Date.prototype.format = function (fmt) {
  var o = {
    "M+": this.getMonth() + 1,
    //月份
    "d+": this.getDate(),
    //日
    "h+": this.getHours(),
    //小时
    "m+": this.getMinutes(),
    //分
    "s+": this.getSeconds(),
    //秒
    "q+": Math.floor((this.getMonth() + 3) / 3),
    //季度
    "S": this.getMilliseconds() //毫秒

  };
  if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));

  for (var k in o) {
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
  }

  return fmt;
}; //数组Array进行原型prototype扩展后带来的for in遍历问题


Array.prototype.distinct = function () {
  var arr = this;
  var result = [];

  var _iterator = _createForOfIteratorHelper(arr),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var val = _step.value;

      if (result.indexOf(val) == -1) {
        result.push(val);
      }
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }

  return result;
};

/***/ }),

/***/ "./Public/src/js/fix-col-height.js":
/*!*****************************************!*\
  !*** ./Public/src/js/fix-col-height.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * 解决栅格系统的col高度不同导致浮动的问题
 */
+function ($) {
  var FixColHeight = function FixColHeight(el) {
    this.$element = $(el);
    console.log(this.$element);
    this.$columns = this.$element.find('[class*="col-"]');
  };

  FixColHeight.prototype.resize = function () {
    var maxHeight = 0;
    this.$columns.height('auto');
    this.$columns.each(function () {
      var $col = $(this);
      var height = $col.height();

      if (height > maxHeight) {
        maxHeight = height;
      }
    });
    this.$columns.height(maxHeight);
  };

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this);
      var data = $this.data('bs.fixcolheight');

      if (!data) {
        $this.data('bs.fixcolheight', data = new FixColHeight(this));
      }

      if (typeof option == 'string') data[option].call(data);
    });
  }

  var old = $.fn.fixColHeight;
  $.fn.fixColHeight = Plugin;
  $.fn.fixColHeight.Constructor = FixColHeight; // NO CONFLICT
  // =================

  $.fn.fixColHeight.noConflict = function () {
    $.fn.fixColHeight = old;
    return this;
  }; // DATA-API
  // ==============


  var reHeightHandler = function reHeightHandler() {
    $('.fix-col-height').each(function () {
      Plugin.call($(this), 'resize');
    });
  };

  $(window).on('load.bs.fixcolheight.data-api', reHeightHandler);
  $(window).on('resize.bs.fixcolheight.data-api', reHeightHandler);
}(jQuery);

/***/ }),

/***/ "./Public/src/js/frontend.js":
/*!***********************************!*\
  !*** ./Public/src/js/frontend.js ***!
  \***********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var wowjs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! wowjs */ "./node_modules/wowjs/dist/wow.js");
/* harmony import */ var wowjs__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(wowjs__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _extend__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./extend */ "./Public/src/js/extend.js");
/* harmony import */ var _extend__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_extend__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _loading__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./loading */ "./Public/src/js/loading.js");
/* harmony import */ var _loading__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_loading__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _affix_navbar__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./affix-navbar */ "./Public/src/js/affix-navbar.js");
/* harmony import */ var _affix_navbar__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_affix_navbar__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _fix_col_height__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./fix-col-height */ "./Public/src/js/fix-col-height.js");
/* harmony import */ var _fix_col_height__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_fix_col_height__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _video_background__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./video-background */ "./Public/src/js/video-background.js");
/* harmony import */ var _video_background__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_video_background__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _load_more__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./load-more */ "./Public/src/js/load-more.js");
/* harmony import */ var _load_more__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_load_more__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _simple_modal__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./simple-modal */ "./Public/src/js/simple-modal.js");
/* harmony import */ var _simple_modal__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_simple_modal__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _advance_select__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./advance-select */ "./Public/src/js/advance-select.js");
/* harmony import */ var _advance_select__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_advance_select__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _linkage_select__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./linkage-select */ "./Public/src/js/linkage-select.js");
/* harmony import */ var _linkage_select__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_linkage_select__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _layer_form_page__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./layer-form-page */ "./Public/src/js/layer-form-page.js");
/* harmony import */ var _layer_form_page__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_layer_form_page__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _checkbox_selection__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./checkbox-selection */ "./Public/src/js/checkbox-selection.js");
/* harmony import */ var _checkbox_selection__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_checkbox_selection__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var _radio_card__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./radio-card */ "./Public/src/js/radio-card.js");
/* harmony import */ var _radio_card__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(_radio_card__WEBPACK_IMPORTED_MODULE_12__);













$(function () {
  // css3
  var isIE = function isIE(ver) {
    ver = ver || '';
    var b = document.createElement('b');
    b.innerHTML = '<!--[if IE ' + ver + ']>1<![endif]-->';
    return b.innerHTML === '1';
  };

  if (isIE(8) || isIE(7)) {} else {
    //        动画
    var wow = new wowjs__WEBPACK_IMPORTED_MODULE_0__["WOW"]({
      animateClass: 'animated'
    });
    wow.init();
  }
});

/***/ }),

/***/ "./Public/src/js/layer-form-page.js":
/*!******************************************!*\
  !*** ./Public/src/js/layer-form-page.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

+function ($) {
  /**
   * layer ui 的表单的强化，将表单的submit拦截为ajax请求
   * 成功之后，触发父窗口指定的元素的submitSuccess事件方法
   * @returns 
   */
  $.fn.layerFormPage = function () {
    return this.each(function () {
      var that = $(this);
      var parentHtmlId = that.data("targetHtmlId"); //阻拦默认的表单提交事件，自动替换为ajax请求

      that.on('submit', 'form', function (event) {
        event.preventDefault();
        $(event.target).ajaxSubmit({
          headers: {
            'AJAX-SUBMIT': 'AJAX-SUBMIT'
          },
          success: function success(data) {
            var type = "error";

            if (data.status == 'success') {
              type = "success";
            }

            showMsg(data.message, type == "success" ? 1 : 2, 3000);

            if (data.status == 'success') {
              //自定义处理结果
              //每个窗口的jquery 对象是不一样的，必须应用父窗口的jquery
              var parentElement = window.parent.jQuery(parentHtmlId, window.parent.document);

              if (parentElement.length == 0) {
                showMsg("表单页的定义的父窗口的容器Id错误:" + parentHtmlId, 2, 3000);
              }

              parentElement.advanceSelect('handleSubmit', data);
            }
          },
          error: function error(xhr, status, _error) {
            showMsg(xhr.responseJSON.message, 2, 3000);
          }
        });
      });
    });
  };

  function showMsg(message, icon, timeout) {
    layer.msg(message, {
      skin: 'layui-layer-molv',
      icon: icon,
      time: timeout
    });
  }
}(jQuery);

/***/ }),

/***/ "./Public/src/js/linkage-select.js":
/*!*****************************************!*\
  !*** ./Public/src/js/linkage-select.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _createForOfIteratorHelper(o) { if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (o = _unsupportedIterableToArray(o))) { var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var it, normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(n); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

(function ($) {
  function isNotEmptyObject(e) {
    var t;

    for (t in e) {
      return true;
    }

    return false;
  }

  function assembleOptions(data, value) {
    var options = '';

    for (var p in data) {
      var txt = data[p]; //数组Array进行原型prototype扩展后带来的for in遍历问题

      if (typeof txt == 'function') {
        continue;
      }

      if (p == value) {
        options += "<option value='" + p + "' selected >" + txt + "</option>";
      } else {
        options += "<option value='" + p + "'>" + txt + "</option>";
      }
    }

    return options;
  }

  function process(queue) {
    var select = queue.shift();
    if (select == null) return;
    $self = $(select);
    var data = $self.data();
    $self.empty(); // 清空自己

    var param = {};

    if (data.parentId != null && data.param) {
      param[data.param] = data.parentId;
    } else if (data.parent && data.param) {
      var parent = $(data.parent);
      var parent2 = $(parent.data('parent'));

      if (parent && data.url && parent.val() != null) {
        param[data.param] = parent.val();
      } else if (parent2 && data.url && parent2.val() != null) {
        param[data.param] = parent2.val();
      }
    } else {
      alert('连级下拉框参数配置不正确:' + $self.attr('name'));
    }

    if (isNotEmptyObject(param)) {
      $.getJSON(data.url, param, function (res) {
        $self.append(assembleOptions(res, data.value));
        process(queue);
      });
    }
  }

  function initRoot() {
    var root = $('select[data-linkage=root]');

    if (root.length > 0) {
      var queue = [root];
      var subs = root.data('queue').split(',');

      if (!!subs) {
        var _iterator = _createForOfIteratorHelper(subs),
            _step;

        try {
          for (_iterator.s(); !(_step = _iterator.n()).done;) {
            var sub = _step.value;
            queue.push(sub);
          }
        } catch (err) {
          _iterator.e(err);
        } finally {
          _iterator.f();
        }
      }

      process(queue);
    }
  }

  $.fn.linkageSelect = function () {
    $(document).off('change.site.linkage');
    initRoot();
    $(document).on('change.site.linkage', 'select[data-linkage]', function () {
      var subs = $(this).data('queue');

      if (!!subs) {
        var queue = subs.split(',');
        process(queue);
      }
    });
  };
})(jQuery);

/***/ }),

/***/ "./Public/src/js/load-more.js":
/*!************************************!*\
  !*** ./Public/src/js/load-more.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * 加载更多
 */
+function ($) {
  var style = "width: 100%;padding: 15px;margin-bottom: 15px;border: 1px solid #ffc6d1;border-radius: 3px;background-color: #ffe0e5;color: #FE2E54;";

  function scrollOnBottom() {
    var scrollHeight = Math.ceil($(document).scrollTop());
    var windowHeight = $(window).height();
    var documentHeight = $(document).height();
    return scrollHeight + windowHeight >= documentHeight;
  }

  var spinnner = $('<div class="text-center col-xs-12" style="' + style + '"><i class="fa fa-spinner"></i> 加载中...</div>');
  var noMessage = $('<div class="text-center col-xs-12"style="' + style + '"> 没有更多了 </div>');

  $.fn.scrolloader = function (options) {
    return this.each(function () {
      var _this = $(this);

      var totalPages = parseInt(options.totalPages);
      $(window).scroll(function () {
        var page = parseInt(_this.attr('data-page') || 2);
        var status = _this.attr('data-status') || 'off';
        var isBottom = scrollOnBottom();
        var data = options.data || {};

        if (status == 'off' && isBottom && totalPages >= page) {
          _this.after(spinnner);

          data.page = page;

          _this.attr('data-page', page + 1);

          _this.attr('data-status', 'on');

          var timer = setTimeout(function () {
            $.get(options.url, data, function (data) {
              _this.append(data);

              clearTimeout(timer);

              _this.attr('data-status', 'off');

              spinnner.remove();
            });
          }, 800);
        }

        if (status == 'off' && totalPages < page) {
          _this.after(noMessage);
        }
      });
    });
  };
}(jQuery);

/***/ }),

/***/ "./Public/src/js/loading.js":
/*!**********************************!*\
  !*** ./Public/src/js/loading.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

+function ($) {
  //https://layui.itze.cn/doc/modules/layer.html
  var loading = null;
  $(document).on('ajaxStart', function () {
    if (!loading) {
      loading = layer.load(0, {
        shade: [0.1, '#000'] //0.1透明度的白色背景

      });
    }
  });
  $(document).on('ajaxComplete', function () {
    if (loading) {
      layer.close(loading);
      loading = null;
    }
  });
}(jQuery);

/***/ }),

/***/ "./Public/src/js/radio-card.js":
/*!*************************************!*\
  !*** ./Public/src/js/radio-card.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

+function ($) {
  $.fn.radioCard = function () {
    return this.each(function () {
      var cardContainer = $(this);
      triggerActiveCard(cardContainer);
      cardContainer.find('input[type=radio]').on("click", function (e) {
        console.log($(this).prop("checked"));
        triggerActiveCard(cardContainer);
      });
    });
  };

  function triggerActiveCard(cardContainer) {
    cardContainer.find('.radio-card').removeClass("active");
    var radio = cardContainer.find('input[type=radio]:checked');
    console.log(radio);

    if (radio.length > 0) {
      console.log(radio.parents('.radio-card'));
      radio.parents('.radio-card').addClass("active");
    }
  } // // role=radio-card
  // $(document).on('click', ".radio-card", function(e) {
  //     e.preventDefault();
  //     $(this).find('input[type=radio]').trigger('click');
  // });

}(jQuery);

/***/ }),

/***/ "./Public/src/js/simple-modal.js":
/*!***************************************!*\
  !*** ./Public/src/js/simple-modal.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

+function ($) {
  var SimpleModal = function SimpleModal(el, options) {
    this.options = options;
    this.$modal = $(el);
    this.$pjaxContainer = null;
    this.$pjaxId = null;
    this.handleHidden();
    this.handleShow();
    this.handleSubmit();
  };

  SimpleModal.prototype.handleHidden = function () {
    var _this = this;

    // 清空对象
    this.$modal.on('hidden.bs.modal', function (e) {
      _this.$modal.data('bs.modal', null);

      _this.$modal.find('.modal-body').empty();

      _this.$modal.find('script').remove();

      _this.$modal.find('link').remove();

      _this.$pjaxContainer = null;
      _this.pjaxId = null;
    });
  };

  SimpleModal.prototype.handleShow = function () {
    var _this2 = this;

    // 根据属性调整modal窗口大小
    this.$modal.on('show.bs.modal', function (e) {
      var targetBtn = $(e.relatedTarget);

      if (targetBtn.attr('data-toggle') == 'modal') {
        _this2.pjaxId = targetBtn.data("pjax-target");

        if (_this2.pjaxId) {
          _this2.$pjaxContainer = $('#' + _this2.pjaxId);
        } else {
          _this2.$pjaxContainer = targetBtn.parents('[data-pjax-container]');
          _this2.pjaxId = _this2.$pjaxContainer.attr("id");
        }

        if (_this2.options.debug) {
          console.log('simple modal debug: pjax container');
          console.log(_this2.$pjaxContainer);
        }

        var size = targetBtn.data('modal-size');
        $(e.target).find('.modal-dialog').removeClass('modal-sm modal-lg').addClass(size ? size : '');
      }
    });
  };

  SimpleModal.prototype.showMsg = function (message, icon) {
    layer.msg(message, {
      skin: 'layui-layer-molv',
      icon: icon,
      time: this.options.timeout
    });
  };

  SimpleModal.prototype.handleSubmit = function () {
    var _this3 = this;

    //阻拦默认的表单提交事件，自动替换为ajax请求
    this.$modal.on('submit', 'form', function (event) {
      event.preventDefault();
      $(event.target).ajaxSubmit({
        headers: {
          'AJAX-SUBMIT': 'AJAX-SUBMIT'
        },
        success: function success(data) {
          var type = "error";

          if (data.status == 'success') {
            //自定义处理结果
            if (typeof _this3.options.customHandleResult == 'function') {
              _this3.options.customHandleResult.call(_this3, data);
            } else {
              if (_this3.$pjaxContainer && _this3.$pjaxContainer.length > 0) {
                _this3.handleResult(data);
              } else {
                window.location.reload();
              }
            }

            _this3.$modal.modal('hide');

            type = "success";
          }

          if (_this3.options.debug) {
            console.log('simple modal debug: notify');
            console.log(type);
            console.log(data);
          }

          _this3.showMsg(data.message, type == "success" ? 1 : 2);
        },
        error: function error(xhr, status, _error) {
          _this3.showMsg(xhr.responseJSON.message, 2);
        }
      });
    });
  };

  SimpleModal.prototype.handleResult = function (response) {
    if (this.options.debug) {
      var pjaxId = this.$pjaxContainer.attr('id');
      console.log('simple modal debug: pjax id');
      console.log(pjaxId);
    }

    if (!!this.pjaxId) {
      var url = this.$pjaxContainer.data("url");

      if (url) {
        $.pjax({
          url: url,
          container: '#' + this.pjaxId
        });
      } else {
        $.pjax.reload('#' + this.pjaxId);
      }
    } else {
      console.log("pjax not container id");
    }
  };

  SimpleModal.DEFAULTS = {
    debug: false,
    //是否调试
    notifyPosition: 'center',
    //通知位置
    customHandleResult: false,
    timeout: 3000
  };

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this);
      var data = $this.data('bs.simpleModal');

      if (!data) {
        var options = $.extend({}, SimpleModal.DEFAULTS, $this.data(), _typeof(option) == 'object' && option);
        $this.data('bs.simpleModal', data = new SimpleModal(this, options));
      }

      if (typeof option == 'string') data[option].call(data);
    });
  }

  var old = $.fn.simpleModal;
  $.fn.simpleModal = Plugin;
  $.fn.simpleModal.Constructor = SimpleModal; // NO CONFLICT
  // =================

  $.fn.simpleModal.noConflict = function () {
    $.fn.simpleModal = old;
    return this;
  };
}(jQuery);

/***/ }),

/***/ "./Public/src/js/video-background.js":
/*!*******************************************!*\
  !*** ./Public/src/js/video-background.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

+function ($) {
  function calcVideoSize() {
    $('.ifra-video, .iframe-video').each(function () {
      var _this = $(this);

      var parent = _this.parent();

      var p_width = parent.width();

      var s_width = _this.attr('width');

      var width = p_width > 510 ? s_width : p_width;
      var height = width * 488 / 866;

      _this.attr('width');

      _this.attr('width', width);

      _this.attr('height', height);
    });
  }

  $(window).on('load ', calcVideoSize);
  $(window).on('resize onorientationchange', calcVideoSize);
}(jQuery);

/***/ }),

/***/ "./node_modules/wowjs/dist/wow.js":
/*!****************************************!*\
  !*** ./node_modules/wowjs/dist/wow.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() {
  var MutationObserver, Util, WeakMap, getComputedStyle, getComputedStyleRX,
    bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  Util = (function() {
    function Util() {}

    Util.prototype.extend = function(custom, defaults) {
      var key, value;
      for (key in defaults) {
        value = defaults[key];
        if (custom[key] == null) {
          custom[key] = value;
        }
      }
      return custom;
    };

    Util.prototype.isMobile = function(agent) {
      return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(agent);
    };

    Util.prototype.createEvent = function(event, bubble, cancel, detail) {
      var customEvent;
      if (bubble == null) {
        bubble = false;
      }
      if (cancel == null) {
        cancel = false;
      }
      if (detail == null) {
        detail = null;
      }
      if (document.createEvent != null) {
        customEvent = document.createEvent('CustomEvent');
        customEvent.initCustomEvent(event, bubble, cancel, detail);
      } else if (document.createEventObject != null) {
        customEvent = document.createEventObject();
        customEvent.eventType = event;
      } else {
        customEvent.eventName = event;
      }
      return customEvent;
    };

    Util.prototype.emitEvent = function(elem, event) {
      if (elem.dispatchEvent != null) {
        return elem.dispatchEvent(event);
      } else if (event in (elem != null)) {
        return elem[event]();
      } else if (("on" + event) in (elem != null)) {
        return elem["on" + event]();
      }
    };

    Util.prototype.addEvent = function(elem, event, fn) {
      if (elem.addEventListener != null) {
        return elem.addEventListener(event, fn, false);
      } else if (elem.attachEvent != null) {
        return elem.attachEvent("on" + event, fn);
      } else {
        return elem[event] = fn;
      }
    };

    Util.prototype.removeEvent = function(elem, event, fn) {
      if (elem.removeEventListener != null) {
        return elem.removeEventListener(event, fn, false);
      } else if (elem.detachEvent != null) {
        return elem.detachEvent("on" + event, fn);
      } else {
        return delete elem[event];
      }
    };

    Util.prototype.innerHeight = function() {
      if ('innerHeight' in window) {
        return window.innerHeight;
      } else {
        return document.documentElement.clientHeight;
      }
    };

    return Util;

  })();

  WeakMap = this.WeakMap || this.MozWeakMap || (WeakMap = (function() {
    function WeakMap() {
      this.keys = [];
      this.values = [];
    }

    WeakMap.prototype.get = function(key) {
      var i, item, j, len, ref;
      ref = this.keys;
      for (i = j = 0, len = ref.length; j < len; i = ++j) {
        item = ref[i];
        if (item === key) {
          return this.values[i];
        }
      }
    };

    WeakMap.prototype.set = function(key, value) {
      var i, item, j, len, ref;
      ref = this.keys;
      for (i = j = 0, len = ref.length; j < len; i = ++j) {
        item = ref[i];
        if (item === key) {
          this.values[i] = value;
          return;
        }
      }
      this.keys.push(key);
      return this.values.push(value);
    };

    return WeakMap;

  })());

  MutationObserver = this.MutationObserver || this.WebkitMutationObserver || this.MozMutationObserver || (MutationObserver = (function() {
    function MutationObserver() {
      if (typeof console !== "undefined" && console !== null) {
        console.warn('MutationObserver is not supported by your browser.');
      }
      if (typeof console !== "undefined" && console !== null) {
        console.warn('WOW.js cannot detect dom mutations, please call .sync() after loading new content.');
      }
    }

    MutationObserver.notSupported = true;

    MutationObserver.prototype.observe = function() {};

    return MutationObserver;

  })());

  getComputedStyle = this.getComputedStyle || function(el, pseudo) {
    this.getPropertyValue = function(prop) {
      var ref;
      if (prop === 'float') {
        prop = 'styleFloat';
      }
      if (getComputedStyleRX.test(prop)) {
        prop.replace(getComputedStyleRX, function(_, _char) {
          return _char.toUpperCase();
        });
      }
      return ((ref = el.currentStyle) != null ? ref[prop] : void 0) || null;
    };
    return this;
  };

  getComputedStyleRX = /(\-([a-z]){1})/g;

  this.WOW = (function() {
    WOW.prototype.defaults = {
      boxClass: 'wow',
      animateClass: 'animated',
      offset: 0,
      mobile: true,
      live: true,
      callback: null,
      scrollContainer: null
    };

    function WOW(options) {
      if (options == null) {
        options = {};
      }
      this.scrollCallback = bind(this.scrollCallback, this);
      this.scrollHandler = bind(this.scrollHandler, this);
      this.resetAnimation = bind(this.resetAnimation, this);
      this.start = bind(this.start, this);
      this.scrolled = true;
      this.config = this.util().extend(options, this.defaults);
      if (options.scrollContainer != null) {
        this.config.scrollContainer = document.querySelector(options.scrollContainer);
      }
      this.animationNameCache = new WeakMap();
      this.wowEvent = this.util().createEvent(this.config.boxClass);
    }

    WOW.prototype.init = function() {
      var ref;
      this.element = window.document.documentElement;
      if ((ref = document.readyState) === "interactive" || ref === "complete") {
        this.start();
      } else {
        this.util().addEvent(document, 'DOMContentLoaded', this.start);
      }
      return this.finished = [];
    };

    WOW.prototype.start = function() {
      var box, j, len, ref;
      this.stopped = false;
      this.boxes = (function() {
        var j, len, ref, results;
        ref = this.element.querySelectorAll("." + this.config.boxClass);
        results = [];
        for (j = 0, len = ref.length; j < len; j++) {
          box = ref[j];
          results.push(box);
        }
        return results;
      }).call(this);
      this.all = (function() {
        var j, len, ref, results;
        ref = this.boxes;
        results = [];
        for (j = 0, len = ref.length; j < len; j++) {
          box = ref[j];
          results.push(box);
        }
        return results;
      }).call(this);
      if (this.boxes.length) {
        if (this.disabled()) {
          this.resetStyle();
        } else {
          ref = this.boxes;
          for (j = 0, len = ref.length; j < len; j++) {
            box = ref[j];
            this.applyStyle(box, true);
          }
        }
      }
      if (!this.disabled()) {
        this.util().addEvent(this.config.scrollContainer || window, 'scroll', this.scrollHandler);
        this.util().addEvent(window, 'resize', this.scrollHandler);
        this.interval = setInterval(this.scrollCallback, 50);
      }
      if (this.config.live) {
        return new MutationObserver((function(_this) {
          return function(records) {
            var k, len1, node, record, results;
            results = [];
            for (k = 0, len1 = records.length; k < len1; k++) {
              record = records[k];
              results.push((function() {
                var l, len2, ref1, results1;
                ref1 = record.addedNodes || [];
                results1 = [];
                for (l = 0, len2 = ref1.length; l < len2; l++) {
                  node = ref1[l];
                  results1.push(this.doSync(node));
                }
                return results1;
              }).call(_this));
            }
            return results;
          };
        })(this)).observe(document.body, {
          childList: true,
          subtree: true
        });
      }
    };

    WOW.prototype.stop = function() {
      this.stopped = true;
      this.util().removeEvent(this.config.scrollContainer || window, 'scroll', this.scrollHandler);
      this.util().removeEvent(window, 'resize', this.scrollHandler);
      if (this.interval != null) {
        return clearInterval(this.interval);
      }
    };

    WOW.prototype.sync = function(element) {
      if (MutationObserver.notSupported) {
        return this.doSync(this.element);
      }
    };

    WOW.prototype.doSync = function(element) {
      var box, j, len, ref, results;
      if (element == null) {
        element = this.element;
      }
      if (element.nodeType !== 1) {
        return;
      }
      element = element.parentNode || element;
      ref = element.querySelectorAll("." + this.config.boxClass);
      results = [];
      for (j = 0, len = ref.length; j < len; j++) {
        box = ref[j];
        if (indexOf.call(this.all, box) < 0) {
          this.boxes.push(box);
          this.all.push(box);
          if (this.stopped || this.disabled()) {
            this.resetStyle();
          } else {
            this.applyStyle(box, true);
          }
          results.push(this.scrolled = true);
        } else {
          results.push(void 0);
        }
      }
      return results;
    };

    WOW.prototype.show = function(box) {
      this.applyStyle(box);
      box.className = box.className + " " + this.config.animateClass;
      if (this.config.callback != null) {
        this.config.callback(box);
      }
      this.util().emitEvent(box, this.wowEvent);
      this.util().addEvent(box, 'animationend', this.resetAnimation);
      this.util().addEvent(box, 'oanimationend', this.resetAnimation);
      this.util().addEvent(box, 'webkitAnimationEnd', this.resetAnimation);
      this.util().addEvent(box, 'MSAnimationEnd', this.resetAnimation);
      return box;
    };

    WOW.prototype.applyStyle = function(box, hidden) {
      var delay, duration, iteration;
      duration = box.getAttribute('data-wow-duration');
      delay = box.getAttribute('data-wow-delay');
      iteration = box.getAttribute('data-wow-iteration');
      return this.animate((function(_this) {
        return function() {
          return _this.customStyle(box, hidden, duration, delay, iteration);
        };
      })(this));
    };

    WOW.prototype.animate = (function() {
      if ('requestAnimationFrame' in window) {
        return function(callback) {
          return window.requestAnimationFrame(callback);
        };
      } else {
        return function(callback) {
          return callback();
        };
      }
    })();

    WOW.prototype.resetStyle = function() {
      var box, j, len, ref, results;
      ref = this.boxes;
      results = [];
      for (j = 0, len = ref.length; j < len; j++) {
        box = ref[j];
        results.push(box.style.visibility = 'visible');
      }
      return results;
    };

    WOW.prototype.resetAnimation = function(event) {
      var target;
      if (event.type.toLowerCase().indexOf('animationend') >= 0) {
        target = event.target || event.srcElement;
        return target.className = target.className.replace(this.config.animateClass, '').trim();
      }
    };

    WOW.prototype.customStyle = function(box, hidden, duration, delay, iteration) {
      if (hidden) {
        this.cacheAnimationName(box);
      }
      box.style.visibility = hidden ? 'hidden' : 'visible';
      if (duration) {
        this.vendorSet(box.style, {
          animationDuration: duration
        });
      }
      if (delay) {
        this.vendorSet(box.style, {
          animationDelay: delay
        });
      }
      if (iteration) {
        this.vendorSet(box.style, {
          animationIterationCount: iteration
        });
      }
      this.vendorSet(box.style, {
        animationName: hidden ? 'none' : this.cachedAnimationName(box)
      });
      return box;
    };

    WOW.prototype.vendors = ["moz", "webkit"];

    WOW.prototype.vendorSet = function(elem, properties) {
      var name, results, value, vendor;
      results = [];
      for (name in properties) {
        value = properties[name];
        elem["" + name] = value;
        results.push((function() {
          var j, len, ref, results1;
          ref = this.vendors;
          results1 = [];
          for (j = 0, len = ref.length; j < len; j++) {
            vendor = ref[j];
            results1.push(elem["" + vendor + (name.charAt(0).toUpperCase()) + (name.substr(1))] = value);
          }
          return results1;
        }).call(this));
      }
      return results;
    };

    WOW.prototype.vendorCSS = function(elem, property) {
      var j, len, ref, result, style, vendor;
      style = getComputedStyle(elem);
      result = style.getPropertyCSSValue(property);
      ref = this.vendors;
      for (j = 0, len = ref.length; j < len; j++) {
        vendor = ref[j];
        result = result || style.getPropertyCSSValue("-" + vendor + "-" + property);
      }
      return result;
    };

    WOW.prototype.animationName = function(box) {
      var animationName, error;
      try {
        animationName = this.vendorCSS(box, 'animation-name').cssText;
      } catch (error) {
        animationName = getComputedStyle(box).getPropertyValue('animation-name');
      }
      if (animationName === 'none') {
        return '';
      } else {
        return animationName;
      }
    };

    WOW.prototype.cacheAnimationName = function(box) {
      return this.animationNameCache.set(box, this.animationName(box));
    };

    WOW.prototype.cachedAnimationName = function(box) {
      return this.animationNameCache.get(box);
    };

    WOW.prototype.scrollHandler = function() {
      return this.scrolled = true;
    };

    WOW.prototype.scrollCallback = function() {
      var box;
      if (this.scrolled) {
        this.scrolled = false;
        this.boxes = (function() {
          var j, len, ref, results;
          ref = this.boxes;
          results = [];
          for (j = 0, len = ref.length; j < len; j++) {
            box = ref[j];
            if (!(box)) {
              continue;
            }
            if (this.isVisible(box)) {
              this.show(box);
              continue;
            }
            results.push(box);
          }
          return results;
        }).call(this);
        if (!(this.boxes.length || this.config.live)) {
          return this.stop();
        }
      }
    };

    WOW.prototype.offsetTop = function(element) {
      var top;
      while (element.offsetTop === void 0) {
        element = element.parentNode;
      }
      top = element.offsetTop;
      while (element = element.offsetParent) {
        top += element.offsetTop;
      }
      return top;
    };

    WOW.prototype.isVisible = function(box) {
      var bottom, offset, top, viewBottom, viewTop;
      offset = box.getAttribute('data-wow-offset') || this.config.offset;
      viewTop = (this.config.scrollContainer && this.config.scrollContainer.scrollTop) || window.pageYOffset;
      viewBottom = viewTop + Math.min(this.element.clientHeight, this.util().innerHeight()) - offset;
      top = this.offsetTop(box);
      bottom = top + box.clientHeight;
      return top <= viewBottom && bottom >= viewTop;
    };

    WOW.prototype.util = function() {
      return this._util != null ? this._util : this._util = new Util();
    };

    WOW.prototype.disabled = function() {
      return !this.config.mobile && this.util().isMobile(navigator.userAgent);
    };

    return WOW;

  })();

}).call(this);


/***/ }),

/***/ 1:
/*!*****************************************!*\
  !*** multi ./Public/src/js/frontend.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\workspace\DuAdmin\Public\src\js\frontend.js */"./Public/src/js/frontend.js");


/***/ })

/******/ });