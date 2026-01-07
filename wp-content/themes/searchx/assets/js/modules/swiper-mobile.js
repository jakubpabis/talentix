/************
 *
 * Swiper Mobile
 *
 ***********/

(($) => {

	$(function() {

		$.fn.swiperMobile = function() {
			return this.each(function() {
				let $this = $(this);
				let $container = $this.find('[data-mobile="swiper-container"]');
				let $wrapper = $container.find('[data-mobile="swiper-wrapper"]');
				let $slides = $container.find('[data-mobile="swiper-slide"]');

				let orig_container_classes = $container.attr('class');
				let orig_row_classes = $wrapper.attr('class');
				let orig_col_classes = $slides.attr('class');

				let keepSlideClasses = $this.data('mobile-slide-keep-class');
				keepSlideClasses = (typeof keepSlideClasses !== 'undefined') ? true : false;

				let mq_desktop = () => {
					if( $container.length > 0 ) {
						$container.attr('class', orig_container_classes);
						$wrapper.attr('class', orig_row_classes);
						if(keepSlideClasses === true){
							$slides.removeClass('swiper-slide');
						}else {
							$slides.attr('class', orig_col_classes);
						}
						$container.find('.swiper-pagination').remove();
						if( $container[0].swiper ){
							$container[0].swiper.destroy(true, true);
						}
					}
				};

				let mq_mobile = ( ) => {
					if( $container.length > 0 ) {
						$container.attr('class', 'swiper-container');
						$wrapper.attr('class', 'swiper-wrapper');
						if(keepSlideClasses === true){
							$slides.addClass('swiper-slide');
						}else {
							$slides.attr('class', 'swiper-slide');
						}
						$container.append('<div class="swiper-pagination"></div>');

						var id =  $container.attr('id');
						if ($container.find('.swiper-slide').length) {
							var opts = {
								setWrapperSize : true,
								spaceBetween : 20,
								slidesPerView: 1.2,
								slidesOffsetBefore: 20,
								slidesOffsetAfter: 20,
								speed: 1000,
								watchOverflow: true,
								watchSlidesVisibility: true,
								navigation: {
									nextEl: '#'+id+' .swiper-button-next',
									prevEl: '#'+id+' .swiper-button-prev',
								},
								pagination: {
									el: '#'+id+' .swiper-pagination',
									clickable: true,
								}
							};
							new Swiper($container, opts);
						}
					}
				};

				let mql_handler = (mql) => {
					if ( mql.matches ) {
						//desktop
						mq_desktop();
					} else {
						//mobile
						mq_mobile();
					}
				};

				//Media query listener for swapping desktop/mobile functionality
				var mql = window.matchMedia("(min-width: 576px)");
				mql.addListener(mql_handler);
				mql_handler(mql);
			});
		};

		$('[data-mobile="swiper"]').swiperMobile();

	});

})(jQuery);
