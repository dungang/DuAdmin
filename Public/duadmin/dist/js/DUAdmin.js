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

/***/ "./node_modules/adminlte/dist/js/adminlte.min.js":
/*!*******************************************************!*\
  !*** ./node_modules/adminlte/dist/js/adminlte.min.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*! AdminLTE app.js
* ================
* Main JS application file for AdminLTE v2. This file
* should be included in all pages. It controls some layout
* options and implements exclusive AdminLTE plugins.
*
* @Author  Almsaeed Studio
* @Support <https://www.almsaeedstudio.com>
* @Email   <abdullah@almsaeedstudio.com>
* @version 2.4.0
* @repository git://github.com/Social-chan/AdminLTE.git
* @license MIT <http://opensource.org/licenses/MIT>
*/
if("undefined"==typeof jQuery)throw new Error("AdminLTE requires jQuery");+function(a){"use strict";function b(b){return this.each(function(){var e=a(this),f=e.data(c);if(!f){var g=a.extend({},d,e.data(),"object"==typeof b&&b);e.data(c,f=new h(e,g))}if("string"==typeof b){if(void 0===f[b])throw new Error("No method named "+b);f[b]()}})}var c="lte.boxwidget",d={animationSpeed:500,collapseTrigger:'[data-widget="collapse"]',removeTrigger:'[data-widget="remove"]',collapseIcon:"fa-minus",expandIcon:"fa-plus",removeIcon:"fa-times"},e={data:".box",collapsed:".collapsed-box",body:".box-body",footer:".box-footer",tools:".box-tools"},f={collapsed:"collapsed-box"},g={collapsed:"collapsed.boxwidget",expanded:"expanded.boxwidget",removed:"removed.boxwidget"},h=function(a,b){this.element=a,this.options=b,this._setUpListeners()};h.prototype.toggle=function(){a(this.element).is(e.collapsed)?this.expand():this.collapse()},h.prototype.expand=function(){var b=a.Event(g.expanded),c=this.options.collapseIcon,d=this.options.expandIcon;a(this.element).removeClass(f.collapsed),a(this.element).find(e.tools).find("."+d).removeClass(d).addClass(c),a(this.element).find(e.body+", "+e.footer).slideDown(this.options.animationSpeed,function(){a(this.element).trigger(b)}.bind(this))},h.prototype.collapse=function(){var b=a.Event(g.collapsed),c=this.options.collapseIcon,d=this.options.expandIcon;a(this.element).find(e.tools).find("."+c).removeClass(c).addClass(d),a(this.element).find(e.body+", "+e.footer).slideUp(this.options.animationSpeed,function(){a(this.element).addClass(f.collapsed),a(this.element).trigger(b)}.bind(this))},h.prototype.remove=function(){var b=a.Event(g.removed);a(this.element).slideUp(this.options.animationSpeed,function(){a(this.element).trigger(b),a(this.element).remove()}.bind(this))},h.prototype._setUpListeners=function(){var b=this;a(this.element).on("click",this.options.collapseTrigger,function(a){a&&a.preventDefault(),b.toggle()}),a(this.element).on("click",this.options.removeTrigger,function(a){a&&a.preventDefault(),b.remove()})};var i=a.fn.boxWidget;a.fn.boxWidget=b,a.fn.boxWidget.Constructor=h,a.fn.boxWidget.noConflict=function(){return a.fn.boxWidget=i,this},a(window).on("load",function(){a(e.data).each(function(){b.call(a(this))})})}(jQuery),function(a){"use strict";function b(b){return this.each(function(){var e=a(this),f=e.data(c);if(!f){var g=a.extend({},d,e.data(),"object"==typeof b&&b);e.data(c,f=new h(e,g))}"string"==typeof b&&f.toggle()})}var c="lte.controlsidebar",d={slide:!0},e={sidebar:".control-sidebar",data:'[data-toggle="control-sidebar"]',open:".control-sidebar-open",bg:".control-sidebar-bg",wrapper:".wrapper",content:".content-wrapper",boxed:".layout-boxed"},f={open:"control-sidebar-open",fixed:"fixed"},g={collapsed:"collapsed.controlsidebar",expanded:"expanded.controlsidebar"},h=function(a,b){this.element=a,this.options=b,this.hasBindedResize=!1,this.init()};h.prototype.init=function(){a(this.element).is(e.data)||a(this).on("click",this.toggle),this.fix(),a(window).resize(function(){this.fix()}.bind(this))},h.prototype.toggle=function(b){b&&b.preventDefault(),this.fix(),a(e.sidebar).is(e.open)||a("body").is(e.open)?this.collapse():this.expand()},h.prototype.expand=function(){this.options.slide?a(e.sidebar).addClass(f.open):a("body").addClass(f.open),a(this.element).trigger(a.Event(g.expanded))},h.prototype.collapse=function(){a("body, "+e.sidebar).removeClass(f.open),a(this.element).trigger(a.Event(g.collapsed))},h.prototype.fix=function(){a("body").is(e.boxed)&&this._fixForBoxed(a(e.bg))},h.prototype._fixForBoxed=function(b){b.css({position:"absolute",height:a(e.wrapper).height()})};var i=a.fn.controlSidebar;a.fn.controlSidebar=b,a.fn.controlSidebar.Constructor=h,a.fn.controlSidebar.noConflict=function(){return a.fn.controlSidebar=i,this},a(document).on("click",e.data,function(c){c&&c.preventDefault(),b.call(a(this),"toggle")})}(jQuery),function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data(c);e||d.data(c,e=new f(d)),"string"==typeof b&&e.toggle(d)})}var c="lte.directchat",d={data:'[data-widget="chat-pane-toggle"]',box:".direct-chat"},e={open:"direct-chat-contacts-open"},f=function(a){this.element=a};f.prototype.toggle=function(a){a.parents(d.box).first().toggleClass(e.open)};var g=a.fn.directChat;a.fn.directChat=b,a.fn.directChat.Constructor=f,a.fn.directChat.noConflict=function(){return a.fn.directChat=g,this},a(document).on("click",d.data,function(c){c&&c.preventDefault(),b.call(a(this),"toggle")})}(jQuery),function(a){"use strict";function b(b){return this.each(function(){var e=a(this),f=e.data(c);if(!f){var h=a.extend({},d,e.data(),"object"==typeof b&&b);e.data(c,f=new g(h))}if("string"==typeof b){if(void 0===f[b])throw new Error("No method named "+b);f[b]()}})}var c="lte.layout",d={slimscroll:!0,resetHeight:!0},e={wrapper:".wrapper",contentWrapper:".content-wrapper",layoutBoxed:".layout-boxed",mainFooter:".main-footer",mainHeader:".main-header",sidebar:".sidebar",controlSidebar:".control-sidebar",fixed:".fixed",sidebarMenu:".sidebar-menu",logo:".main-header .logo"},f={fixed:"fixed",holdTransition:"hold-transition"},g=function(a){this.options=a,this.bindedResize=!1,this.activate()};g.prototype.activate=function(){this.fix(),this.fixSidebar(),a("body").removeClass(f.holdTransition),this.options.resetHeight&&a("body, html, "+e.wrapper).css({height:"auto","min-height":"100%"}),this.bindedResize||(a(window).resize(function(){this.fix(),this.fixSidebar(),a(e.logo+", "+e.sidebar).one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",function(){this.fix(),this.fixSidebar()}.bind(this))}.bind(this)),this.bindedResize=!0),a(e.sidebarMenu).on("expanded.tree",function(){this.fix(),this.fixSidebar()}.bind(this)),a(e.sidebarMenu).on("collapsed.tree",function(){this.fix(),this.fixSidebar()}.bind(this))},g.prototype.fix=function(){a(e.layoutBoxed+" > "+e.wrapper).css("overflow","hidden");var b=a(e.mainFooter).outerHeight()||0,c=a(e.mainHeader).outerHeight()+b,d=a(window).height(),g=a(e.sidebar).height()||0;if(a("body").hasClass(f.fixed))a(e.contentWrapper).css("min-height",d-b);else{var h;d>=g?(a(e.contentWrapper).css("min-height",d-c),h=d-c):(a(e.contentWrapper).css("min-height",g),h=g);var i=a(e.controlSidebar);void 0!==i&&i.height()>h&&a(e.contentWrapper).css("min-height",i.height())}},g.prototype.fixSidebar=function(){if(!a("body").hasClass(f.fixed))return void(void 0!==a.fn.slimScroll&&a(e.sidebar).slimScroll({destroy:!0}).height("auto"));this.options.slimscroll&&void 0!==a.fn.slimScroll&&(a(e.sidebar).slimScroll({destroy:!0}).height("auto"),a(e.sidebar).slimScroll({height:a(window).height()-a(e.mainHeader).height()+"px",color:"rgba(0,0,0,0.2)",size:"3px"}))};var h=a.fn.layout;a.fn.layout=b,a.fn.layout.Constuctor=g,a.fn.layout.noConflict=function(){return a.fn.layout=h,this},a(window).on("load",function(){b.call(a("body"))})}(jQuery),function(a){"use strict";function b(b){return this.each(function(){var e=a(this),f=e.data(c);if(!f){var g=a.extend({},d,e.data(),"object"==typeof b&&b);e.data(c,f=new h(g))}"toggle"==b&&f.toggle()})}var c="lte.pushmenu",d={collapseScreenSize:767,expandOnHover:!1,expandTransitionDelay:200},e={collapsed:".sidebar-collapse",open:".sidebar-open",mainSidebar:".main-sidebar",contentWrapper:".content-wrapper",searchInput:".sidebar-form .form-control",button:'[data-toggle="push-menu"]',mini:".sidebar-mini",expanded:".sidebar-expanded-on-hover",layoutFixed:".fixed"},f={collapsed:"sidebar-collapse",open:"sidebar-open",mini:"sidebar-mini",expanded:"sidebar-expanded-on-hover",expandFeature:"sidebar-mini-expand-feature",layoutFixed:"fixed"},g={expanded:"expanded.pushMenu",collapsed:"collapsed.pushMenu"},h=function(a){this.options=a,this.init()};h.prototype.init=function(){(this.options.expandOnHover||a("body").is(e.mini+e.layoutFixed))&&(this.expandOnHover(),a("body").addClass(f.expandFeature)),a(e.contentWrapper).click(function(){a(window).width()<=this.options.collapseScreenSize&&a("body").hasClass(f.open)&&this.close()}.bind(this)),a(e.searchInput).click(function(a){a.stopPropagation()})},h.prototype.toggle=function(){var b=a(window).width(),c=!a("body").hasClass(f.collapsed);b<=this.options.collapseScreenSize&&(c=a("body").hasClass(f.open)),c?this.close():this.open()},h.prototype.open=function(){a(window).width()>this.options.collapseScreenSize?a("body").removeClass(f.collapsed).trigger(a.Event(g.expanded)):a("body").addClass(f.open).trigger(a.Event(g.expanded))},h.prototype.close=function(){a(window).width()>this.options.collapseScreenSize?a("body").addClass(f.collapsed).trigger(a.Event(g.collapsed)):a("body").removeClass(f.open+" "+f.collapsed).trigger(a.Event(g.collapsed))},h.prototype.expandOnHover=function(){a(e.mainSidebar).hover(function(){a("body").is(e.mini+e.collapsed)&&a(window).width()>this.options.collapseScreenSize&&this.expand()}.bind(this),function(){a("body").is(e.expanded)&&this.collapse()}.bind(this))},h.prototype.expand=function(){setTimeout(function(){a("body").removeClass(f.collapsed).addClass(f.expanded)},this.options.expandTransitionDelay)},h.prototype.collapse=function(){setTimeout(function(){a("body").removeClass(f.expanded).addClass(f.collapsed)},this.options.expandTransitionDelay)};var i=a.fn.pushMenu;a.fn.pushMenu=b,a.fn.pushMenu.Constructor=h,a.fn.pushMenu.noConflict=function(){return a.fn.pushMenu=i,this},a(document).on("click",e.button,function(c){c.preventDefault(),b.call(a(this),"toggle")}),a(window).on("load",function(){b.call(a(e.button))})}(jQuery),function(a){"use strict";function b(b){return this.each(function(){var e=a(this);if(!e.data(c)){var f=a.extend({},d,e.data(),"object"==typeof b&&b);e.data(c,new h(e,f))}})}var c="lte.tree",d={animationSpeed:500,accordion:!0,followLink:!1,trigger:".treeview a"},e={tree:".tree",treeview:".treeview",treeviewMenu:".treeview-menu",open:".menu-open, .active",li:"li",data:'[data-widget="tree"]',active:".active"},f={open:"menu-open",tree:"tree"},g={collapsed:"collapsed.tree",expanded:"expanded.tree"},h=function(b,c){this.element=b,this.options=c,a(this.element).addClass(f.tree),a(e.treeview+e.active,this.element).addClass(f.open),this._setUpListeners()};h.prototype.toggle=function(a,b){var c=a.next(e.treeviewMenu),d=a.parent(),g=d.hasClass(f.open);d.is(e.treeview)&&(this.options.followLink&&"#"!=a.attr("href")||b.preventDefault(),g?this.collapse(c,d):this.expand(c,d))},h.prototype.expand=function(b,c){var d=a.Event(g.expanded);if(this.options.accordion){var h=c.siblings(e.open),i=h.children(e.treeviewMenu);this.collapse(i,h)}c.addClass(f.open),b.slideDown(this.options.animationSpeed,function(){a(this.element).trigger(d)}.bind(this))},h.prototype.collapse=function(b,c){var d=a.Event(g.collapsed);b.find(e.open).removeClass(f.open),c.removeClass(f.open),b.slideUp(this.options.animationSpeed,function(){b.find(e.open+" > "+e.treeview).slideUp(),a(this.element).trigger(d)}.bind(this))},h.prototype._setUpListeners=function(){var b=this;a(this.element).on("click",this.options.trigger,function(c){b.toggle(a(this),c)})};var i=a.fn.tree;a.fn.tree=b,a.fn.tree.Constructor=h,a.fn.tree.noConflict=function(){return a.fn.tree=i,this},a(window).on("load",function(){a(e.data).each(function(){b.call(a(this))})})}(jQuery);

/***/ }),

/***/ "./public/duadmin/src/js/DUAdmin.js":
/*!******************************************!*\
  !*** ./public/duadmin/src/js/DUAdmin.js ***!
  \******************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var adminlte__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! adminlte */ "./node_modules/adminlte/dist/js/adminlte.min.js");
/* harmony import */ var adminlte__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(adminlte__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _extend__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./extend */ "./public/duadmin/src/js/extend.js");
/* harmony import */ var _extend__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_extend__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _ajax_upload__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ajax-upload */ "./public/duadmin/src/js/ajax-upload.js");
/* harmony import */ var _ajax_upload__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_ajax_upload__WEBPACK_IMPORTED_MODULE_2__);




