(($) => {
	$(function() {
		$('.component').prepend('<button class="light-dark-toggle"><span class="fa-solid fa-circle-half-stroke"></span></button>');
		$('.light-dark-toggle').click(function(){
			const theme = 'data-bs-theme';
			let $parent = $(this).parent();
			let current = $parent.attr(theme);
			let next;
			if( 'light' === current ) {
				next = 'dark';
			}
			else {
				next = 'light';
			}
			$parent.attr(theme,next);
		});
	});
})(jQuery);
