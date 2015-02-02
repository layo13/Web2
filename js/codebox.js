(function ($) {

	$.fn.newTab = function () {
		$(this).click(function (e) {
			window.open(this.href);
			e.preventDefault();
		});
	};

}(jQuery));