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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./public/src/js/affix-navbar.js":
/*!***************************************!*\
  !*** ./public/src/js/affix-navbar.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

+function ($) {
  $(window).on('load', function () {
    $('.nav-affix').affix({
      offset: {
        top: 50,
        bottom: function bottom() {
          return this.bottom = $('.footer').outerHeight(true);
        }
      }
    }).on('affixed.bs.affix', function () {
      if (!$(this).data('affix-one')) {
        $(this).removeClass('navbar-inverse').addClass('navbar-default');
      }
    }).on("affixed-top.bs.affix", function () {
      if (!$(this).data('affix-one')) {
        $(this).removeClass('navbar-default').addClass('navbar-inverse');
      }
    });
  });
}(jQuery);

/***/ }),

/***/ "./public/src/js/fix-col-height.js":
/*!*****************************************!*\
  !*** ./public/src/js/fix-col-height.js ***!
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

/***/ "./public/src/js/frontend.js":
/*!***********************************!*\
  !*** ./public/src/js/frontend.js ***!
  \***********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _affix_navbar__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./affix-navbar */ "./public/src/js/affix-navbar.js");
/* harmony import */ var _affix_navbar__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_affix_navbar__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _fix_col_height__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./fix-col-height */ "./public/src/js/fix-col-height.js");
/* harmony import */ var _fix_col_height__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_fix_col_height__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _video_background__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./video-background */ "./public/src/js/video-background.js");
/* harmony import */ var _video_background__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_video_background__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _load_more__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./load-more */ "./public/src/js/load-more.js");
/* harmony import */ var _load_more__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_load_more__WEBPACK_IMPORTED_MODULE_3__);





/***/ }),

/***/ "./public/src/js/load-more.js":
/*!************************************!*\
  !*** ./public/src/js/load-more.js ***!
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

/***/ "./public/src/js/video-background.js":
/*!*******************************************!*\
  !*** ./public/src/js/video-background.js ***!
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

/***/ 3:
/*!*****************************************!*\
  !*** multi ./public/src/js/frontend.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\workspace\DuAdmin\public\src\js\frontend.js */"./public/src/js/frontend.js");


/***/ })

/******/ });