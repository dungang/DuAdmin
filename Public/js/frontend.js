!function(t){var e={};function n(i){if(e[i])return e[i].exports;var o=e[i]={i:i,l:!1,exports:{}};return t[i].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=t,n.c=e,n.d=function(t,e,i){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:i})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)n.d(i,o,function(e){return t[e]}.bind(null,o));return i},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/",n(n.s=318)}({196:function(t,e){(function(){var t,e,n,i,o,r=function(t,e){return function(){return t.apply(e,arguments)}},s=[].indexOf||function(t){for(var e=0,n=this.length;e<n;e++)if(e in this&&this[e]===t)return e;return-1};e=function(){function t(){}return t.prototype.extend=function(t,e){var n,i;for(n in e)i=e[n],null==t[n]&&(t[n]=i);return t},t.prototype.isMobile=function(t){return/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(t)},t.prototype.createEvent=function(t,e,n,i){var o;return null==e&&(e=!1),null==n&&(n=!1),null==i&&(i=null),null!=document.createEvent?(o=document.createEvent("CustomEvent")).initCustomEvent(t,e,n,i):null!=document.createEventObject?(o=document.createEventObject()).eventType=t:o.eventName=t,o},t.prototype.emitEvent=function(t,e){return null!=t.dispatchEvent?t.dispatchEvent(e):e in(null!=t)?t[e]():"on"+e in(null!=t)?t["on"+e]():void 0},t.prototype.addEvent=function(t,e,n){return null!=t.addEventListener?t.addEventListener(e,n,!1):null!=t.attachEvent?t.attachEvent("on"+e,n):t[e]=n},t.prototype.removeEvent=function(t,e,n){return null!=t.removeEventListener?t.removeEventListener(e,n,!1):null!=t.detachEvent?t.detachEvent("on"+e,n):delete t[e]},t.prototype.innerHeight=function(){return"innerHeight"in window?window.innerHeight:document.documentElement.clientHeight},t}(),n=this.WeakMap||this.MozWeakMap||(n=function(){function t(){this.keys=[],this.values=[]}return t.prototype.get=function(t){var e,n,i,o;for(e=n=0,i=(o=this.keys).length;n<i;e=++n)if(o[e]===t)return this.values[e]},t.prototype.set=function(t,e){var n,i,o,r;for(n=i=0,o=(r=this.keys).length;i<o;n=++i)if(r[n]===t)return void(this.values[n]=e);return this.keys.push(t),this.values.push(e)},t}()),t=this.MutationObserver||this.WebkitMutationObserver||this.MozMutationObserver||(t=function(){function t(){"undefined"!=typeof console&&null!==console&&console.warn("MutationObserver is not supported by your browser."),"undefined"!=typeof console&&null!==console&&console.warn("WOW.js cannot detect dom mutations, please call .sync() after loading new content.")}return t.notSupported=!0,t.prototype.observe=function(){},t}()),i=this.getComputedStyle||function(t,e){return this.getPropertyValue=function(e){var n;return"float"===e&&(e="styleFloat"),o.test(e)&&e.replace(o,(function(t,e){return e.toUpperCase()})),(null!=(n=t.currentStyle)?n[e]:void 0)||null},this},o=/(\-([a-z]){1})/g,this.WOW=function(){function o(t){null==t&&(t={}),this.scrollCallback=r(this.scrollCallback,this),this.scrollHandler=r(this.scrollHandler,this),this.resetAnimation=r(this.resetAnimation,this),this.start=r(this.start,this),this.scrolled=!0,this.config=this.util().extend(t,this.defaults),null!=t.scrollContainer&&(this.config.scrollContainer=document.querySelector(t.scrollContainer)),this.animationNameCache=new n,this.wowEvent=this.util().createEvent(this.config.boxClass)}return o.prototype.defaults={boxClass:"wow",animateClass:"animated",offset:0,mobile:!0,live:!0,callback:null,scrollContainer:null},o.prototype.init=function(){var t;return this.element=window.document.documentElement,"interactive"===(t=document.readyState)||"complete"===t?this.start():this.util().addEvent(document,"DOMContentLoaded",this.start),this.finished=[]},o.prototype.start=function(){var e,n,i,o,r;if(this.stopped=!1,this.boxes=function(){var t,n,i,o;for(o=[],t=0,n=(i=this.element.querySelectorAll("."+this.config.boxClass)).length;t<n;t++)e=i[t],o.push(e);return o}.call(this),this.all=function(){var t,n,i,o;for(o=[],t=0,n=(i=this.boxes).length;t<n;t++)e=i[t],o.push(e);return o}.call(this),this.boxes.length)if(this.disabled())this.resetStyle();else for(n=0,i=(o=this.boxes).length;n<i;n++)e=o[n],this.applyStyle(e,!0);if(this.disabled()||(this.util().addEvent(this.config.scrollContainer||window,"scroll",this.scrollHandler),this.util().addEvent(window,"resize",this.scrollHandler),this.interval=setInterval(this.scrollCallback,50)),this.config.live)return new t((r=this,function(t){var e,n,i,o,s;for(s=[],e=0,n=t.length;e<n;e++)o=t[e],s.push(function(){var t,e,n,r;for(r=[],t=0,e=(n=o.addedNodes||[]).length;t<e;t++)i=n[t],r.push(this.doSync(i));return r}.call(r));return s})).observe(document.body,{childList:!0,subtree:!0})},o.prototype.stop=function(){if(this.stopped=!0,this.util().removeEvent(this.config.scrollContainer||window,"scroll",this.scrollHandler),this.util().removeEvent(window,"resize",this.scrollHandler),null!=this.interval)return clearInterval(this.interval)},o.prototype.sync=function(e){if(t.notSupported)return this.doSync(this.element)},o.prototype.doSync=function(t){var e,n,i,o,r;if(null==t&&(t=this.element),1===t.nodeType){for(r=[],n=0,i=(o=(t=t.parentNode||t).querySelectorAll("."+this.config.boxClass)).length;n<i;n++)e=o[n],s.call(this.all,e)<0?(this.boxes.push(e),this.all.push(e),this.stopped||this.disabled()?this.resetStyle():this.applyStyle(e,!0),r.push(this.scrolled=!0)):r.push(void 0);return r}},o.prototype.show=function(t){return this.applyStyle(t),t.className=t.className+" "+this.config.animateClass,null!=this.config.callback&&this.config.callback(t),this.util().emitEvent(t,this.wowEvent),this.util().addEvent(t,"animationend",this.resetAnimation),this.util().addEvent(t,"oanimationend",this.resetAnimation),this.util().addEvent(t,"webkitAnimationEnd",this.resetAnimation),this.util().addEvent(t,"MSAnimationEnd",this.resetAnimation),t},o.prototype.applyStyle=function(t,e){var n,i,o,r;return i=t.getAttribute("data-wow-duration"),n=t.getAttribute("data-wow-delay"),o=t.getAttribute("data-wow-iteration"),this.animate((r=this,function(){return r.customStyle(t,e,i,n,o)}))},o.prototype.animate="requestAnimationFrame"in window?function(t){return window.requestAnimationFrame(t)}:function(t){return t()},o.prototype.resetStyle=function(){var t,e,n,i,o;for(o=[],e=0,n=(i=this.boxes).length;e<n;e++)t=i[e],o.push(t.style.visibility="visible");return o},o.prototype.resetAnimation=function(t){var e;if(t.type.toLowerCase().indexOf("animationend")>=0)return(e=t.target||t.srcElement).className=e.className.replace(this.config.animateClass,"").trim()},o.prototype.customStyle=function(t,e,n,i,o){return e&&this.cacheAnimationName(t),t.style.visibility=e?"hidden":"visible",n&&this.vendorSet(t.style,{animationDuration:n}),i&&this.vendorSet(t.style,{animationDelay:i}),o&&this.vendorSet(t.style,{animationIterationCount:o}),this.vendorSet(t.style,{animationName:e?"none":this.cachedAnimationName(t)}),t},o.prototype.vendors=["moz","webkit"],o.prototype.vendorSet=function(t,e){var n,i,o,r;for(n in i=[],e)o=e[n],t[""+n]=o,i.push(function(){var e,i,s,a;for(a=[],e=0,i=(s=this.vendors).length;e<i;e++)r=s[e],a.push(t[""+r+n.charAt(0).toUpperCase()+n.substr(1)]=o);return a}.call(this));return i},o.prototype.vendorCSS=function(t,e){var n,o,r,s,a,l;for(s=(a=i(t)).getPropertyCSSValue(e),n=0,o=(r=this.vendors).length;n<o;n++)l=r[n],s=s||a.getPropertyCSSValue("-"+l+"-"+e);return s},o.prototype.animationName=function(t){var e;try{e=this.vendorCSS(t,"animation-name").cssText}catch(n){e=i(t).getPropertyValue("animation-name")}return"none"===e?"":e},o.prototype.cacheAnimationName=function(t){return this.animationNameCache.set(t,this.animationName(t))},o.prototype.cachedAnimationName=function(t){return this.animationNameCache.get(t)},o.prototype.scrollHandler=function(){return this.scrolled=!0},o.prototype.scrollCallback=function(){var t;if(this.scrolled&&(this.scrolled=!1,this.boxes=function(){var e,n,i,o;for(o=[],e=0,n=(i=this.boxes).length;e<n;e++)(t=i[e])&&(this.isVisible(t)?this.show(t):o.push(t));return o}.call(this),!this.boxes.length&&!this.config.live))return this.stop()},o.prototype.offsetTop=function(t){for(var e;void 0===t.offsetTop;)t=t.parentNode;for(e=t.offsetTop;t=t.offsetParent;)e+=t.offsetTop;return e},o.prototype.isVisible=function(t){var e,n,i,o,r;return n=t.getAttribute("data-wow-offset")||this.config.offset,o=(r=this.config.scrollContainer&&this.config.scrollContainer.scrollTop||window.pageYOffset)+Math.min(this.element.clientHeight,this.util().innerHeight())-n,e=(i=this.offsetTop(t))+t.clientHeight,i<=o&&e>=r},o.prototype.util=function(){return null!=this._util?this._util:this._util=new e},o.prototype.disabled=function(){return!this.config.mobile&&this.util().isMobile(navigator.userAgent)},o}()}).call(this)},318:function(t,e,n){t.exports=n(319)},319:function(t,e,n){"use strict";n.r(e);var i=n(196);n(320),n(321),n(322),n(323);$((function(){var t=function(t){t=t||"";var e=document.createElement("b");return e.innerHTML="\x3c!--[if IE "+t+"]>1<![endif]--\x3e","1"===e.innerHTML};t(8)||t(7)||new i.WOW({animateClass:"animated"}).init()}))},320:function(t,e){!function(t){t(window).on("load",(function(){var e=t(".nav-affix"),n="navbar-inverse",i="navbar-default";e.hasClass("navbar-default")&&(n="navbar-default"),i="navbar-inverse"==n?"navbar-default":"navbar-inverse",t(".nav-affix").affix({offset:{top:50,bottom:function(){return this.bottom=t(".footer").outerHeight(!0)}}}).on("affixed.bs.affix",(function(){t(this).data("affix-one")||t(this).removeClass(n).addClass(i)})).on("affixed-top.bs.affix",(function(){t(this).data("affix-one")||t(this).removeClass(i).addClass(n)}))}))}(jQuery)},321:function(t,e){!function(t){var e=function(e){this.$element=t(e),console.log(this.$element),this.$columns=this.$element.find('[class*="col-"]')};function n(n){return this.each((function(){var i=t(this),o=i.data("bs.fixcolheight");o||i.data("bs.fixcolheight",o=new e(this)),"string"==typeof n&&o[n].call(o)}))}e.prototype.resize=function(){var e=0;this.$columns.height("auto"),this.$columns.each((function(){var n=t(this).height();n>e&&(e=n)})),this.$columns.height(e)};var i=t.fn.fixColHeight;t.fn.fixColHeight=n,t.fn.fixColHeight.Constructor=e,t.fn.fixColHeight.noConflict=function(){return t.fn.fixColHeight=i,this};var o=function(){t(".fix-col-height").each((function(){n.call(t(this),"resize")}))};t(window).on("load.bs.fixcolheight.data-api",o),t(window).on("resize.bs.fixcolheight.data-api",o)}(jQuery)},322:function(t,e){!function(t){function e(){t(".ifra-video, .iframe-video").each((function(){var e=t(this),n=e.parent().width(),i=e.attr("width"),o=n>510?i:n,r=488*o/866;e.attr("width"),e.attr("width",o),e.attr("height",r)}))}t(window).on("load ",e),t(window).on("resize onorientationchange",e)}(jQuery)},323:function(t,e){!function(t){var e="width: 100%;padding: 15px;margin-bottom: 15px;border: 1px solid #ffc6d1;border-radius: 3px;background-color: #ffe0e5;color: #FE2E54;";var n=t('<div class="text-center col-xs-12" style="'+e+'"><i class="fa fa-spinner"></i> 加载中...</div>'),i=t('<div class="text-center col-xs-12"style="'+e+'"> 没有更多了 </div>');t.fn.scrolloader=function(e){return this.each((function(){var o=t(this),r=parseInt(e.totalPages);t(window).scroll((function(){var s=parseInt(o.attr("data-page")||2),a=o.attr("data-status")||"off",l=Math.ceil(t(document).scrollTop())+t(window).height()>=t(document).height(),u=e.data||{};if("off"==a&&l&&r>=s){o.after(n),u.page=s,o.attr("data-page",s+1),o.attr("data-status","on");var c=setTimeout((function(){t.get(e.url,u,(function(t){o.append(t),clearTimeout(c),o.attr("data-status","off"),n.remove()}))}),800)}"off"==a&&r<s&&o.after(i)}))}))}}(jQuery)}});