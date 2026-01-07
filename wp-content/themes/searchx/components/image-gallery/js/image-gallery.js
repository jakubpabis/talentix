/************
 *
 * Image Gallery Component
 *
 ***********/

(($) => {

	$(function() {
		$('.image-gallery .grid').each(function (){
			new Masonry( $(this)[0], {
				itemSelector: '.grid-item',
				columnWidth: '.grid-item',
				gutter: '.grid-gutter',
				transitionDuration: '0.15s',
				percentPosition: true,
				stagger: 10,
				horizontalOrder: true
			});
		});
	});

})(jQuery);
