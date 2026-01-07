(($) => {
	$(function () {
		if ($(".sb-wall").length > 0) {
			$(window).on("load", function () {
				$(document)
					.find(".sbsw-item")
					.each(function () {
						const $link = $(this).find(".sbsw-follow").find("a").attr("href");
						const $linkOld = $(this).find(".sbsw-item-media").find("a");
						$linkOld.removeAttr("data-lightbox-info");
						$linkOld.removeAttr("data-sbsw-lightbox");
						$linkOld.attr("href", $link);
						$linkOld.attr("target", "_blank");
					});
			});
		}
	});
})(jQuery);