/***/ }),

/***/ "./public/duadmin/src/js/ajax-upload.js":
/*!**********************************************!*\
  !*** ./public/duadmin/src/js/ajax-upload.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

+function ($) {
  'use strict';

  function isImage(type) {
    return type.substr(0, 5) == 'image';
  }

  function getExtension(fileName) {
    var index = fileName.lastIndexOf(".");
    return fileName.substr(index + 1);
  }

  var dismiss = '[data-dismiss="duajaxupload"]';
  var ok = '[data-upload="duajaxupload"]';
  var toggleElm = '[data-toggle="duajaxupload"]';

  var DuAjaxUpload = function DuAjaxUpload(el, options, toggleButton) {
    var that = this;
    this.options = options;
    this.$element = $(el);
    this.formData = new FormData();
    this.$fileInput = this.$element.find('input[type="file"]');
    this.$textInput = this.$element.find('input[type="text"]');
    this.$previewImage = this.$element.find('.image-preview img');
    this.$realUploadBtn = toggleButton ? toggleButton : this.$element.find(toggleElm);

    var closeCallback = function closeCallback() {
      that.close();
    };

    this.$element.on('click', dismiss, closeCallback);

    var changeCallback = function changeCallback(e) {
      that.file = e.currentTarget.files[0];
      that.extension = getExtension(that.file.name); //是图片如不设置了裁剪的高和宽度，则显示裁剪工具框，否则直接上传

      if (isImage(that.file.type)) {
        that.$dialog = that.$element.find('.cropper-dialog');
        that.$imageBox = that.$element.find('.cropper-image-box');
        that.$area = that.$dialog.find('.cropper-area');
        that.showCropper();
        that.$dialog.show();
      } else {
        that.formData.set("file", that.file);
        that.uploadFile();
      }
    };

    this.$fileInput.on('change', changeCallback);

    var okCallback = function okCallback(e) {
      that.$realUploadBtn = $(this);

      if (that.$cropper) {
        var targetImage = that.$cropper.cropper('getCroppedCanvas'); //如果配置了压缩图片

        if (that.options.compress) {
          targetImage = that.compress(targetImage);
        }

        targetImage.toBlob(function (blob) {
          that.formData.set('file', blob, that.file.name);
          that.uploadFile();
        });
      } else {
        that.formData.set('file', that.file);
        that.uploadFile();
      }

      that.close();
    };

    this.$element.on('click', ok, okCallback);
  };

  DuAjaxUpload.DEFAULTS = {
    clip: true,
    //是否裁剪
    imageHeight: 300,
    //目标图标高度，如不compress=true 表示像素，否则表示高度占比单位大小
    imageWidth: 300,
    //目标图片宽度，如不compress=true 表示像素，否则表示宽度度占比单位大小
    compress: true //是否压缩

  };

  DuAjaxUpload.prototype.compress = function (img) {
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d'); // 设置宽高度为等同于要压缩图片的尺寸

    canvas.width = this.options.imageWidth;
    canvas.height = this.options.imageHeight;
    context.clearRect(0, 0, canvas.width, canvas.height); //将img绘制到画布上

    context.drawImage(img, 0, 0, canvas.width, canvas.height);
    return canvas;
  };

  DuAjaxUpload.prototype.uploadFile = function () {
    var that = this;

    if (that.$realUploadBtn) {
      $(that.$realUploadBtn).button('上传中...');
      console.log($(that.$realUploadBtn));
      console.log('uploading ...');
    }

    var fileType = this.$textInput.attr('data-type');
    var tokenUrl = this.$textInput.attr('data-token-url');
    $.get(tokenUrl, {
      fileType: fileType
    }, function (data) {
      var key = data.key + "." + that.extension;
      that.formData.set(DUA.uploader.keyName, key);
      that.formData.set(DUA.uploader.tokenName, data.token);
      $.ajax({
        url: DUA.uploader.uploadUrl,
        dataType: 'json',
        type: 'POST',
        async: false,
        data: that.formData,
        processData: false,
        // 使数据不做处理
        contentType: false,
        // 不要设置Content-Type请求头
        success: function success(data) {
          console.log(data);
          alert('上传成功！');
          var imgUrl = DUA.uploader.baseUrl + key;
          that.$textInput.val(imgUrl);
          that.$fileInput.val("");
          that.$previewImage.attr('src', imgUrl);

          if (that.$realUploadBtn) {
            console.log('reset');
            that.$realUploadBtn.button('reset');
          }
        },
        error: function error(jqXHR) {
          console.log(jqXHR);
          alert(jqXHR.responseJSON.message);

          if (that.$realUploadBtn) {
            that.$realUploadBtn.button('reset');
          }
        }
      });
    });
  };

  DuAjaxUpload.prototype.showCropper = function () {
    var that = this;
    var reader = new FileReader();
    reader.addEventListener('load', function () {
      that.img = new Image();
      that.img.src = this.result;
      that.$imageBox.html(that.img);

      if (that.options.clip) {
        var rate = (that.options.imageWidth / that.options.imageHeight).toFixed(2);
        that.$cropper = $(that.img).cropper({
          aspectRatio: rate
        });
      }
    });
    reader.readAsDataURL(this.file);
  };

  DuAjaxUpload.prototype.selectFile = function () {
    this.$fileInput.trigger('click');
  };

  DuAjaxUpload.prototype.close = function () {
    if (this.$dialog) {
      this.$fileInput.val("");
      this.$dialog.hide();
    }
  };

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this);
      var data = $this.data('bs.duAjaxUpload');

      if (!data) {
        var options = $.extend({}, DuAjaxUpload.DEFAULTS, $this.data(), _typeof(option) == 'object' && option);
        $this.data('bs.duAjaxUpload', data = new DuAjaxUpload(this, options));
      }

      if (typeof option == 'string') data[option].call(data);
    });
  }

  var old = $.fn.duAjaxUpload;
  $.fn.duAjaxUpload = Plugin;
  $.fn.duAjaxUpload.Constructor = DuAjaxUpload; // NO CONFLICT
  // =================

  $.fn.duAjaxUpload.noConflict = function () {
    $.fn.duAjaxUpload = old;
    return this;
  }; // DATA-API
  // ==============


  var clickHandler = function clickHandler(e) {
    e.preventDefault();
    var parent = $(this).parents('[data-role="duajaxupload"]');
    Plugin.call(parent, 'selectFile', $(this));
  };

  $(document).on('click.bs.duajaxupload.data-api', toggleElm, clickHandler);
}(jQuery);

/***/ }),

