/************
 *
 * Counters Component
 *
 ***********/

import { CountUp } from "countup.js";
import { debounce } from "debounce";

(($) => {
	$(function () {
		$.fn.isInViewport = function () {
			var elementTop = $(this).offset().top;
			var elementBottom = elementTop + $(this).outerHeight();
			var viewportTop = $(window).scrollTop();
			var viewportBottom = viewportTop + $(window).height();

			return elementBottom > viewportTop && elementTop < viewportBottom;
		};

		var didCounters = false;

		function doCounters() {
			if (didCounters === true) {
				return;
			}
			$(".counters__number").each(function () {
				var defaults = {
					startVal: 0,
					duration: 2,
					useEasing: false,
					useGrouping: false,
					separator: ",",
					decimal: ".",
					decimalPlaces: 0,
				};
				var $this = $(this),
					id = $this.attr("id"),
					number = $this.data("counter-number"),
					config = $this.data("config");

				var options = $.extend(true, defaults, config);
				var counter = new CountUp(id, number, options);

				var startCounter = debounce(function () {
					if ($this.isInViewport()) {
						if (!counter.error) {
							counter.start();
							didCounters = true;
						} else {
							console.error(counter.error);
						}
					}
				}, 100);

				window.addEventListener("scroll", startCounter);
				startCounter();
			});
		}

		doCounters();
		let i = setInterval(function () {
			let e = $("#editor .interface-interface-skeleton__content");
			if (e.length > 0) {
				let c = $(".counters__number");
				if (c.length > 0) {
					e.on("scroll", doCounters);
					clearInterval(i);
				}
			}
		}, 10);
	});
})(jQuery);
