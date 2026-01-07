(($) => {
	$(function () {
		AOS.init({
			duration: 600,
			once: true,
			easing: "ease-in-out",
		});
		$(window).on("load", function () {
			AOS.refresh();
		});
		$(window).on("resize", function () {
			AOS.refresh();
		});
	});
})(jQuery);
