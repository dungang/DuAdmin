/**
 * 联动选择下拉框 data-parent-id //默认上级值 data-parent //上级对象，和 parent-id二选一 data-url
 * //加载数据的地址 data-param //加载数据的参数 data-value //默认初始值，并不代表事最终逻辑值 data-queue
 * //顺序执行的对象队列
 */
+ function ($) {

	function isNotEmptyObject(e) {
		var t;
		for (t in e)
			return true;
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
		if (select == null)
			return;
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
	}
}(jQuery);

+
function ($) {

	function process(options) {
		var _this = this;
		options.data['timestamp'] = Math.round(new Date().getTime() / 1000);
		$.ajax({
			url: options.url,
			method: options.method,
			data: options.data,
			dataType: options.dataType,
			error: function (xhr, textStatus, errorThrown) {
				options.onTimeout.call(_this, options, xhr, textStatus, errorThrown);
				if (options.repeat) {
					setTimeout(function () {
						process.call(_this, options)
					}, options.interval);
				}
			},
			success: function (data, textStatus) {
				if (textStatus == "success") { // 请求成功
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
		now: true, //是否立刻执行
		interval: 2000,
		dataType: 'text',
		method: 'get',
		data: {},
		repeat: true,
		onTimeout: $.noop,
		onSuccess: $.noop
	};
}(jQuery);

+
function ($) {
	$.fn.batchProcess = function (options) {
		return this.each(function () {
			var _this = $(this);
			var modeOpts = {};
			switch (options.mode) {
				case 'delete':
				case 'quiet':
					modeOpts.contentType = 'application/json; charset=UTF-8';
					modeOpts.dataType = 'json';
					break;
				default:

			}
			var opts = $.extend({}, $.fn.batchProcess.Default, modeOpts, options, _this.data());

			var url = _this.attr('href');
			var hasQuery = url.indexOf('?') > -1;
			_this.click(function (e) {
				e.preventDefault();
				if (opts.needConfirm == false || confirm(opts.confirm)) {
					var _chkboxs = $('input[name=' + opts.key + '\\[\\]]:checked');
					var idObjs = _chkboxs.map(function (idx, obj) {
						return obj.value;
					});

					if (idObjs.length == 0) {
						alert(opts.noSelectedMsg);
					} else {
						var ids = $.makeArray(idObjs);
						if (hasQuery) {
							url += '&id=' + ids.join();
						} else {
							url += '?id' + ids.join();
						}

						$.ajax({
							url: url,
							method: opts.method,
							data: _this.data('param'),
							dataType: opts.dataType,
							contentType: opts.contentType,
							success: function (response) {
								switch (opts.mode) {
									case 'delete':
										if (response.code == '200') {
											_chkboxs.each(function () {
												var tr = $(this).parents(opts.row);
												tr.fadeToggle('slow', function () {
													tr.remove();
													opts.onSuccess.call(_this, response, _chkboxs);
												});
											});
										}
										break;
									case 'modal':
										var modal = $(opts.modal);
										modal.find('.modal-content').html(response);
										modal.modal('show');
										opts.onSuccess.call(_this, response, _chkboxs);
										break;
									default:
										opts.onSuccess.call(_this, response, _chkboxs);
								}
							}
						});
					}
				}
			});
		});
	};
	$.fn.batchProcess.Default = {
		key: 'id',
		row: 'tr',
		noSelectedMsg: '请选择条目，否则不能进行操作',
		confirm: '确定删除？',
		needConfirm: true,
		method: 'POST',
		mode: 'delete',
		modal: '#modal-dailog',
		onSuccess: $.noop
	};
}(jQuery); +
function ($) {
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
		modal: '#modal-dailog'
	};
}(jQuery);

+
function ($) {
	/**
	 * Create or Delete a Row of List
	 */
	$.fn.listrowcd = function (options) {
		return this.each(function () {
			var _this = $(this);
			var opts = $.extend({}, $.fn.listrowcd.Default, options, _this.data());
			// delete button
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
		row: 'tr',
	};
}(jQuery);



var App = {
	extendSimpleModal: function (modalSelector) {
		var modal = $(modalSelector);
		modal.on('hidden.bs.modal', function (e) {
			// 清空对象
			$(e.target).data('bs.modal', null);
		});
		modal.on('show.bs.modal', function (e) {
			var size = $(e.relatedTarget).data('modal-size');
			$(e.target).find('.modal-dialog').removeClass('modal-sm modal-lg').addClass(size ? size : '');
		});
	}
};

var baiduTextAudio = new Audio();

function speckText(url) {
	//var url = "http://tts.baidu.com/text2audio?lan=zh&ctp=1&ie=UTF-8&vol=9&per=0&spd=4&pit=5&aue=3&&text=" + encodeURI(str);
	baiduTextAudio.src = url;
	baiduTextAudio.play();
}

+
function ($) {
	function replaceIndex(clone){
		var regexID = /\-\d{1,}\-/gmi;
		var regexName = /\[\d{1,}\]/gmi;
		var size = this.data('index');
		var html = clone.html().replace(regexName,'['+size+']').replace(regexID,'-'+size+'-');
		size = size + 1;
		this.data('index',size);
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
				if(opts.onCopy) {
					clone = opts.onCopy.call(_container,clone);
				}
				clone.insertAfter(target_obj);
			})
		});
	};
	
	$.fn.dynamicline.DEF = {
		onCopy: replaceIndex
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
            var sourceSearchInput = $('#'+id+'-source-search');
            var targetSearchInput = $('#'+id+'-target-search');
            var sourceSelect = $('#'+id+'-source');
            var targetSelect = $('#'+id+'-target');
            var yesButton = $('#'+id+'-btn-yes');
            var noButton = $('#'+id+'-btn-no');

            targetSelect.on('update',function () {
                targetSelect
                    .find('option')
                    .attr('selected',true);
            });

            sourceSearchInput.keyup(function () {
                var filter = sourceSearchInput.val().trim();
                sourceSelect.find('option').each(function () {
                    var _option = $(this);
                    if (_option.text().indexOf(filter) < 0) {
                        _option.attr('selected',false)
                            .css({display:'none'});
                    } else {
                        _option.css({display:'block'});
                    }
                });
            });

            targetSearchInput.keyup(function () {
                var filter = targetSearchInput.val().trim();
                targetSelect.find('option').each(function () {
                    var _option = $(this);
                    if (_option.text().indexOf(filter) < 0) {
                        _option.attr('selected',false)
                            .css({display:'none'});
                    } else {
                        _option.css({display:'block'});
                    }
                });
                targetSelect.trigger('update');
            });

            yesButton.click(function () {
                sourceSelect
                    .find('option:selected')
                    .appendTo(targetSelect);
                targetSelect.trigger('update');
            });

            noButton.click(function () {
                targetSelect
                    .find('option:selected')
                    .appendTo(sourceSelect);
            });

            targetSelect.trigger('update');

        });
    };

}(jQuery);