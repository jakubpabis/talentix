(($) => {
	$(function () {
		let mobile_menu_open = false;
		let search_open = false;
		const $header = $(".header-primary");
		const $menu_btn = $("header button.mobile-menu-button");
		const $nav = $("header .menu-wrapper");
		const $nav_primary_li = $(".menu > li > a, #footer-menu-mobile > li > a");
		const $sub_menu_btn_click = $(
			".menu li.menu-item-has-children > .arrow-down-mobile, #footer-menu-mobile li.menu-item-has-children > .arrow-down-mobile"
		);
		const $mobile_overlay = $(".mobile-overlay");
		const $sub_menu_btn_hover = $(".menu li.menu-item-has-children > a"); // mobile menu sub-menu open with dropdown-hover
		const $search_btn = $("header .search-icon");
		const desktop_only_width = 1199; // make sure this matches $header_breakpoint_desktop on header.scss
		const toggle_dropdown_menu_class = "open-sub-menu";
		const toggle_dropdown_body_class = "desktop-dropdown-open";

		// close the click menu
		const header_sub_menu_hide = function () {
			$nav_primary_li
				.parent("li.menu-item-has-children")
				.removeClass(toggle_dropdown_menu_class);
			$nav_primary_li
				.parent("li.menu-item-has-children")
				.find("> a i")
				.removeClass("fa-chevron-up")
				.addClass("fa-chevron-down");
			$nav_primary_li.attr("aria-expanded", "false");
			$("body").removeClass(toggle_dropdown_body_class);
		};

		// open the click menu
		const header_sub_menu_show = function (element) {
			let $element = $(element);
			let $parent_li = $element.parent("li.menu-item-has-children");
			// hide all the other ones
			$parent_li.siblings().removeClass(toggle_dropdown_menu_class);

			// handle this item open/close
			if ($parent_li.hasClass(toggle_dropdown_menu_class)) {
				$parent_li.removeClass(toggle_dropdown_menu_class);
			} else if (!$parent_li.hasClass(toggle_dropdown_menu_class)) {
				$parent_li.addClass(toggle_dropdown_menu_class);
			}

			// if is the mega nav
			if ($element.parent("li").hasClass("dropdown-mega")) {
				// trigger body open class
				$("body").addClass(toggle_dropdown_body_class);
			}
			// if not the mega nav
			if ($element.parent("li").hasClass("dropdown-relative")) {
				// trigger body open class
				$("body").removeClass(toggle_dropdown_body_class);
			}
			// if the same link has been clicked twice...
			if (!$parent_li.hasClass(toggle_dropdown_menu_class)) {
				$parent_li.removeClass(toggle_dropdown_menu_class);
				$("body").removeClass(toggle_dropdown_body_class);
			}
		};

		const header_mobile_show = function ($element) {
			$element.find("i").removeClass("fa-bars").addClass("fa-close");
			$("body").addClass("nav-open");
			mobile_menu_open = true;
		};

		const header_mobile_hide = function ($element) {
			$element.find("i").removeClass("fa-close").addClass("fa-bars");
			$("body").removeClass("nav-open");
			mobile_menu_open = false;
		};

		const header_search_hide = function () {
			$(".header-search-dropdown").removeClass("search-open");
			$(".header-search-dropdown").find(".search-input").blur();
			search_open = false;
		};

		const header_search_show = function () {
			$(".header-search-dropdown").addClass("search-open");
			$(".header-search-dropdown").find(".search-input").focus();
			search_open = true;
		};

		const header_sub_menu_hover = function () {
			$sub_menu_btn_hover.hover(function () {
				// header_sub_menu_hide();
				header_search_hide();
			});
		};

		const blennd_search = function () {
			$search_btn.on("click touch", function (e) {
				e.preventDefault();
				if (search_open === false) {
					header_search_show();
					header_sub_menu_hide();
				} else {
					header_search_hide();
				}
			});
		};

		const blennd_header = function () {
			// mobile menu and resizing
			$(window).on("resize", function () {
				if (
					$(this).width() < desktop_only_width &&
					$nav.hasClass("keep-open")
				) {
					$nav.removeClass("keep-open").hide();
				}
				if (
					$menu_btn.is(":hidden") &&
					$nav.is(":hidden") &&
					$(window).width() > desktop_only_width - 1
				) {
					$nav.addClass("keep-open").show();
				}
				if ($(this).width() >= desktop_only_width) {
					header_sub_menu_hover();
					header_mobile_hide($menu_btn);
				}
			});

			// mobile menu button
			$menu_btn.on("click touch", function () {
				if (mobile_menu_open === false) {
					header_mobile_show($(this));
					header_search_hide();
				} else {
					header_mobile_hide($(this));
				}
			});

			// sub menu button click
			$sub_menu_btn_click.on("click touch", function (e) {
				e.preventDefault();
				e.stopPropagation();
				console.log($(this));
				header_search_hide();
				if (!$(this).parent().hasClass("open-sub-menu")) {
					header_sub_menu_show($(this).parent().find("> a"));
				} else {
					header_sub_menu_hide();
				}
			});

			// sub menu button click mobile
			// $sub_menu_btn_hover_mobile.on("click touch", function () {
			// 	header_sub_menu_hide();
			// 	header_search_hide();
			// 	if (!$(this).parent().hasClass("open-sub-menu")) {
			// 		console.log($(this).parent());
			// 		header_sub_menu_show($(this));
			// 	} else {
			// 		//console.log($(this).parent());
			// 		header_sub_menu_hide($(this));
			// 	}
			// });

			$mobile_overlay.on("click touch", function () {
				header_mobile_hide($(this));
			});

			$sub_menu_btn_hover.on("mouseenter", function () {
				if ($(window).width() > desktop_only_width) {
					header_sub_menu_hide();
					header_sub_menu_show(this);
					header_search_hide();
				}
			});

			$header.on("mouseleave", function () {
				if ($(window).width() > desktop_only_width) {
					header_sub_menu_hide();
				}
			});

			// sub menu button hover focus
			$sub_menu_btn_hover.focusin(function () {
				header_sub_menu_show(this);
			});

			// desktop hover close other li's open
			if ($(window).width() >= desktop_only_width) {
				header_sub_menu_hover();
				header_mobile_hide($menu_btn);
			}

			//disable header clases if main is clicked
			$(document).on("click touch", "main, footer", function () {
				header_sub_menu_hide();
				header_search_hide();
			});
		};

		blennd_header();
		blennd_search();
	});
})(jQuery);