/***/ "./public/duadmin/src/js/extend.js":
/*!*****************************************!*\
  !*** ./public/duadmin/src/js/extend.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * 联动选择下拉框 data-parent-id //默认上级值 data-parent //上级对象，和 parent-id二选一 data-url
 * //加载数据的地址 data-param //加载数据的参数 data-value //默认初始值，并不代表事最终逻辑值 data-queue
 * //顺序执行的对象队列
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
};

+function ($) {
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
      var txt = data[p];

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
    $self.empty(); // 情况自己

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
        if (res.code == 0) {
          $self.append(assembleOptions(res.data, data.value));
          process(queue);
        }
      });
    }
  }

  function getQueue() {
    return $('select[data-linkage]').toArray();
  }

  function execute() {
    var queue = getQueue();
    process(queue);
  }

  $.fn.linkageSelect = function () {
    $(document).off('change.site.linkage');
    execute();
    $(document).on('change.site.linkage', 'select[data-linkage]', function () {
      var queue = $($(this).data('queue')).toArray();
      process(queue);
    });
  };
}(jQuery);
+function ($) {
  function process(options) {
    var _this = this;

    options.data['timestamp'] = Math.round(new Date().getTime() / 1000);
    $.ajax({
      url: options.url,
      method: options.method,
      data: options.data,
      dataType: options.dataType,
      error: function error(xhr, textStatus, errorThrown) {
        options.onTimeout.call(_this, options, xhr, textStatus, errorThrown);

        if (options.repeat) {
          setTimeout(function () {
            process.call(_this, options);
          }, options.interval);
        }
      },
      success: function success(data, textStatus) {
        if (textStatus == "success") {
          // 请求成功
          options.onSuccess.call(_this, data, textStatus, options);

          if (options.repeat) {
            var tm = setTimeout(function () {
              process.call(_this, options);
              clearTimeout(tm);
            }, options.interval);
          }
        }
      }
    });
  }

  $.fn.longpoll = function (options) {
    return this.each(function () {
      var _this = $(this);

      var opts = $.extend({}, $.fn.longpoll.Default, options, _this.data());

      if (opts.now === true) {
        process.call(_this, opts);
      } else {
        var tm = setTimeout(function () {
          process.call(_this, opts);
          clearTimeout(tm);
        }, options.interval);
      }
    });
  };

  $.fn.longpoll.Default = {
    now: true,
    //是否立刻执行
    interval: 2000,
    dataType: 'text',
    method: 'get',
    data: {},
    repeat: true,
    onTimeout: $.noop,
    onSuccess: $.noop
  };
}(jQuery);
+function ($) {
  $.fn.batchLoad = function (options) {
    return this.each(function () {
      var _this = $(this);

      var opts = $.extend({}, $.fn.batchLoad.Default, options, _this.data());

      var url = _this.attr('href');

      var hasQuery = url.indexOf('?') > -1;

      _this.click(function (e) {
        e.preventDefault();
        var idObjs = $('input[name=' + opts.key + '\\[\\]]:checked').map(function (idx, obj) {
          return obj.value;
        });

        if (idObjs.length == 0) {
          alert("请选择加载的条目，否则不能进行操作");
        } else {
          var ids = $.makeArray(idObjs);

          if (hasQuery) {
            url += '&id=' + ids.join();
          } else {
            url += '?id' + ids.join();
          }

          $.get(url, function (response) {
            var modal = $(opts.modal);
            modal.find('.modal-content').html(response);
            modal.modal('show');
          });
        }
      });
    });
  };

  $.fn.batchLoad.Default = {
    key: 'id',
    modal: '#modal-dialog'
  };
}(jQuery);
+function ($) {
  /**
   * Create or Delete a Row of List
   */
  $.fn.listrowcd = function (options) {
    return this.each(function () {
      var _this = $(this);

      var opts = $.extend({}, $.fn.listrowcd.Default, options, _this.data()); // delete button

      _this.find(opts.delBtn).click(function (e) {
        e.preventDefault();

        var _delBtn = $(this);

        var _row = _delBtn.parents(opts.row);

        _row.fadeToggle('slow', function () {
          _row.remove();
        });
      });

      _this.find(opts.createBtn).click(function (e) {
        e.preventDefault();

        var _createBtn = $(this);

        var _rows = _this.find(opts.row);

        var _lastRow = $(_rows[_rows.length - 1]);

        _lastRow.clone(true).insertAfter(_lastRow);
      });
    });
  };

  $.fn.listrowcd.Default = {
    delBtn: '.btn-del',
    createBtn: '.btn-create',
    row: 'tr'
  };
}(jQuery);
+function ($) {
  function replaceIndex(clone) {
    var regexID = /\-\d{1,}\-/gmi;
    var regexName = /\[\d{1,}\]/gmi;
    var size = this.data('index');
    var html = clone.html().replace(regexName, '[' + size + ']').replace(regexID, '-' + size + '-');
    size = size + 1;
    this.data('index', size);
    clone.html(html);
    return clone;
  }

  $.fn.dynamicline = function (options) {
    return this.each(function () {
      var _container = $(this);

      var opts = $.extend({}, $.fn.dynamicline.DEF, options, _container.data());

      _container.on('click', '.delete-self', function (e) {
        e.preventDefault();

        var _this = $(this);

        var target_obj = _this.parents(opts.target);

        var targets = _container.find(opts.target);

        if (targets.length > 2) {
          target_obj.remove();
        }
      }).on('click', '.copy-self', function (e) {
        e.preventDefault();

        var _this = $(this);

        var target_obj = _this.parents(opts.target);

        var clone = target_obj.clone();
        console.log(clone);

        if (opts.onCopy) {
          clone = opts.onCopy.call(_container, clone);
        }

        clone.insertAfter(target_obj);
      });
    });
  };

  $.fn.dynamicline.DEF = {
    onCopy: replaceIndex
  };
}(jQuery);
+function ($) {
  'use strict';

  $.fn.sizeList = function () {
    return this.each(function () {
      var _this = $(this);

      var hiddenInput = _this.find('input[type=hidden]');

      var checkboxList = _this.find('input[type=checkbox]');

      checkboxList.change(function () {
        var items = [];

        for (var i = 0; i < checkboxList.length; i++) {
          if (checkboxList[i].checked) {
            items.push(checkboxList[i].value);
          }
        }

        hiddenInput.val(items.join(','));
      });
    });
  };
}(jQuery);
/**
 * Created by dungang
 */

