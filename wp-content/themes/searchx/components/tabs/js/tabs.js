(($) => {
	$(function () {
		$(".tabs__nav-link").on("click touch", function () {
			if ($(window).width() < 576) {
				if ($(this).parent().parent().hasClass("open")) {
					if (!$(this).parent().hasClass("active")) {
						$(this).parent().parent().find(".nav-item").removeClass("active");
						$(this).parent().addClass("active");
						$(this)
							.parent()
							.parent()
							.removeClass("open")
							.find(".tabs__nav-link")
							.removeClass("d-block")
							.removeClass("position-relative");
					} else {
						$(this)
							.parent()
							.removeClass("active")
							.parent()
							.removeClass("open")
							.find(".tabs__nav-link")
							.removeClass("d-block")
							.removeClass("position-relative");
					}
				} else {
					if ($(this).hasClass("active")) {
						$(this)
							.parent()
							.parent()
							.addClass("open")
							.find(".tabs__nav-link")
							.addClass("d-block")
							.addClass("position-relative");
					}
				}
			}
		});
	});
})(jQuery);
