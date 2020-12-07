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

/**
 * 视频自适应窗口
 */
$(document).ready(function(){

	function calcVideoSize(){
		$('.ifra-video, .iframe-video').each(function(){
			var _this = $(this);
			var parent = _this.parent();
			var p_width = parent.width();
			var s_width = _this.attr('width');
			var width = p_width> 510?s_width:p_width;
			var height = width* 488/866;
			_this.attr('width');
			_this.attr('width',width);
			_this.attr('height',height);
		});
	}
	calcVideoSize();
	$(window).on('resize onorientationchange',calcVideoSize);

	$('.nav-affix').affix({
	  offset: {
	    top: 50,
	    bottom: function() {
	      return (this.bottom = $('.footer').outerHeight(true))
	    }
	  }
	}).on('affixed.bs.affix',function(){
		$(this).removeClass('navbar-inverse')
		.addClass('navbar-default');
	}).on("affixed-top.bs.affix",function(){
		$(this).removeClass('navbar-default')
		.addClass('navbar-inverse');
	})
});