+function ($) {
  'use strict';

  $.fn.selectBox = function () {
    return this.each(function () {
      var _this = $(this);

      var id = _this.attr('id');

      var sourceSearchInput = $('#' + id + '-source-search');
      var targetSearchInput = $('#' + id + '-target-search');
      var sourceSelect = $('#' + id + '-source');
      var targetSelect = $('#' + id + '-target');
      var yesButton = $('#' + id + '-btn-yes');
      var noButton = $('#' + id + '-btn-no');
      targetSelect.on('update', function () {
        targetSelect.find('option').attr('selected', true);
      });
      sourceSearchInput.keyup(function () {
        var filter = sourceSearchInput.val().trim();
        sourceSelect.find('option').each(function () {
          var _option = $(this);

          if (_option.text().indexOf(filter) < 0) {
            _option.attr('selected', false).css({
              display: 'none'
            });
          } else {
            _option.css({
              display: 'block'
            });
          }
        });
      });
      targetSearchInput.keyup(function () {
        var filter = targetSearchInput.val().trim();
        targetSelect.find('option').each(function () {
          var _option = $(this);

          if (_option.text().indexOf(filter) < 0) {
            _option.attr('selected', false).css({
              display: 'none'
            });
          } else {
            _option.css({
              display: 'block'
            });
          }
        });
        targetSelect.trigger('update');
      });
      yesButton.click(function () {
        sourceSelect.find('option:selected').appendTo(targetSelect);
        targetSelect.trigger('update');
      });
      noButton.click(function () {
        targetSelect.find('option:selected').appendTo(sourceSelect);
      });
      targetSelect.trigger('update');
    });
  };
}(jQuery);
/**
 * yiigridview的批量编辑，在按钮上添加.batch-update样式，
 * 该事件会更新按钮的url
 */

