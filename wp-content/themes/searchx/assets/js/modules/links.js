(($) => {

	$(function() {

		$('.wrapped-link').hover(function(){
			$(this).find('[class*="__link"]').toggleClass('hover');
		});

	});

})(jQuery);
