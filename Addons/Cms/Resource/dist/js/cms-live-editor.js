!function(t){var e={};function i(o){if(e[o])return e[o].exports;var n=e[o]={i:o,l:!1,exports:{}};return t[o].call(n.exports,n,n.exports,i),n.l=!0,n.exports}i.m=t,i.c=e,i.d=function(t,e,o){i.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:o})},i.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},i.t=function(t,e){if(1&e&&(t=i(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var o=Object.create(null);if(i.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var n in t)i.d(o,n,function(e){return t[e]}.bind(null,n));return o},i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},i.p="/",i(i.s=196)}({196:function(t,e,i){i(197),i(323),i(325),i(327),i(329),i(331),i(333),i(335),i(337),i(339),i(341),t.exports=i(343)},197:function(t,e){function i(t){return(i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function o(t,e){return function(t){if(Array.isArray(t))return t}(t)||function(t,e){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var i=[],o=!0,n=!1,l=void 0;try{for(var r,a=t[Symbol.iterator]();!(o=(r=a.next()).done)&&(i.push(r.value),!e||i.length!==e);o=!0);}catch(t){n=!0,l=t}finally{try{o||null==a.return||a.return()}finally{if(n)throw l}}return i}(t,e)||function(t,e){if(!t)return;if("string"==typeof t)return n(t,e);var i=Object.prototype.toString.call(t).slice(8,-1);"Object"===i&&t.constructor&&(i=t.constructor.name);if("Map"===i||"Set"===i)return Array.from(i);if("Arguments"===i||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(i))return n(t,e)}(t,e)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function n(t,e){(null==e||e>t.length)&&(e=t.length);for(var i=0,o=new Array(e);i<e;i++)o[i]=t[i];return o}!function(t){"use strict";var e=".du-live-layout, .du-live-element, .du-placeholder",n=function(e,i){var o=this;this.insertModel="none",this.options=i,this.$element=t(e),this.$liveBlock=null,this.$toolbar=t('<div class="du-live-editor-toolbar" contenteditable="false"><div class="du-live-move"><i class="fa fa-arrows"></i></div><div class="du-live-del"><i class="fa fa-trash-o"></i></div><div class="du-live-edit"><i class="fa fa-edit"></i></div><div class="du-live-animate"><i class="fa fa-magic"></i></div><div class="du-live-add-bef"><i class="fa fa-plus"></i> 前</div><div class="du-live-add-aft"><i class="fa fa-plus"></i> 后</div><div class="du-live-setting"><i class="fa fa-gear"></i></div></div>'),this.$ligter=t('<div class="du-live-lighter"></div>'),this.initControlDraggable(),this.initOperation(),this.initBlockStyleForm(),this.$iframe=t("#live-iframe"),this.$iframe.on("load",(function(){o.loadIframe()}))};n.DEFAULTS={sortable:{placeholder:"ui-state-highlight",handle:".du-live-move",cursorAt:{top:0,left:0},receive:function(t,e){n.loadBlockCode(e.helper,e.helper)}}},n.WysiwygEditor={isActive:!1,oldValue:"",doc:!1,init:function(e){this.doc=e,t("#bold-btn").on("click",(function(t){return e.execCommand("bold",!1,null),t.preventDefault(),!1})),t("#italic-btn").on("click",(function(t){return e.execCommand("italic",!1,null),t.preventDefault(),!1})),t("#underline-btn").on("click",(function(t){return e.execCommand("underline",!1,null),t.preventDefault(),!1})),t("#strike-btn").on("click",(function(t){return e.execCommand("strikeThrough",!1,null),t.preventDefault(),!1})),t("#link-btn").on("click",(function(t){var i=prompt("URL","请输入请求地址");return i&&e.execCommand("createLink",!1,i),t.preventDefault(),!1})),t("#unlink-btn").on("click",(function(t){return e.execCommand("unlink",!1,null),t.preventDefault(),!1})),t("#fore-color").on("change blur",(function(t){return e.execCommand("foreColor",!1,this.value),t.preventDefault(),!1})),t("#back-color").on("change blur",(function(t){return e.execCommand("hiliteColor",!1,this.value),t.preventDefault(),!1})),t("#font-size").on("change",(function(t){return e.execCommand("fontSize",!1,this.value),t.preventDefault(),!1})),t("#font-familly").on("change",(function(t){return e.execCommand("fontName",!1,this.value),t.preventDefault(),!1})),t("#justify-btn a").on("click",(function(t){var i="justify"+this.dataset.value;return e.execCommand(i,!1,"#"),t.preventDefault(),!1}))},edit:function(e){e.attr({contenteditable:!0,spellcheckker:!1}),t("#wysiwyg-editor").show(),this.element=e,this.isActive=!0,this.oldValue=e.html()},destroy:function(e){e.removeAttr("contenteditable spellcheckker"),t("#wysiwyg-editor").hide(),this.isActive=!1}},n.prototype.initOperation=function(){var e=this;t(document).on("click","#du-live-editor-save-button",(function(t){t.preventDefault(),e.saveContent()})),t(document).on("click","#du-live-editor-toushi-button",(function(t){t.preventDefault(),e.$liveContent.toggleClass("toushi")})),t(document).on("click","#du-live-editor-empty-button",(function(t){t.preventDefault(),e.$liveContent.empty(),e.appendPlaceHolder(e.$liveContent)}))},n.prototype.loadIframe=function(){var i=this;this.$iframeDoc=this.$iframe.contents(),this.$iframeHtml=this.$iframeDoc.find("html"),this.$iframeBody=this.$iframeDoc.find("body"),n.WysiwygEditor.init(this.$iframeDoc[0]),this.$liveContent=this.$iframeDoc.find(".live-content"),this.$liveContent.sortable(this.options.sortable),this.$sortableContainer=this.$liveContent,this.initElementPlaceHolder(),this.$liveContent.find(".du-live-editor-toolbar").remove(),this.initToolbar(this.$iframeDoc),this.$ligter.appendTo(this.$iframeBody).hide(),t(this.$iframeDoc).on("click",e,(function(e){e.stopPropagation();var o=t(this);i.setActiveLiveBlock(o)})).on("scroll",(function(t){i.locateToolbar()}))},n.prototype.initToolbar=function(e){var i=this;this.$delCtrl=t(e).on("click",".du-live-del",(function(t){t.stopPropagation(),i.deleteLiveBlock()})),this.$editCtrl=t(e).on("click",".du-live-edit",(function(e){e.stopPropagation(),i.insertModel="none",t("aside").hide(),t(this).toggleClass("active"),i.editLiveBlock()})),this.$addBefCtrl=t(e).on("click",".du-live-add-bef",(function(e){e.stopPropagation(),i.insertModel="before",t("aside").show()})),this.$addAftCtrl=t(e).on("click",".du-live-add-aft",(function(e){e.stopPropagation(),i.insertModel="after",t("aside").show()})),this.$settingCtrl=t(e).on("click",".du-live-setting",(function(e){e.stopPropagation(),i.insertModel="none",t("aside").hide(),t("#du-live-block-setting-dialog").modal("show"),i.initBlockStyleFormData()})),this.$settingCtrl=t(e).on("click",".du-live-animate",(function(e){e.stopPropagation(),i.insertModel="none",t("aside").hide(),t("#du-live-block-animate-dialog").modal("show"),i.initBlockAnimateFormData()})),this.$toolbar.appendTo(this.$iframeBody).hide()},n.prototype.initBlockAnimateForm=function(){var e=this;t("#du-live-block-animate-dialog").on("click",".btn-primary",(function(i){i.preventDefault();var o={};t("#style-animate-form").serializeArray().forEach((function(t){t.value.length>0&&(o[t.name]=t.value.trim())})),e.$liveBlock.css(o),t(this).modal("hide")}))},n.prototype.initBlockAnimateFormData=function(){this.$liveBlock&&t("#style-animate-form input").each((function(){t(this).attr("name")}))},n.prototype.initBlockStyleForm=function(){var e=this;t("#du-live-block-setting-dialog").on("click",".btn-primary",(function(i){i.preventDefault();var o={};t("#style-setting-form").serializeArray().forEach((function(t){t.value.length>0&&(o[t.name]=t.value.trim())})),e.$liveBlock.css(o),t(this).modal("hide")}))},n.prototype.initBlockStyleFormData=function(){if(this.$liveBlock){var e=this.$liveBlock.attr("style").split(";").map((function(t){return t.split(":")})).reduce((function(t,e){var i=o(e,2),n=i[0],l=i[1];return t[n=n.replace(/-./g,(function(t){return t.toUpperCase()[1]}))]=l,t}),{});t("#style-setting-form input").each((function(){var i=t(this),o=i.attr("name");e[o]&&i.val(e[o])}))}},n.loadBlockCode=function(e,i){t.get("/admin.php?r=cms/live-editor/load-code&id="+i.data("id"),(function(t){e.replaceWith(t)}))},n.prototype.initControlDraggable=function(){var e=this,i="click.live-editor.select-elem.insert";t(document).off(i).on(i,".du-live-editor-elements-control .du-layout,.du-live-editor-elements-control .du-element",(function(i){i.preventDefault();var o=t(this);if(e.$liveBlock.hasClass("du-live-layout")&&!o.hasClass("du-layout"))return alert("请选择布局元素，此时不能选择静态元素"),!1;t.get("/admin.php?r=cms/live-editor/load-code&id="+o.data("id"),(function(i){if("before"==e.insertModel){var o=t(i);e.$liveBlock.before(o),e.clearPlaceHolder(),e.focusActiveBlock(e.findBlock(o))}else if("after"==e.insertModel){o=t(i);e.$liveBlock.after(o),e.clearPlaceHolder(),e.focusActiveBlock(e.findBlock(o))}}))}))},n.prototype.findBlock=function(t){return t.find("div:eq(0)")},n.prototype.clearPlaceHolder=function(){this.$sortableContainer&&this.$sortableContainer.find(">.du-placeholder").remove()},n.prototype.focusActiveBlock=function(t){this.setActiveLiveBlock(t);var e=this.$liveBlock.offset();if(e&&e.top){var i=e.top-200;this.$iframe[0].contentWindow.scroll(0,i)}},n.prototype.activeLiveBlockParentSortable=function(){this.$sortableContainer&&this.$sortableContainer.sortable("destroy"),this.$sortableContainer=this.$liveBlock.parent(),this.$sortableContainer.length>0&&this.$sortableContainer.sortable(this.options.sortable)},n.prototype.setActiveLiveBlock=function(e){var i=this;if(this.insertModel="none",t("aside").hide(),this.$liveBlock){if(e.is(this.$liveBlock))return;this.$liveBlock.off("dblclick"),this.$liveBlock.removeClass("active"),this.disableTextEdit(this.$liveBlock),this.$liveBlock=null}this.$liveBlock=e,this.$liveBlock.on("dblclick",(function(e){e.stopPropagation();var o=t(this).parent(".du-live-layout");o&&i.setActiveLiveBlock(o)})),this.locateToolbar(),this.$liveBlock.addClass("active"),this.activeLiveBlockParentSortable()},n.prototype.locateToolbar=function(){if(this.$liveBlock&&this.$liveBlock.length>0){var t=this.$liveBlock.offset(),e=t.top-26;this.$toolbar.css({top:e+"px",left:t.left}).show(),console.log(t)}},n.prototype.editLiveBlock=function(){if(this.$liveBlock&&this.$liveBlock.length>0)if("A"==this.$liveBlock[0].tagName){var t=prompt("请输入url",this.$liveBlock.attr("href"));t&&this.$liveBlock.attr("href",t)}else if(this.$liveBlock.hasClass("img-holder"))this.enableEditImageBg(this.$liveBlock);else if("none"!=this.$liveBlock.css("backgroundImage"))this.enableEditImageBg(this.$liveBlock);else{var e=this.$liveBlock.find(">img");e.length>0?this.enableEditImage(e):null!=this.$liveBlock.attr("contentEditable")?(console.log(this.$liveBlock.attr("contentEditable")),this.disableTextEdit(this.$liveBlock)):this.enableTextEdit(this.$liveBlock)}},n.prototype.disableTextEdit=function(e){var i=t(e);this.$editCtrl.removeClass("active"),i.removeAttr("contentEditable"),n.WysiwygEditor.destroy(e)},n.prototype.enableTextEdit=function(e){var i=t(e);this.$editCtrl.addClass("active"),n.WysiwygEditor.edit(e),i.attr("contentEditable","true")},n.prototype.enableEditImage=function(e){var i=e.attr("src"),o=t("#du-live-image-setting-dialog"),n=o.find("input[type=text]");n.val(i);var l=o.find(".confirm-btn");l.off("click"),l.on("click",(function(){e.attr("src",n.val()),o.modal("hide")})),o.modal("show")},n.prototype.enableEditImageBg=function(e){var i=/url\(['"]{0,1}(.*?)['"]{0,1}\)/i.exec(e.css("backgroundImage")),o="";i&&(o=i[1].replace(window.location.origin,""));var n=t("#du-live-image-setting-dialog"),l=n.find("input[type=text]");l.val(o);var r=n.find(".confirm-btn");r.off("click"),r.on("click",(function(){e.css("backgroundImage","url("+l.val()+")"),n.modal("hide")})),n.modal("show")},n.prototype.deleteLiveBlock=function(){this.$toolbar.hide();var t=this.$liveBlock.parent(".du-live-element-layout");(0==t.length&&(t=this.$liveBlock.parent(".live-content"),console.log(t)),this.$liveBlock.remove(),this.$liveBlock=null,t.length>0)&&(0==t.find(e).length&&this.appendPlaceHolder(t))},n.prototype.initElementPlaceHolder=function(){this.$liveContent.find(".du-live-element-layout").each((function(){var e=t(this);0==e[0].children.length&&this.appendPlaceHolder.appendTo(e)})),0==this.$liveContent[0].children.length&&this.appendPlaceHolder(this.$liveContent)},n.prototype.appendPlaceHolder=function(e){t('<div class="du-placeholder"></div>').appendTo(e)},n.prototype.saveContent=function(){this.$toolbar.appendTo(this.$element),this.$liveBlock&&this.$liveBlock.removeClass("active");var e={content:this.$liveContent.html()};e[yii.getCsrfParam()]=yii.getCsrfToken();var i="/admin.php?r=cms/live-editor/save&pageId="+this.options.pageId+"&language="+this.options.language;t.post(i,e,(function(t){alert("success")}))};var l=t.fn.liveEditor;t.fn.liveEditor=function(e){var o=arguments;return this.each((function(){var l=t(this),r=l.data("bs.live-editor"),a=t.extend({},n.DEFAULTS,l.data(),"object"==i(e)&&e);r||l.data("bs.live-editor",r=new n(this,a)),"string"==typeof e&&r[e].call(r,o[1])}))},t.fn.liveEditor.Constructor=n,t.fn.liveEditor.noConflict=function(){return t.fn.liveEditor=l,this},t(".du-live-editor").liveEditor()}(jQuery)},323:function(t,e){},325:function(t,e){},327:function(t,e){},329:function(t,e){},331:function(t,e){},333:function(t,e){},335:function(t,e){},337:function(t,e){},339:function(t,e){},341:function(t,e){},343:function(t,e){}});