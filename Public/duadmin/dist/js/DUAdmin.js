/*! For license information please see DUAdmin.js.LICENSE.txt */
!function(t){var e={};function n(i){if(e[i])return e[i].exports;var o=e[i]={i:i,l:!1,exports:{}};return t[i].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=t,n.c=e,n.d=function(t,e,i){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:i})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)n.d(i,o,function(e){return t[e]}.bind(null,o));return i},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/",n(n.s=256)}({256:function(t,e,n){t.exports=n(257)},257:function(t,e,n){"use strict";n.r(e);n(258),n(259),n(260)},258:function(t,e){if("undefined"==typeof jQuery)throw new Error("AdminLTE requires jQuery");!function(t){"use strict";var e={animationSpeed:500,collapseTrigger:'[data-widget="collapse"]',removeTrigger:'[data-widget="remove"]',collapseIcon:"fa-minus",expandIcon:"fa-plus",removeIcon:"fa-times"},n=".box",i=".collapsed-box",o=".box-body",a=".box-footer",r=".box-tools",s="collapsed-box",l="collapsed.boxwidget",c="expanded.boxwidget",d="removed.boxwidget",u=function(t,e){this.element=t,this.options=e,this._setUpListeners()};function f(n){return this.each((function(){var i=t(this),o=i.data("lte.boxwidget");if(!o){var a=t.extend({},e,i.data(),"object"==typeof n&&n);i.data("lte.boxwidget",o=new u(i,a))}if("string"==typeof n){if(void 0===o[n])throw new Error("No method named "+n);o[n]()}}))}u.prototype.toggle=function(){!t(this.element).is(i)?this.collapse():this.expand()},u.prototype.expand=function(){var e=t.Event(c),n=this.options.collapseIcon,i=this.options.expandIcon;t(this.element).removeClass(s),t(this.element).find(r).find("."+i).removeClass(i).addClass(n),t(this.element).find(o+", "+a).slideDown(this.options.animationSpeed,function(){t(this.element).trigger(e)}.bind(this))},u.prototype.collapse=function(){var e=t.Event(l),n=this.options.collapseIcon,i=this.options.expandIcon;t(this.element).find(r).find("."+n).removeClass(n).addClass(i),t(this.element).find(o+", "+a).slideUp(this.options.animationSpeed,function(){t(this.element).addClass(s),t(this.element).trigger(e)}.bind(this))},u.prototype.remove=function(){var e=t.Event(d);t(this.element).slideUp(this.options.animationSpeed,function(){t(this.element).trigger(e),t(this.element).remove()}.bind(this))},u.prototype._setUpListeners=function(){var e=this;t(this.element).on("click",this.options.collapseTrigger,(function(t){t&&t.preventDefault(),e.toggle()})),t(this.element).on("click",this.options.removeTrigger,(function(t){t&&t.preventDefault(),e.remove()}))};var p=t.fn.boxWidget;t.fn.boxWidget=f,t.fn.boxWidget.Constructor=u,t.fn.boxWidget.noConflict=function(){return t.fn.boxWidget=p,this},t(window).on("load",(function(){t(n).each((function(){f.call(t(this))}))}))}(jQuery),function(t){"use strict";var e={slide:!0},n=".control-sidebar",i='[data-toggle="control-sidebar"]',o=".control-sidebar-open",a=".control-sidebar-bg",r=".wrapper",s=".layout-boxed",l="control-sidebar-open",c="collapsed.controlsidebar",d="expanded.controlsidebar",u=function(t,e){this.element=t,this.options=e,this.hasBindedResize=!1,this.init()};function f(n){return this.each((function(){var i=t(this),o=i.data("lte.controlsidebar");if(!o){var a=t.extend({},e,i.data(),"object"==typeof n&&n);i.data("lte.controlsidebar",o=new u(i,a))}"string"==typeof n&&o.toggle()}))}u.prototype.init=function(){t(this.element).is(i)||t(this).on("click",this.toggle),this.fix(),t(window).resize(function(){this.fix()}.bind(this))},u.prototype.toggle=function(e){e&&e.preventDefault(),this.fix(),t(n).is(o)||t("body").is(o)?this.collapse():this.expand()},u.prototype.expand=function(){this.options.slide?t(n).addClass(l):t("body").addClass(l),t(this.element).trigger(t.Event(d))},u.prototype.collapse=function(){t("body, "+n).removeClass(l),t(this.element).trigger(t.Event(c))},u.prototype.fix=function(){t("body").is(s)&&this._fixForBoxed(t(a))},u.prototype._fixForBoxed=function(e){e.css({position:"absolute",height:t(r).height()})};var p=t.fn.controlSidebar;t.fn.controlSidebar=f,t.fn.controlSidebar.Constructor=u,t.fn.controlSidebar.noConflict=function(){return t.fn.controlSidebar=p,this},t(document).on("click",i,(function(e){e&&e.preventDefault(),f.call(t(this),"toggle")}))}(jQuery),function(t){"use strict";var e='[data-widget="chat-pane-toggle"]',n=".direct-chat",i="direct-chat-contacts-open",o=function(t){this.element=t};function a(e){return this.each((function(){var n=t(this),i=n.data("lte.directchat");i||n.data("lte.directchat",i=new o(n)),"string"==typeof e&&i.toggle(n)}))}o.prototype.toggle=function(t){t.parents(n).first().toggleClass(i)};var r=t.fn.directChat;t.fn.directChat=a,t.fn.directChat.Constructor=o,t.fn.directChat.noConflict=function(){return t.fn.directChat=r,this},t(document).on("click",e,(function(e){e&&e.preventDefault(),a.call(t(this),"toggle")}))}(jQuery),function(t){"use strict";var e={slimscroll:!0,resetHeight:!0},n=".wrapper",i=".content-wrapper",o=".layout-boxed",a=".main-footer",r=".main-header",s=".sidebar",l=".control-sidebar",c=".sidebar-menu",d=".main-header .logo",u="fixed",f="hold-transition",p=function(t){this.options=t,this.bindedResize=!1,this.activate()};function h(n){return this.each((function(){var i=t(this),o=i.data("lte.layout");if(!o){var a=t.extend({},e,i.data(),"object"==typeof n&&n);i.data("lte.layout",o=new p(a))}if("string"==typeof n){if(void 0===o[n])throw new Error("No method named "+n);o[n]()}}))}p.prototype.activate=function(){this.fix(),this.fixSidebar(),t("body").removeClass(f),this.options.resetHeight&&t("body, html, "+n).css({height:"auto","min-height":"100%"}),this.bindedResize||(t(window).resize(function(){this.fix(),this.fixSidebar(),t(d+", "+s).one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",function(){this.fix(),this.fixSidebar()}.bind(this))}.bind(this)),this.bindedResize=!0),t(c).on("expanded.tree",function(){this.fix(),this.fixSidebar()}.bind(this)),t(c).on("collapsed.tree",function(){this.fix(),this.fixSidebar()}.bind(this))},p.prototype.fix=function(){t(o+" > "+n).css("overflow","hidden");var e=t(a).outerHeight()||0,c=t(r).outerHeight()+e,d=t(window).height(),f=t(s).height()||0;if(t("body").hasClass(u))t(i).css("min-height",d-e);else{var p;d>=f?(t(i).css("min-height",d-c),p=d-c):(t(i).css("min-height",f),p=f);var h=t(l);void 0!==h&&h.height()>p&&t(i).css("min-height",h.height())}},p.prototype.fixSidebar=function(){t("body").hasClass(u)?this.options.slimscroll&&void 0!==t.fn.slimScroll&&(t(s).slimScroll({destroy:!0}).height("auto"),t(s).slimScroll({height:t(window).height()-t(r).height()+"px",color:"rgba(0,0,0,0.2)",size:"3px"})):void 0!==t.fn.slimScroll&&t(s).slimScroll({destroy:!0}).height("auto")};var g=t.fn.layout;t.fn.layout=h,t.fn.layout.Constuctor=p,t.fn.layout.noConflict=function(){return t.fn.layout=g,this},t(window).on("load",(function(){h.call(t("body"))}))}(jQuery),function(t){"use strict";var e={collapseScreenSize:767,expandOnHover:!1,expandTransitionDelay:200},n=".sidebar-collapse",i=".main-sidebar",o=".content-wrapper",a=".sidebar-form .form-control",r='[data-toggle="push-menu"]',s=".sidebar-mini",l=".sidebar-expanded-on-hover",c=".fixed",d="sidebar-collapse",u="sidebar-open",f="sidebar-expanded-on-hover",p="sidebar-mini-expand-feature",h="expanded.pushMenu",g="collapsed.pushMenu",m=function(t){this.options=t,this.init()};function v(n){return this.each((function(){var i=t(this),o=i.data("lte.pushmenu");if(!o){var a=t.extend({},e,i.data(),"object"==typeof n&&n);i.data("lte.pushmenu",o=new m(a))}"toggle"==n&&o.toggle()}))}m.prototype.init=function(){(this.options.expandOnHover||t("body").is(s+c))&&(this.expandOnHover(),t("body").addClass(p)),t(o).click(function(){t(window).width()<=this.options.collapseScreenSize&&t("body").hasClass(u)&&this.close()}.bind(this)),t(a).click((function(t){t.stopPropagation()}))},m.prototype.toggle=function(){var e=t(window).width(),n=!t("body").hasClass(d);e<=this.options.collapseScreenSize&&(n=t("body").hasClass(u)),n?this.close():this.open()},m.prototype.open=function(){t(window).width()>this.options.collapseScreenSize?t("body").removeClass(d).trigger(t.Event(h)):t("body").addClass(u).trigger(t.Event(h))},m.prototype.close=function(){t(window).width()>this.options.collapseScreenSize?t("body").addClass(d).trigger(t.Event(g)):t("body").removeClass(u+" "+d).trigger(t.Event(g))},m.prototype.expandOnHover=function(){t(i).hover(function(){t("body").is(s+n)&&t(window).width()>this.options.collapseScreenSize&&this.expand()}.bind(this),function(){t("body").is(l)&&this.collapse()}.bind(this))},m.prototype.expand=function(){setTimeout((function(){t("body").removeClass(d).addClass(f)}),this.options.expandTransitionDelay)},m.prototype.collapse=function(){setTimeout((function(){t("body").removeClass(f).addClass(d)}),this.options.expandTransitionDelay)};var y=t.fn.pushMenu;t.fn.pushMenu=v,t.fn.pushMenu.Constructor=m,t.fn.pushMenu.noConflict=function(){return t.fn.pushMenu=y,this},t(document).on("click",r,(function(e){e.preventDefault(),v.call(t(this),"toggle")})),t(window).on("load",(function(){v.call(t(r))}))}(jQuery),function(t){"use strict";var e={animationSpeed:500,accordion:!0,followLink:!1,trigger:".treeview a"},n=".treeview",i=".treeview-menu",o=".menu-open, .active",a='[data-widget="tree"]',r=".active",s="menu-open",l="tree",c="collapsed.tree",d="expanded.tree",u=function(e,i){this.element=e,this.options=i,t(this.element).addClass(l),t(n+r,this.element).addClass(s),this._setUpListeners()};function f(n){return this.each((function(){var i=t(this);if(!i.data("lte.tree")){var o=t.extend({},e,i.data(),"object"==typeof n&&n);i.data("lte.tree",new u(i,o))}}))}u.prototype.toggle=function(t,e){var o=t.next(i),a=t.parent(),r=a.hasClass(s);a.is(n)&&(this.options.followLink&&"#"!=t.attr("href")||e.preventDefault(),r?this.collapse(o,a):this.expand(o,a))},u.prototype.expand=function(e,n){var a=t.Event(d);if(this.options.accordion){var r=n.siblings(o),l=r.children(i);this.collapse(l,r)}n.addClass(s),e.slideDown(this.options.animationSpeed,function(){t(this.element).trigger(a)}.bind(this))},u.prototype.collapse=function(e,i){var a=t.Event(c);e.find(o).removeClass(s),i.removeClass(s),e.slideUp(this.options.animationSpeed,function(){e.find(o+" > "+n).slideUp(),t(this.element).trigger(a)}.bind(this))},u.prototype._setUpListeners=function(){var e=this;t(this.element).on("click",this.options.trigger,(function(n){e.toggle(t(this),n)}))};var p=t.fn.tree;t.fn.tree=f,t.fn.tree.Constructor=u,t.fn.tree.noConflict=function(){return t.fn.tree=p,this},t(window).on("load",(function(){t(a).each((function(){f.call(t(this))}))}))}(jQuery)},259:function(t,e){Date.prototype.format=function(t){var e={"M+":this.getMonth()+1,"d+":this.getDate(),"h+":this.getHours(),"m+":this.getMinutes(),"s+":this.getSeconds(),"q+":Math.floor((this.getMonth()+3)/3),S:this.getMilliseconds()};for(var n in/(y+)/.test(t)&&(t=t.replace(RegExp.$1,(this.getFullYear()+"").substr(4-RegExp.$1.length))),e)new RegExp("("+n+")").test(t)&&(t=t.replace(RegExp.$1,1==RegExp.$1.length?e[n]:("00"+e[n]).substr((""+e[n]).length)));return t},function(t){function e(n){var i=n.shift();if(null!=i){$self=t(i);var o=$self.data();$self.empty();var a={};if(null!=o.parentId&&o.param)a[o.param]=o.parentId;else if(o.parent&&o.param){var r=t(o.parent),s=t(r.data("parent"));r&&o.url&&null!=r.val()?a[o.param]=r.val():s&&o.url&&null!=s.val()&&(a[o.param]=s.val())}else alert("连级下拉框参数配置不正确:"+$self.attr("name"));(function(t){var e;for(e in t)return!0;return!1})(a)&&t.getJSON(o.url,a,(function(t){0==t.code&&($self.append(function(t,e){var n="";for(var i in t){var o=t[i];n+=i==e?"<option value='"+i+"' selected >"+o+"</option>":"<option value='"+i+"'>"+o+"</option>"}return n}(t.data,o.value)),e(n))}))}}function n(){e(t("select[data-linkage]").toArray())}t.fn.linkageSelect=function(){t(document).off("change.site.linkage"),n(),t(document).on("change.site.linkage","select[data-linkage]",(function(){e(t(t(this).data("queue")).toArray())}))}}(jQuery),function(t){function e(n){var i=this;n.data.timestamp=Math.round((new Date).getTime()/1e3),t.ajax({url:n.url,method:n.method,data:n.data,dataType:n.dataType,error:function(t,o,a){n.onTimeout.call(i,n,t,o,a),n.repeat&&setTimeout((function(){e.call(i,n)}),n.interval)},success:function(t,o){if("success"==o&&(n.onSuccess.call(i,t,o,n),n.repeat))var a=setTimeout((function(){e.call(i,n),clearTimeout(a)}),n.interval)}})}t.fn.longpoll=function(n){return this.each((function(){var i=t(this),o=t.extend({},t.fn.longpoll.Default,n,i.data());if(!0===o.now)e.call(i,o);else var a=setTimeout((function(){e.call(i,o),clearTimeout(a)}),n.interval)}))},t.fn.longpoll.Default={now:!0,interval:2e3,dataType:"text",method:"get",data:{},repeat:!0,onTimeout:t.noop,onSuccess:t.noop}}(jQuery),function(t){t.fn.batchLoad=function(e){return this.each((function(){var n=t(this),i=t.extend({},t.fn.batchLoad.Default,e,n.data()),o=n.attr("href"),a=o.indexOf("?")>-1;n.click((function(e){e.preventDefault();var n=t("input[name="+i.key+"\\[\\]]:checked").map((function(t,e){return e.value}));if(0==n.length)alert("请选择加载的条目，否则不能进行操作");else{var r=t.makeArray(n);o+=a?"&id="+r.join():"?id"+r.join(),t.get(o,(function(e){var n=t(i.modal);n.find(".modal-content").html(e),n.modal("show")}))}}))}))},t.fn.batchLoad.Default={key:"id",modal:"#modal-dialog"}}(jQuery),function(t){t.fn.listrowcd=function(e){return this.each((function(){var n=t(this),i=t.extend({},t.fn.listrowcd.Default,e,n.data());n.find(i.delBtn).click((function(e){e.preventDefault();var n=t(this).parents(i.row);n.fadeToggle("slow",(function(){n.remove()}))})),n.find(i.createBtn).click((function(e){e.preventDefault();t(this);var o=n.find(i.row),a=t(o[o.length-1]);a.clone(!0).insertAfter(a)}))}))},t.fn.listrowcd.Default={delBtn:".btn-del",createBtn:".btn-create",row:"tr"}}(jQuery),function(t){t.fn.dynamicline=function(e){return this.each((function(){var n=t(this),i=t.extend({},t.fn.dynamicline.DEF,e,n.data());n.on("click",".delete-self",(function(e){e.preventDefault();var o=t(this).parents(i.target);n.find(i.target).length>2&&o.remove()})).on("click",".copy-self",(function(e){e.preventDefault();var o=t(this).parents(i.target),a=o.clone();console.log(a),i.onCopy&&(a=i.onCopy.call(n,a)),a.insertAfter(o)}))}))},t.fn.dynamicline.DEF={onCopy:function(t){var e=this.data("index"),n=t.html().replace(/\[\d{1,}\]/gim,"["+e+"]").replace(/\-\d{1,}\-/gim,"-"+e+"-");return e+=1,this.data("index",e),t.html(n),t}}}(jQuery),function(t){"use strict";t.fn.sizeList=function(){return this.each((function(){var e=t(this),n=e.find("input[type=hidden]"),i=e.find("input[type=checkbox]");i.change((function(){for(var t=[],e=0;e<i.length;e++)i[e].checked&&t.push(i[e].value);n.val(t.join(","))}))}))}}(jQuery),function(t){"use strict";t.fn.selectBox=function(){return this.each((function(){var e=t(this).attr("id"),n=t("#"+e+"-source-search"),i=t("#"+e+"-target-search"),o=t("#"+e+"-source"),a=t("#"+e+"-target"),r=t("#"+e+"-btn-yes"),s=t("#"+e+"-btn-no");a.on("update",(function(){a.find("option").attr("selected",!0)})),n.keyup((function(){var e=n.val().trim();o.find("option").each((function(){var n=t(this);n.text().indexOf(e)<0?n.attr("selected",!1).css({display:"none"}):n.css({display:"block"})}))})),i.keyup((function(){var e=i.val().trim();a.find("option").each((function(){var n=t(this);n.text().indexOf(e)<0?n.attr("selected",!1).css({display:"none"}):n.css({display:"block"})})),a.trigger("update")})),r.click((function(){o.find("option:selected").appendTo(a),a.trigger("update")})),s.click((function(){a.find("option:selected").appendTo(o)})),a.trigger("update")}))}}(jQuery),$(document).on("click",".batch-update",(function(t){t.preventDefault();var e=$(this),n=e.data(),i=$(n.target),o=i.yiiGridView("data"),a=escape(o.selectionColumn),r=i.yiiGridView("getSelectedRows").map((function(t){return a+"="+escape(t)}));if(0==r.length)alert("请选择条目，否则不能进行操作");else{var s=new RegExp("&?"+a+"=[/a-zA-Z0-9]+","g"),l=e.data("url").replace(s,"");l=l+"&"+r.join("&"),console.log(l),e.attr("href",l),$("#modal-dialog").modal({remote:l})}})),$(document).on("click",".del-all",(function(t){t.preventDefault();var e=$(this),n=e.data(),i=$(n.target).yiiGridView("getSelectedRows");if(0==i.length)alert("请选择条目，否则不能进行操作");else{var o={};n.pk||(n.pk="id"),o[n.pk]=i,confirm("确认删除么？")&&$.ajax({method:"POST",url:e.attr("href"),data:o,success:function(t){window.location.reload()}})}})),$(document).on("submit",".enable-ajax-form form",(function(t){t.preventDefault();var e=$(t.target),n=e.parents("[data-pjax-container]");e.ajaxSubmit({headers:{"AJAX-SUBMIT":"AJAX-SUBMIT"},success:function(t){var e="error";if("success"==t.status){if(n){var i=n.attr("id");$.pjax.reload("#"+i)}e="success"}notif({type:e,msg:t.message,position:"center",timeout:3e3})}})})),$(document).on("click","[data-sync]",(function(t){t.preventDefault();var e=$(this);$.post(e.attr("href"),(function(t){if("success"==t.status){var n=e.parents("[data-pjax-container]");if(n){var i=n.attr("id");null!=i&&$.pjax.reload("#"+i)}}}))}))},260:function(t,e){function n(t){return(n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}!function(t){"use strict";var e='[data-toggle="duajaxupload"]',i=function(n,i,o){var a=this;this.options=i,this.$element=t(n),this.formData=new FormData,this.$fileInput=this.$element.find('input[type="file"]'),this.$fileInput.attr("accept",i.accept),this.$textInput=this.$element.find('input[type="text"]'),this.$previewImage=this.$element.find(".image-preview img"),this.$realUploadBtn=o||this.$element.find(e);this.$element.on("click",'[data-dismiss="duajaxupload"]',(function(){a.close()}));this.$fileInput.on("change",(function(t){var e,n;a.file=t.currentTarget.files[0],a.extension=(e=a.file.name,n=e.lastIndexOf("."),e.substr(n+1)),"image"==a.file.type.substr(0,5)?(a.$dialog=a.$element.find(".cropper-dialog"),a.$imageBox=a.$element.find(".cropper-image-box"),a.$area=a.$dialog.find(".cropper-area"),a.showCropper(),a.$dialog.show()):(a.formData.set("file",a.file),a.uploadFile())}));this.$element.on("click",'[data-upload="duajaxupload"]',(function(e){if(a.$realUploadBtn=t(this),a.$cropper){var n=a.$cropper.cropper("getCroppedCanvas");a.options.compress&&(n=a.compress(n)),n.toBlob((function(t){a.formData.set("file",t,a.file.name),a.uploadFile()}))}else a.formData.set("file",a.file),a.uploadFile();a.close()}))};function o(e){return this.each((function(){var o=t(this),a=o.data("bs.duAjaxUpload");if(!a){var r=t.extend({},i.DEFAULTS,o.data(),"object"==n(e)&&e);o.data("bs.duAjaxUpload",a=new i(this,r))}"string"==typeof e&&a[e].call(a)}))}i.DEFAULTS={clip:!0,imageHeight:300,imageWidth:300,compress:!0,accept:"image/*"},i.prototype.compress=function(t){var e=document.createElement("canvas"),n=e.getContext("2d");return e.width=this.options.imageWidth,e.height=this.options.imageHeight,n.clearRect(0,0,e.width,e.height),n.drawImage(t,0,0,e.width,e.height),e},i.prototype.uploadFile=function(){var e=this;e.$realUploadBtn&&(t(e.$realUploadBtn).button("上传中..."),console.log(t(e.$realUploadBtn)),console.log("uploading ..."));var n=this.$textInput.attr("data-type"),i=this.$textInput.attr("data-token-url");t.get(i,{fileType:n},(function(n){var i=n.key+"."+e.extension;e.formData.set(DUA.uploader.keyName,i),e.formData.set(DUA.uploader.tokenName,n.token),t.ajax({url:DUA.uploader.uploadUrl,dataType:"json",type:"POST",async:!1,data:e.formData,processData:!1,contentType:!1,success:function(t){console.log(t),alert("上传成功！");var n=DUA.uploader.baseUrl+i;e.$textInput.val(n),e.$fileInput.val(""),e.$previewImage.attr("src",n),e.$realUploadBtn&&e.$realUploadBtn.button("reset")},error:function(t){alert(t.responseJSON.message),e.$realUploadBtn&&e.$realUploadBtn.button("reset")}})}))},i.prototype.showCropper=function(){var e=this,n=new FileReader;n.addEventListener("load",(function(){if(e.img=new Image,e.img.src=this.result,e.$imageBox.html(e.img),e.options.clip){var n=(e.options.imageWidth/e.options.imageHeight).toFixed(2);e.$cropper=t(e.img).cropper({aspectRatio:n})}})),n.readAsDataURL(this.file)},i.prototype.selectFile=function(){this.$fileInput.trigger("click")},i.prototype.close=function(){this.$dialog&&(this.$fileInput.val(""),this.$dialog.hide())};var a=t.fn.duAjaxUpload;t.fn.duAjaxUpload=o,t.fn.duAjaxUpload.Constructor=i,t.fn.duAjaxUpload.noConflict=function(){return t.fn.duAjaxUpload=a,this};t(document).on("click.bs.duajaxupload.data-api",e,(function(e){e.preventDefault();var n=t(this).parents('[data-role="duajaxupload"]');o.call(n,"selectFile",t(this))}))}(jQuery)}});