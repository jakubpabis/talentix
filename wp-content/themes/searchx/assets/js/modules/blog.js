(($) => {
	$(function () {
		const the_tag = function (tag, html, atts) {
			let attsString = "";
			for (const [key, value] of Object.entries(atts)) {
				if ("" !== attsString) {
					attsString += " ";
				}
				attsString += `${key}="${value}"`;
			}
			return `<${tag} ${attsString}>${html}</${tag}>`;
		};

		const do_pagination = function (pagination) {
			// Remove existing pagination
			$(".page-numbers").remove();

			// If only one page, hide pagination
			if (pagination.totalPages <= 1) {
				$(".pagination").hide();
				return;
			}

			// Show pagination
			$(".pagination").show();

			// Previous page link
			if (pagination.page > 1) {
				let prev = parseInt(pagination.page) - 1;
				let html =
					'<i class="far fa-xl fa-arrow-left-long"></i> <span class="sr-only">Previous</span>';
				let atts = {
					href:
						window.location.origin +
						window.location.pathname +
						"page/" +
						prev +
						"/",
					class: "prev page-numbers",
				};
				if (typeof pagination.categories !== "undefined") {
					atts["data-category"] = pagination.categories;
				}
				$(".pagination .nav-links").append(the_tag("a", html, atts));
			}

			// Pagination logic
			const total = parseInt(pagination.totalPages);
			const current = parseInt(pagination.page);
			const maxPages = 7; // Total pages to display
			const sidePages = 2; // Pages to show on each side of current page

			// Determine page range
			let start = Math.max(1, current - sidePages);
			let end = Math.min(total, current + sidePages);

			// Adjust start and end to maintain consistent number of pages
			if (end - start + 1 < maxPages) {
				if (current <= sidePages) {
					end = Math.min(total, maxPages);
				} else if (current > total - sidePages) {
					start = Math.max(1, total - maxPages + 1);
				}
			}

			// First page and ellipsis
			if (start > 1) {
				// First page
				let atts = {
					href: window.location.origin + window.location.pathname + "page/1/",
					class: "page-numbers",
				};
				if (typeof pagination.categories !== "undefined") {
					atts["data-category"] = pagination.categories;
				}
				$(".pagination .nav-links").append(the_tag("a", 1, atts));

				// Ellipsis
				if (start > 2) {
					$(".pagination .nav-links").append(
						the_tag("span", "...", { class: "page-numbers dots" })
					);
				}
			}

			// Render page numbers
			for (let page = start; page <= end; page++) {
				let atts = {
					href:
						window.location.origin +
						window.location.pathname +
						"page/" +
						page +
						"/",
					class: "page-numbers",
				};

				let tag = "a";
				if (page === current) {
					tag = "span";
					delete atts.href;
					atts["aria-current"] = "page";
				}
				if (typeof pagination.categories !== "undefined") {
					atts["data-category"] = pagination.categories;
				}
				$(".pagination .nav-links").append(the_tag(tag, page, atts));
			}

			// Last page and ellipsis
			if (end < total) {
				// Ellipsis
				if (end < total - 1) {
					$(".pagination .nav-links").append(
						the_tag("span", "...", { class: "page-numbers dots" })
					);
				}

				// Last page
				let atts = {
					href:
						window.location.origin +
						window.location.pathname +
						"page/" +
						total +
						"/",
					class: "page-numbers",
				};
				if (typeof pagination.categories !== "undefined") {
					atts["data-category"] = pagination.categories;
				}
				$(".pagination .nav-links").append(the_tag("a", total, atts));
			}

			// Next page link
			if (current < total) {
				let next = parseInt(current) + 1;
				let html =
					'<span class="sr-only">Next</span> <i class="far fa-arrow-right-long fa-xl"></i>';
				let atts = {
					href:
						window.location.origin +
						window.location.pathname +
						"page/" +
						next +
						"/",
					class: "next page-numbers",
				};
				if (typeof pagination.categories !== "undefined") {
					atts["data-category"] = pagination.categories;
				}
				$(".pagination .nav-links").append(the_tag("a", html, atts));
			}
		};

		const wp_get_ajax = function (url) {
			fetch(url)
				.then((response) => {
					// Ensure pagination headers exist
					const paginationHeader = response.headers.get("x-pagination");
					const totalPagesHeader = response.headers.get("x-wp-totalpages");

					if (!paginationHeader || !totalPagesHeader) {
						throw new Error("Pagination headers are missing");
					}

					// Parse pagination
					let pagination = JSON.parse(paginationHeader);
					pagination.totalPages = parseInt(totalPagesHeader);

					// Validate content type
					const contentType = response.headers.get("content-type");
					if (!contentType || !contentType.includes("application/json")) {
						throw new TypeError("Oops, we haven't got JSON!");
					}

					return response.json().then((data) => ({ data, pagination }));
				})
				.then(({ data, pagination }) => {
					// Clear existing cards
					$(".archive__row--cards .col").remove();

					// Render new cards
					data.forEach(function (post) {
						$(".archive__row--cards").append(post.card.rendered);
					});

					// Handle pagination
					if (pagination.totalPages > 1) {
						$(".pagination").show();
						do_pagination(pagination);
					} else {
						$(".pagination").hide();
					}
				})
				.catch((error) => console.error(error));
		};

		const parse_url = function (page = "1", taxonomy = "") {
			let url =
				window.location.origin +
				"/wp-json/wp/v2/" +
				pagination.postType +
				"/?page=" +
				page +
				"&per_page=" +
				pagination.postsPerPage;
			if (taxonomy != 0) {
				url = url + "&" + pagination.taxonomy + "=" + taxonomy;
			}
			return url;
		};

		$(document).ready(function () {
			if (typeof pagination !== "undefined") {
				do_pagination(pagination);
			}

			$("[data-blog-view]").on("click", function (e) {
				e.preventDefault();
				let $this = $(this),
					activeClass = "archive-filter-view__button--active",
					view = $this.data("blog-view"),
					$feedEl = $(".archive-feed");

				// If the view is already active, dont continue
				if ($this.hasClass(activeClass)) return;

				//Update the active class on the toggle buttons
				$("[data-blog-view]").removeClass(activeClass);
				$this.addClass(activeClass);

				// Add or remove the list view class to the blog-feed element
				if (view === "list") {
					$feedEl.addClass("archive-feed--list-view");
				} else if (view === "grid") {
					$feedEl.removeClass("archive-feed--list-view");
				}
			});

			$(".archive-filter-taxonomy__anchor").on("click", function (e) {
				if (typeof pagination == "undefined" || pagination.page != 1) {
					return;
				}

				e.preventDefault();

				$(this)
					.closest(".archive-filter-taxonomy__menu")
					.find(".archive-filter-taxonomy__anchor")
					.removeClass("archive-filter-taxonomy__anchor--active");
				$(this).addClass("archive-filter-taxonomy__anchor--active ");

				let value = $(this).attr("data-category");
				let url = parse_url(1, value);
				wp_get_ajax(url);
			});

			$(document).on("click", ".page-numbers", function (e) {
				if (typeof pagination == "undefined") {
					return;
				}
				e.preventDefault();

				let value = $(this).attr("data-category");
				let page;

				$(this)
					.attr("href")
					.split("/")
					.forEach(function (element, index, array) {
						if ("page" === element) {
							page = array[index + 1];
						}
					});

				let url = parse_url(page, value);
				wp_get_ajax(url);

				$(this)
					.closest(".archive")
					.get(0)
					.scrollIntoView({ behavior: "smooth" });
			});
		});
	});
})(jQuery);
