!function(t){var e={};function n(o){if(e[o])return e[o].exports;var i=e[o]={i:o,l:!1,exports:{}};return t[o].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=t,n.c=e,n.d=function(t,e,o){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:o})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var i in t)n.d(o,i,function(e){return t[e]}.bind(null,i));return o},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/",n(n.s=338)}({191:function(t,e){function n(t){if("undefined"==typeof Symbol||null==t[Symbol.iterator]){if(Array.isArray(t)||(t=function(t,e){if(!t)return;if("string"==typeof t)return o(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);"Object"===n&&t.constructor&&(n=t.constructor.name);if("Map"===n||"Set"===n)return Array.from(n);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return o(t,e)}(t))){var e=0,n=function(){};return{s:n,n:function(){return e>=t.length?{done:!0}:{done:!1,value:t[e++]}},e:function(t){throw t},f:n}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,r,a=!0,s=!1;return{s:function(){i=t[Symbol.iterator]()},n:function(){var t=i.next();return a=t.done,t},e:function(t){s=!0,r=t},f:function(){try{a||null==i.return||i.return()}finally{if(s)throw r}}}}function o(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,o=new Array(e);n<e;n++)o[n]=t[n];return o}Date.prototype.format=function(t){var e={"M+":this.getMonth()+1,"d+":this.getDate(),"h+":this.getHours(),"m+":this.getMinutes(),"s+":this.getSeconds(),"q+":Math.floor((this.getMonth()+3)/3),S:this.getMilliseconds()};for(var n in/(y+)/.test(t)&&(t=t.replace(RegExp.$1,(this.getFullYear()+"").substr(4-RegExp.$1.length))),e)new RegExp("("+n+")").test(t)&&(t=t.replace(RegExp.$1,1==RegExp.$1.length?e[n]:("00"+e[n]).substr((""+e[n]).length)));return t},Array.prototype.distinct=function(){var t,e=[],o=n(this);try{for(o.s();!(t=o.n()).done;){var i=t.value;-1==e.indexOf(i)&&e.push(i)}}catch(t){o.e(t)}finally{o.f()}return e}},192:function(t,e){!function(t){var e=null;t(document).on("ajaxStart",(function(){e||(e=layer.load(0,{shade:[.1,"#000"]}))})),t(document).on("ajaxComplete",(function(){e&&(layer.close(e),e=null)}))}(jQuery)},193:function(t,e){function n(t){return(n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}!function(t){var e=function(e,n){this.options=n,this.$modal=t(e),this.$pjaxContainer=null,this.$pjaxId=null,this.handleHidden(),this.handleShow(),this.handleSubmit()};e.prototype.handleHidden=function(){var t=this;this.$modal.on("hidden.bs.modal",(function(e){t.$modal.data("bs.modal",null),t.$modal.find(".modal-body").empty(),t.$modal.find("script").remove(),t.$modal.find("link").remove(),t.$pjaxContainer=null,t.pjaxId=null}))},e.prototype.handleShow=function(){var e=this;this.$modal.on("show.bs.modal",(function(n){var o=t(n.relatedTarget);if("modal"==o.attr("data-toggle")){e.pjaxId=o.data("pjax-target"),e.pjaxId?e.$pjaxContainer=t("#"+e.pjaxId):(e.$pjaxContainer=o.parents("[data-pjax-container]"),e.pjaxId=e.$pjaxContainer.attr("id")),e.options.debug&&(console.log("simple modal debug: pjax container"),console.log(e.$pjaxContainer));var i=o.data("modal-size");t(n.target).find(".modal-dialog").removeClass("modal-sm modal-lg").addClass(i||"")}}))},e.prototype.showMsg=function(t,e){layer.msg(t,{skin:"layui-layer-molv",icon:e,time:this.options.timeout})},e.prototype.handleSubmit=function(){var e=this;this.$modal.on("submit","form",(function(n){n.preventDefault(),t(n.target).ajaxSubmit({headers:{"AJAX-SUBMIT":"AJAX-SUBMIT"},success:function(t){var n="error";"success"==t.status&&("function"==typeof e.options.customHandleResult?e.options.customHandleResult.call(e,t):e.$pjaxContainer&&e.$pjaxContainer.length>0?e.handleResult(t):window.location.reload(),e.$modal.modal("hide"),n="success"),e.options.debug&&(console.log("simple modal debug: notify"),console.log(n),console.log(t)),e.showMsg(t.message,"success"==n?1:2)},error:function(t,n,o){e.showMsg(t.responseJSON.message,2)}})}))},e.prototype.handleResult=function(e){if(this.options.debug){var n=this.$pjaxContainer.attr("id");console.log("simple modal debug: pjax id"),console.log(n)}if(this.pjaxId){var o=this.$pjaxContainer.data("url");o?t.pjax({url:o,container:"#"+this.pjaxId}):t.pjax.reload("#"+this.pjaxId)}else console.log("pjax not container id")},e.DEFAULTS={debug:!1,notifyPosition:"center",customHandleResult:!1,timeout:3e3};var o=t.fn.simpleModal;t.fn.simpleModal=function(o){return this.each((function(){var i=t(this),r=i.data("bs.simpleModal");if(!r){var a=t.extend({},e.DEFAULTS,i.data(),"object"==n(o)&&o);i.data("bs.simpleModal",r=new e(this,a))}"string"==typeof o&&r[o].call(r)}))},t.fn.simpleModal.Constructor=e,t.fn.simpleModal.noConflict=function(){return t.fn.simpleModal=o,this}}(jQuery)},194:function(t,e){!function(t){function e(t,e,n){layer.msg(t,{skin:"layui-layer-molv",icon:e,time:n})}t.fn.layerFormPage=function(){return this.each((function(){var n=t(this),o=n.data("targetHtmlId");n.on("submit","form",(function(n){n.preventDefault(),t(n.target).ajaxSubmit({headers:{"AJAX-SUBMIT":"AJAX-SUBMIT"},success:function(t){var n="error";if("success"==t.status&&(n="success"),e(t.message,"success"==n?1:2,3e3),"success"==t.status){var i=window.parent.jQuery(o,window.parent.document);0==i.length&&e("表单页的定义的父窗口的容器Id错误:"+o,2,3e3),i.advanceSelect("handleSubmit",t)}},error:function(t,n,o){e(t.responseJSON.message,2,3e3)}})}))}))}}(jQuery)},195:function(t,e){function n(t){return(n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}!function(t){var e=function(e,n){this.options=n,this.$element=t(e),this.init(),this.handleCreateForm(),this.handleSelectChange(),this.handleInputChange(),this.handleRemove()};e.prototype.init=function(){this.$formButton=this.$element.find("a[create-form]"),this.$input=this.$element.find("input[type="+this.options.inputType+"]"),this.$pjaxContainer=this.$element.find("div[role=data-pjax-container]"),this.$select=this.$element.find("select"),this.$select.select2({ajax:{url:this.options.optionLoadUrl,dataType:"json"}})},e.prototype.handleCreateForm=function(){var e=this.options;this.$formButton.on("click",(function(n){var o=t(this);n.preventDefault(),layer.open({type:2,title:e.formTitle,maxmin:!1,shadeClose:!0,area:e.formArea,content:o.attr("href")})}))},e.prototype.handleInputChange=function(){var e=this.options.resultLoadUrl+"?"+this.$input.attr("name")+"="+this.$input.val();t.pjax({url:e,container:"#"+this.options.pjaxId,push:!1,scrollTo:!1,async:!1})},e.prototype.handleSelectChange=function(){var t=this;this.$select.on("change",(function(e){t.addOne(t.$select.val())}))},e.prototype.addOne=function(t){var e=this.$input.val().split(",").filter((function(t){return!!t}));e.push(t),this.$input.val(e.distinct().join(",")),this.handleInputChange()},e.prototype.handleSubmit=function(t){var e=this.options.onSubmitSuccess.call(this,t);console.log("AdvanceSelect Handle Submit receiver val: "+e),e&&(this.addOne(e),layer.closeAll())},e.prototype.handleRemove=function(){var e=this;this.$element.on("click","a[remove]",(function(n){n.preventDefault();var o=t(this);if(confirm("确定移除？")){var i=e.$input.val();ids=i.trim().split(",").filter((function(t){return!!t&&t!=o.data("val")})),e.$input.val(ids.join(",")),e.handleInputChange()}}))},e.DEFAULTS={inputType:"hidden",resultLoadUrl:"",optionLoadUrl:"",pjaxId:"",formTitle:"添加",formArea:["800px","600px"],onSubmitSuccess:function(t){console.log(t)}};var o=t.fn.advanceSelect;t.fn.advanceSelect=function(o,i){return this.each((function(){var r=t(this),a=r.data("bs.advanceSelect");if(!a){var s=t.extend({},e.DEFAULTS,r.data(),"object"==n(o)&&o);r.data("bs.advanceSelect",a=new e(this,s))}"string"==typeof o&&a[o].call(a,i)}))},t.fn.advanceSelect.Constructor=e,t.fn.advanceSelect.noConflict=function(){return t.fn.advanceSelect=o,this}}(jQuery)},196:function(t,e){!function(t){t.fn.checkboxSelection=function(){return this.each((function(){var e=t(this),n=e.find("input[type=hidden]"),o=e.find("input[value=all]"),i=e.find("input[type=checkbox]"),r=i.length;i.on("click",(function(){var a=t(this),s=e.find("input[type=checkbox]:checked");if("all"==a.val())a.prop("checked")?i.prop("checked",!0):i.prop("checked",!1);else{var l=i.prop("checked");l&&s.length<r||!l&&s.length<r-1?o.prop("checked",!1):o.prop("checked",!0)}var u=[];e.find("input[type=checkbox]:checked").each((function(e,n){u.push(t(n).val())})),n.val(u.join(","))}))}))}}(jQuery)},197:function(t,e){!function(t){function e(t){t.find(".radio-card").removeClass("active");var e=t.find("input[type=radio]:checked");console.log(e),e.length>0&&(console.log(e.parents(".radio-card")),e.parents(".radio-card").addClass("active"))}t.fn.radioCard=function(){return this.each((function(){var n=t(this);e(n),n.find("input[type=radio]").on("click",(function(o){console.log(t(this).prop("checked")),e(n)}))}))}}(jQuery)},198:function(t,e){function n(t){if("undefined"==typeof Symbol||null==t[Symbol.iterator]){if(Array.isArray(t)||(t=function(t,e){if(!t)return;if("string"==typeof t)return o(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);"Object"===n&&t.constructor&&(n=t.constructor.name);if("Map"===n||"Set"===n)return Array.from(n);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return o(t,e)}(t))){var e=0,n=function(){};return{s:n,n:function(){return e>=t.length?{done:!0}:{done:!1,value:t[e++]}},e:function(t){throw t},f:n}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,r,a=!0,s=!1;return{s:function(){i=t[Symbol.iterator]()},n:function(){var t=i.next();return a=t.done,t},e:function(t){s=!0,r=t},f:function(){try{a||null==i.return||i.return()}finally{if(s)throw r}}}}function o(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,o=new Array(e);n<e;n++)o[n]=t[n];return o}!function(t){function e(n){var o=n.shift();if(null!=o){$self=t(o);var i=$self.data();$self.empty();var r={};if(null!=i.parentId&&i.param)r[i.param]=i.parentId;else if(i.parent&&i.param){var a=t(i.parent),s=t(a.data("parent"));a&&i.url&&null!=a.val()?r[i.param]=a.val():s&&i.url&&null!=s.val()&&(r[i.param]=s.val())}else alert("连级下拉框参数配置不正确:"+$self.attr("name"));(function(t){var e;for(e in t)return!0;return!1})(r)&&t.getJSON(i.url,r,(function(t){$self.append(function(t,e){var n="";for(var o in t){var i=t[o];"function"!=typeof i&&(n+=o==e?"<option value='"+o+"' selected >"+i+"</option>":"<option value='"+o+"'>"+i+"</option>")}return n}(t,i.value)),e(n)}))}}t.fn.linkageSelect=function(){t(document).off("change.site.linkage"),function(){var o=t("select[data-linkage=root]");if(o.length>0){var i=[o],r=o.data("queue").split(",");if(r){var a,s=n(r);try{for(s.s();!(a=s.n()).done;){var l=a.value;i.push(l)}}catch(t){s.e(t)}finally{s.f()}}e(i)}}(),t(document).on("change.site.linkage","select[data-linkage]",(function(){var n=t(this).data("queue");n&&e(n.split(","))}))}}(jQuery)},205:function(t,e){(function(){var t,e,n,o,i,r=function(t,e){return function(){return t.apply(e,arguments)}},a=[].indexOf||function(t){for(var e=0,n=this.length;e<n;e++)if(e in this&&this[e]===t)return e;return-1};e=function(){function t(){}return t.prototype.extend=function(t,e){var n,o;for(n in e)o=e[n],null==t[n]&&(t[n]=o);return t},t.prototype.isMobile=function(t){return/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(t)},t.prototype.createEvent=function(t,e,n,o){var i;return null==e&&(e=!1),null==n&&(n=!1),null==o&&(o=null),null!=document.createEvent?(i=document.createEvent("CustomEvent")).initCustomEvent(t,e,n,o):null!=document.createEventObject?(i=document.createEventObject()).eventType=t:i.eventName=t,i},t.prototype.emitEvent=function(t,e){return null!=t.dispatchEvent?t.dispatchEvent(e):e in(null!=t)?t[e]():"on"+e in(null!=t)?t["on"+e]():void 0},t.prototype.addEvent=function(t,e,n){return null!=t.addEventListener?t.addEventListener(e,n,!1):null!=t.attachEvent?t.attachEvent("on"+e,n):t[e]=n},t.prototype.removeEvent=function(t,e,n){return null!=t.removeEventListener?t.removeEventListener(e,n,!1):null!=t.detachEvent?t.detachEvent("on"+e,n):delete t[e]},t.prototype.innerHeight=function(){return"innerHeight"in window?window.innerHeight:document.documentElement.clientHeight},t}(),n=this.WeakMap||this.MozWeakMap||(n=function(){function t(){this.keys=[],this.values=[]}return t.prototype.get=function(t){var e,n,o,i;for(e=n=0,o=(i=this.keys).length;n<o;e=++n)if(i[e]===t)return this.values[e]},t.prototype.set=function(t,e){var n,o,i,r;for(n=o=0,i=(r=this.keys).length;o<i;n=++o)if(r[n]===t)return void(this.values[n]=e);return this.keys.push(t),this.values.push(e)},t}()),t=this.MutationObserver||this.WebkitMutationObserver||this.MozMutationObserver||(t=function(){function t(){"undefined"!=typeof console&&null!==console&&console.warn("MutationObserver is not supported by your browser."),"undefined"!=typeof console&&null!==console&&console.warn("WOW.js cannot detect dom mutations, please call .sync() after loading new content.")}return t.notSupported=!0,t.prototype.observe=function(){},t}()),o=this.getComputedStyle||function(t,e){return this.getPropertyValue=function(e){var n;return"float"===e&&(e="styleFloat"),i.test(e)&&e.replace(i,(function(t,e){return e.toUpperCase()})),(null!=(n=t.currentStyle)?n[e]:void 0)||null},this},i=/(\-([a-z]){1})/g,this.WOW=function(){function i(t){null==t&&(t={}),this.scrollCallback=r(this.scrollCallback,this),this.scrollHandler=r(this.scrollHandler,this),this.resetAnimation=r(this.resetAnimation,this),this.start=r(this.start,this),this.scrolled=!0,this.config=this.util().extend(t,this.defaults),null!=t.scrollContainer&&(this.config.scrollContainer=document.querySelector(t.scrollContainer)),this.animationNameCache=new n,this.wowEvent=this.util().createEvent(this.config.boxClass)}return i.prototype.defaults={boxClass:"wow",animateClass:"animated",offset:0,mobile:!0,live:!0,callback:null,scrollContainer:null},i.prototype.init=function(){var t;return this.element=window.document.documentElement,"interactive"===(t=document.readyState)||"complete"===t?this.start():this.util().addEvent(document,"DOMContentLoaded",this.start),this.finished=[]},i.prototype.start=function(){var e,n,o,i,r;if(this.stopped=!1,this.boxes=function(){var t,n,o,i;for(i=[],t=0,n=(o=this.element.querySelectorAll("."+this.config.boxClass)).length;t<n;t++)e=o[t],i.push(e);return i}.call(this),this.all=function(){var t,n,o,i;for(i=[],t=0,n=(o=this.boxes).length;t<n;t++)e=o[t],i.push(e);return i}.call(this),this.boxes.length)if(this.disabled())this.resetStyle();else for(n=0,o=(i=this.boxes).length;n<o;n++)e=i[n],this.applyStyle(e,!0);if(this.disabled()||(this.util().addEvent(this.config.scrollContainer||window,"scroll",this.scrollHandler),this.util().addEvent(window,"resize",this.scrollHandler),this.interval=setInterval(this.scrollCallback,50)),this.config.live)return new t((r=this,function(t){var e,n,o,i,a;for(a=[],e=0,n=t.length;e<n;e++)i=t[e],a.push(function(){var t,e,n,r;for(r=[],t=0,e=(n=i.addedNodes||[]).length;t<e;t++)o=n[t],r.push(this.doSync(o));return r}.call(r));return a})).observe(document.body,{childList:!0,subtree:!0})},i.prototype.stop=function(){if(this.stopped=!0,this.util().removeEvent(this.config.scrollContainer||window,"scroll",this.scrollHandler),this.util().removeEvent(window,"resize",this.scrollHandler),null!=this.interval)return clearInterval(this.interval)},i.prototype.sync=function(e){if(t.notSupported)return this.doSync(this.element)},i.prototype.doSync=function(t){var e,n,o,i,r;if(null==t&&(t=this.element),1===t.nodeType){for(r=[],n=0,o=(i=(t=t.parentNode||t).querySelectorAll("."+this.config.boxClass)).length;n<o;n++)e=i[n],a.call(this.all,e)<0?(this.boxes.push(e),this.all.push(e),this.stopped||this.disabled()?this.resetStyle():this.applyStyle(e,!0),r.push(this.scrolled=!0)):r.push(void 0);return r}},i.prototype.show=function(t){return this.applyStyle(t),t.className=t.className+" "+this.config.animateClass,null!=this.config.callback&&this.config.callback(t),this.util().emitEvent(t,this.wowEvent),this.util().addEvent(t,"animationend",this.resetAnimation),this.util().addEvent(t,"oanimationend",this.resetAnimation),this.util().addEvent(t,"webkitAnimationEnd",this.resetAnimation),this.util().addEvent(t,"MSAnimationEnd",this.resetAnimation),t},i.prototype.applyStyle=function(t,e){var n,o,i,r;return o=t.getAttribute("data-wow-duration"),n=t.getAttribute("data-wow-delay"),i=t.getAttribute("data-wow-iteration"),this.animate((r=this,function(){return r.customStyle(t,e,o,n,i)}))},i.prototype.animate="requestAnimationFrame"in window?function(t){return window.requestAnimationFrame(t)}:function(t){return t()},i.prototype.resetStyle=function(){var t,e,n,o,i;for(i=[],e=0,n=(o=this.boxes).length;e<n;e++)t=o[e],i.push(t.style.visibility="visible");return i},i.prototype.resetAnimation=function(t){var e;if(t.type.toLowerCase().indexOf("animationend")>=0)return(e=t.target||t.srcElement).className=e.className.replace(this.config.animateClass,"").trim()},i.prototype.customStyle=function(t,e,n,o,i){return e&&this.cacheAnimationName(t),t.style.visibility=e?"hidden":"visible",n&&this.vendorSet(t.style,{animationDuration:n}),o&&this.vendorSet(t.style,{animationDelay:o}),i&&this.vendorSet(t.style,{animationIterationCount:i}),this.vendorSet(t.style,{animationName:e?"none":this.cachedAnimationName(t)}),t},i.prototype.vendors=["moz","webkit"],i.prototype.vendorSet=function(t,e){var n,o,i,r;for(n in o=[],e)i=e[n],t[""+n]=i,o.push(function(){var e,o,a,s;for(s=[],e=0,o=(a=this.vendors).length;e<o;e++)r=a[e],s.push(t[""+r+n.charAt(0).toUpperCase()+n.substr(1)]=i);return s}.call(this));return o},i.prototype.vendorCSS=function(t,e){var n,i,r,a,s,l;for(a=(s=o(t)).getPropertyCSSValue(e),n=0,i=(r=this.vendors).length;n<i;n++)l=r[n],a=a||s.getPropertyCSSValue("-"+l+"-"+e);return a},i.prototype.animationName=function(t){var e;try{e=this.vendorCSS(t,"animation-name").cssText}catch(n){e=o(t).getPropertyValue("animation-name")}return"none"===e?"":e},i.prototype.cacheAnimationName=function(t){return this.animationNameCache.set(t,this.animationName(t))},i.prototype.cachedAnimationName=function(t){return this.animationNameCache.get(t)},i.prototype.scrollHandler=function(){return this.scrolled=!0},i.prototype.scrollCallback=function(){var t;if(this.scrolled&&(this.scrolled=!1,this.boxes=function(){var e,n,o,i;for(i=[],e=0,n=(o=this.boxes).length;e<n;e++)(t=o[e])&&(this.isVisible(t)?this.show(t):i.push(t));return i}.call(this),!this.boxes.length&&!this.config.live))return this.stop()},i.prototype.offsetTop=function(t){for(var e;void 0===t.offsetTop;)t=t.parentNode;for(e=t.offsetTop;t=t.offsetParent;)e+=t.offsetTop;return e},i.prototype.isVisible=function(t){var e,n,o,i,r;return n=t.getAttribute("data-wow-offset")||this.config.offset,i=(r=this.config.scrollContainer&&this.config.scrollContainer.scrollTop||window.pageYOffset)+Math.min(this.element.clientHeight,this.util().innerHeight())-n,e=(o=this.offsetTop(t))+t.clientHeight,o<=i&&e>=r},i.prototype.util=function(){return null!=this._util?this._util:this._util=new e},i.prototype.disabled=function(){return!this.config.mobile&&this.util().isMobile(navigator.userAgent)},i}()}).call(this)},338:function(t,e,n){t.exports=n(339)},339:function(t,e,n){"use strict";n.r(e);var o=n(205);n(191),n(192),n(340),n(341),n(342),n(343),n(193),n(195),n(198),n(194),n(196),n(197);$((function(){var t=function(t){t=t||"";var e=document.createElement("b");return e.innerHTML="\x3c!--[if IE "+t+"]>1<![endif]--\x3e","1"===e.innerHTML};t(8)||t(7)||new o.WOW({animateClass:"animated"}).init()}))},340:function(t,e){!function(t){t.fn.navbarAffix=function(e,n){return this.each((function(){t(this).affix({offset:{top:50,bottom:function(){return this.bottom=t(".footer").outerHeight(!0)}}}).on("affixed.bs.affix",(function(){t(this).data("affix-one")||t(this).removeClass(e).addClass(n)})).on("affixed-top.bs.affix",(function(){t(this).data("affix-one")||t(this).removeClass(n).addClass(e)}))}))}}(jQuery)},341:function(t,e){!function(t){var e=function(e){this.$element=t(e),console.log(this.$element),this.$columns=this.$element.find('[class*="col-"]')};function n(n){return this.each((function(){var o=t(this),i=o.data("bs.fixcolheight");i||o.data("bs.fixcolheight",i=new e(this)),"string"==typeof n&&i[n].call(i)}))}e.prototype.resize=function(){var e=0;this.$columns.height("auto"),this.$columns.each((function(){var n=t(this).height();n>e&&(e=n)})),this.$columns.height(e)};var o=t.fn.fixColHeight;t.fn.fixColHeight=n,t.fn.fixColHeight.Constructor=e,t.fn.fixColHeight.noConflict=function(){return t.fn.fixColHeight=o,this};var i=function(){t(".fix-col-height").each((function(){n.call(t(this),"resize")}))};t(window).on("load.bs.fixcolheight.data-api",i),t(window).on("resize.bs.fixcolheight.data-api",i)}(jQuery)},342:function(t,e){!function(t){function e(){t(".ifra-video, .iframe-video").each((function(){var e=t(this),n=e.parent().width(),o=e.attr("width"),i=n>510?o:n,r=488*i/866;e.attr("width"),e.attr("width",i),e.attr("height",r)}))}t(window).on("load ",e),t(window).on("resize onorientationchange",e)}(jQuery)},343:function(t,e){!function(t){var e="width: 100%;padding: 15px;margin-bottom: 15px;border: 1px solid #ffc6d1;border-radius: 3px;background-color: #ffe0e5;color: #FE2E54;";var n=t('<div class="text-center col-xs-12" style="'+e+'"><i class="fa fa-spinner"></i> 加载中...</div>'),o=t('<div class="text-center col-xs-12"style="'+e+'"> 没有更多了 </div>');t.fn.scrolloader=function(e){return this.each((function(){var i=t(this),r=parseInt(e.totalPages);t(window).scroll((function(){var a=parseInt(i.attr("data-page")||2),s=i.attr("data-status")||"off",l=Math.ceil(t(document).scrollTop())+t(window).height()>=t(document).height(),u=e.data||{};if("off"==s&&l&&r>=a){i.after(n),u.page=a,i.attr("data-page",a+1),i.attr("data-status","on");var c=setTimeout((function(){t.get(e.url,u,(function(t){i.append(t),clearTimeout(c),i.attr("data-status","off"),n.remove()}))}),800)}"off"==s&&r<a&&i.after(o)}))}))}}(jQuery)}});