(($) => {
	$(function () {
		const blennd_header_shadow = function () {
			const $header = $("header.header-primary");
			$(window).on("scroll", function () {
				if ($(window).scrollTop() > 50) {
					if (!$header.hasClass("shadow-sm")) {
						$header.addClass("shadow-sm").addClass("smaller");
					}
				} else {
					if ($header.hasClass("shadow-sm")) {
						$header.removeClass("shadow-sm").removeClass("smaller");
					}
				}
			});
		};

		blennd_header_shadow();
	});
})(jQuery);
