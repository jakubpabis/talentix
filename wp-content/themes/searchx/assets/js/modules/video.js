/************
 *
 * Video Module
 *
 ***********/

(($) => {
	$(function () {
		let video = $("body").find("video");

		video.each(function () {
			let $this = $(this);
			let $pause_btn = $this.siblings(".video-pause-btn");
			let $is_poster_video = $this.hasClass("video-poster");

			if ($this.length > 0) {
				//Skip if modal video
				if ($pause_btn.attr("data-src") === undefined) {
					$pause_btn.on("click keypress", function (e) {
						e.preventDefault();
						$(this).addClass("re-position");

						if (!$this[0].paused) {
							$this[0].pause();
							$(this).addClass("user-stopped");
							$(this).find("i").removeClass("fa-pause");
							$(this).find("i").addClass("fa-play");
						} else {
							// Obsługa Promise dla mobilnych przeglądarek
							const playPromise = $this[0].play();
							if (playPromise !== undefined) {
								playPromise
									.then(() => {
										$(this).find("i").removeClass("fa-play");
										$(this).find("i").addClass("fa-pause");
									})
									.catch((error) => {
										console.warn("Autoplay prevented:", error);
										// Nie zmieniaj ikon jeśli play() się nie powiódł
									});
							}
						}
					});
				}
			}

			if ($is_poster_video) {
				$pause_btn.on("click keypress", function (e) {
					$this.hide();
					$this.siblings("video").show();
				});
			}
		});

		let mql_handler = (mql) => {
			if (mql.matches) {
				//desktop
				let $videos = $("video");

				if ($videos.length < 1) {
					return;
				}

				$videos.each(function () {
					let $this = $(this);

					let mp4 = $this.attr("data-mp4");
					if (typeof mp4 != "undefined" && mp4.length > 0) {
						$this.append("<source src=" + mp4 + ' type="video/mp4">');
					}
					let webm = $this.attr("data-webm");
					if (typeof webm != "undefined" && webm.length > 0) {
						$this.append("<source src=" + webm + ' type="video/webm">');
					}
					let src = $this.attr("data-src");
					if (typeof src != "undefined" && src.length > 0) {
						let fileExt = src.split(".").pop();
						$this.append(
							"<source src=" + src + ' type="video/' + fileExt + '">'
						);
					}
				});
			}
		};

		// POPRAWKA: Dodano konkretny media query dla desktopów
		var mql = window.matchMedia("(min-width: 768px)");

		// POPRAWKA: Użycie addEventListener zamiast addListener
		if (mql.addEventListener) {
			mql.addEventListener("change", mql_handler);
		} else {
			// Fallback dla starszych przeglądarek (iOS 13)
			mql.addListener(mql_handler);
		}

		mql_handler(mql);

		// Funkcja sprawdzająca widoczność wideo
		function handleVideoScroll($video) {
			const videoElement = $video.get(0);
			const windowHeight = $(window).height();
			const scrollTop = $(window).scrollTop();
			const videoOffset = $video.offset().top;
			const videoHeight = $video.outerHeight();
			const videoMiddle = videoOffset + videoHeight / 2; // POPRAWKA: Użycie połowy wysokości
			let $this = $video;
			let $pause_btn = $this.siblings(".video-pause-btn");

			// Sprawdź, czy środek wideo znajduje się w widocznym obszarze
			if (videoMiddle > scrollTop && videoMiddle < scrollTop + windowHeight) {
				if (videoElement.paused && !$pause_btn.hasClass("user-stopped")) {
					// POPRAWKA: Obsługa Promise dla autoplay
					const playPromise = videoElement.play();
					if (playPromise !== undefined) {
						playPromise
							.then(() => {
								$pause_btn.addClass("re-position");
								$pause_btn.find("i").removeClass("fa-play");
								$pause_btn.find("i").addClass("fa-pause");
							})
							.catch((error) => {
								// Autoplay zablokowany - typowe na mobilnych urządzeniach
								console.warn("Autoplay prevented on scroll:", error);
							});
					}
				}
			} else {
				if (!videoElement.paused) {
					videoElement.pause();
					$pause_btn.addClass("re-position");
					$pause_btn.find("i").removeClass("fa-pause");
					$pause_btn.find("i").addClass("fa-play");
				}
			}
		}

		// Obsługa przewijania i zmiany rozmiaru okna dla wybranych filmów
		$(window).on("scroll resize", function () {
			$(
				'.video-track[data-scroll-play="true"], .video-track[data-scroll-play="1"]'
			).each(function () {
				handleVideoScroll($(this));
			});
		});
	});
})(jQuery);
