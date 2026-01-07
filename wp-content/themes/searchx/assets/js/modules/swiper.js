/************
 *
 * Swiper Module
 *
 ***********/

(($) => {
	$(function () {
		$(".swiper").each(function () {
			var $this = $(this);
			var id = $this.attr("id");

			// Get the json encoded config attribute with swiper options
			var config = $this.data("config");

			var doPartialSlide = function () {
				if (this.params.slidesPerView % 1 !== 0) {
					let partialSlideIndex =
						this.activeIndex + (Math.ceil(this.params.slidesPerView) - 1);
					$this.find(".swiper-slide").removeClass("swiper-slide-partial");
					$(this.slides[partialSlideIndex]).addClass("swiper-slide-partial");
				} else {
					$this.find(".swiper-slide").removeClass("swiper-slide-partial");
				}
			};

			if ($this.find(".swiper-slide").length > 0) {
				// Set up the default options
				var defaults = {
					setWrapperSize: true,
					slidesPerView: 1,
					slidesPerGroup: 1,
					autoplay: false,
					spaceBetween: 0,
					allowTouchMove: true,
					watchOverflow: true,
					watchSlidesVisibility: true,
					navigation: {
						nextEl: "#" + id + " .swiper-button-next",
						prevEl: "#" + id + " .swiper-button-prev",
					},
					pagination: {
						el: "#" + id + " .swiper-pagination",
						clickable: true,
					},
					breakpointsInverse: true,
					breakpoints: {
						768: {
							slidesPerView: 2,
							allowTouchMove: false,
						},
						1020: {
							slidesPerView: 3,
							allowTouchMove: false,
						},
					},
					on: {
						init: function () {
							doPartialSlide.call(this);
						},
						slideChangeTransitionStart: function () {
							doPartialSlide.call(this);
						},
						breakpoint: function () {
							doPartialSlide.call(this);
						},
						reachEnd: function () {
							$(this.slides[this.slides.length - 1]).removeClass(
								"swiper-slide-partial"
							);
						},
						fromEdge: function () {
							$(this.slides[this.slides.length - 1]).addClass(
								"swiper-slide-partial"
							);
						},
					},
				};
				// Overwrite the default options with the dynamic config variable
				var opts = $.extend(true, defaults, config);
				new Swiper("#" + id, opts);
			}
		});
	});
})(jQuery);