$(document).on('click', '.batch-update', function (e) {
  e.preventDefault();
  var that = $(this);
  var data = that.data();
  var gridView = $(data.target);
  var gridViewData = gridView.yiiGridView('data');
  var field = escape(gridViewData.selectionColumn);
  var ids = gridView.yiiGridView("getSelectedRows").map(function (id) {
    return field + '=' + escape(id);
  });

  if (ids.length == 0) {
    alert('请选择条目，否则不能进行操作');
  } else {
    var reg = new RegExp('&?' + field + '=[\/a-zA-Z0-9]+', 'g');
    var baseUrl = that.data('url').replace(reg, '');
    baseUrl = baseUrl + '&' + ids.join('&');
    console.log(baseUrl);
    that.attr('href', baseUrl);
    $('#modal-dialog').modal({
      remote: baseUrl
    });
  }
});
/**
 * 需要在data属性配置 gridview的id
 * data-target="#gridviewId"
 */

$(document).on('click', '.del-all', function (e) {
  e.preventDefault();
  var that = $(this);
  var data = that.data();
  var ids = $(data.target).yiiGridView("getSelectedRows");

  if (ids.length == 0) {
    alert('请选择条目，否则不能进行操作');
  } else {
    var params = {};

    if (!data.pk) {
      data.pk = 'id';
    }

    params[data.pk] = ids;

    if (confirm('确认删除么？')) {
      $.ajax({
        method: "POST",
        url: that.attr('href'),
        data: params,
        success: function success(msg) {
          window.location.reload();
        }
      });
    }
  }
});
$(document).on('submit', '.enable-ajax-form form', function (event) {
  event.preventDefault();
  var aform = $(event.target);
  var pjaxContainer = aform.parents('[data-pjax-container]');
  aform.ajaxSubmit({
    headers: {
      'AJAX-SUBMIT': 'AJAX-SUBMIT'
    },
    success: function success(data) {
      var type = "error";

      if (data.status == 'success') {
        if (pjaxContainer) {
          var pjaxId = pjaxContainer.attr('id');
          $.pjax.reload('#' + pjaxId);
        }

        type = "success";
      }

      notif({
        type: type,
        msg: data.message,
        position: 'center',
        timeout: 3000
      });
    }
  });
});
$(document).on('click', '[data-sync]', function (event) {
  event.preventDefault();
  var targetBtn = $(this);
  $.post(targetBtn.attr('href'), function (data) {
    if (data.status == 'success') {
      var pjaxContainer = targetBtn.parents('[data-pjax-container]');

      if (pjaxContainer) {
        var pjaxId = pjaxContainer.attr('id');

        if (pjaxId != undefined) {
          $.pjax.reload('#' + pjaxId);
        }
      }
    }
  });
});

/***/ }),

/***/ 1:
/*!************************************************!*\
  !*** multi ./public/duadmin/src/js/DUAdmin.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\workspace\DuAdmin\public\duadmin\src\js\DUAdmin.js */"./public/duadmin/src/js/DUAdmin.js");


/***/ })

/******/ });