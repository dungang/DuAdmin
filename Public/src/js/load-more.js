/**
 * 加载更多
 */
+function($) {

	var style="width: 100%;padding: 15px;margin-bottom: 15px;border: 1px solid #ffc6d1;border-radius: 3px;background-color: #ffe0e5;color: #FE2E54;"
	function scrollOnBottom() {
		var scrollHeight = Math.ceil($(document).scrollTop());
		var windowHeight = $(window).height();
		var documentHeight = $(document).height();
		return scrollHeight + windowHeight >= documentHeight;
	}

	var spinnner = $('<div class="text-center col-xs-12" style="'+style+'"><i class="fa fa-spinner"></i> 加载中...</div>');
	var noMessage = $('<div class="text-center col-xs-12"style="'+style+'"> 没有更多了 </div>')

	$.fn.scrolloader = function(options) {

		return this.each(function() {
			var _this = $(this);
			var totalPages = parseInt(options.totalPages);
			$(window).scroll(function() {
				var page = parseInt(_this.attr('data-page') || 2);
				var status = _this.attr('data-status') || 'off';
				var isBottom = scrollOnBottom();
				var data = options.data || {};
				if (status == 'off' && isBottom && totalPages >= page) {
					_this.after(spinnner);
					data.page = page;
					_this.attr('data-page', page + 1);
					_this.attr('data-status', 'on');
					var timer = setTimeout(function() {
						$.get(options.url, data, function(data) {
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
	}
}(jQuery);