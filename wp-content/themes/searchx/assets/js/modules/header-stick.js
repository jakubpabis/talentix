(($) => {
	$(function () {
		const blennd_header_stick = function () {
			let didScroll;
			let lastScrollTop = 0;
			const delta = 5;
			const navbarHeight = $("header.header-primary").outerHeight() * 0.5;
			const $header = $("header.header-primary");

			$(window).scroll(function () {
				didScroll = true;
			});

			setInterval(function () {
				if (didScroll) {
					hasScrolled();
					didScroll = false;
				}
			}, 250);

			const blennd_header_add_stick = function () {
				$header
					.addClass("stick")
					.stop()
					.delay(100)
					.queue(function () {
						$(this).addClass("slide-in");
					});
			};

			const blennd_header_remove_stick = function () {
				$header.removeClass("slide-in").removeClass("stick");
			};

			function hasScrolled() {
				var st = $(window).scrollTop();
				// Make sure they scroll more than delta
				if (Math.abs(lastScrollTop - st) <= delta) {
					return;
				}

				if (st > lastScrollTop && st > navbarHeight) {
					// Scroll down
					blennd_header_remove_stick();
				} else {
					if (st + $(window).height() < $(document).height()) {
						// Scroll up
						blennd_header_add_stick();

						// Scroll up to top
						if (st <= navbarHeight) {
							blennd_header_remove_stick();
						}
					}
				}

				lastScrollTop = st;
			}
		};

		blennd_header_stick();
	});
})(jQuery);
