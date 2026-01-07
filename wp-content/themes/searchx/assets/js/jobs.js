jQuery(document).ready(function ($) {
	const $lang = document.documentElement.lang;
	function getUrlParameter(name) {
		var results = new RegExp("[\\?&]" + name + "=([^&#]*)").exec(
			window.location.href
		);
		return results ? results[1] : null;
	}
	let currentPage = 1;
	let loading = false;
	let noMorePosts = false;

	const formattedNumber = (number) =>
		number.toString().replace(/\d(?=(\d{3})+$)/g, "$&.");

	// Load initial job content if URL has job ID
	const urlParams = new URLSearchParams(window.location.search);
	const initialJobId = urlParams.get("job_id");
	if (initialJobId) {
		loadJobContent(initialJobId);
	}

	// Job item click handler
	$(document).on("click", ".job-item", function () {
		const jobId = $(this).data("job-id");
		loadJobContent(jobId);

		// Update URL without page refresh
		const newUrl = new URL(window.location);
		newUrl.searchParams.set("job_id", jobId);
		window.history.pushState({}, "", newUrl);

		// Add active class
		$(".job-item").removeClass("active");
		$(this).addClass("active");
	});

	// Infinite scroll
	$(window).on("scroll", function () {
		if (loading || noMorePosts) return;

		const scrollHeight = $("#jobs-list")[0].scrollHeight;
		const scrollPosition = $(this).height() + $(this).scrollTop();

		if (scrollHeight - scrollPosition <= 500) {
			loadMoreJobs();
		}
	});

	$(window).on("load resize", function () {
		const jobId = getUrlParameter("job_id");
		if ($(window).width() < 992) {
			if (
				$(".job-content-container-scroll").prev(".jobs-list").length > 0 &&
				jobId
			) {
				$(".job-content-container-scroll").insertAfter(
					$('.job-item[data-job-id="' + jobId + '"]')
				);
			}
		} else {
			if (!$(".job-content-container-scroll").prev(".jobs-list").length > 0) {
				$(".job-content-container-scroll").insertAfter($(".jobs-list"));
			}
		}
	});

	$(window).on("load", function () {
		const jobId = getUrlParameter("job_id");
		if (jobId) {
			setTimeout(function () {
				$('.job-item[data-job-id="' + jobId + '"]').addClass("active");
				document.querySelector(".job-content-container-scroll").scrollIntoView({
					behavior: "smooth",
					block: "start", //scroll to top of the target element
				});
			}, 200);
		}
	});

	function logAjaxError(xhr, status, error) {
		console.log("AJAX Error:", {
			status: status,
			error: error,
			responseText: xhr.responseText,
		});
	}

	function loadMoreJobs() {
		if (loading) return;
		loading = true;

		// Show loading state
		let $loadingText = $lang === "nl-NL" ? "" : "Loading...";
		$("#jobs-list").append(
			'<div class="loading-indicator text-center"><i class="fa-solid fa-spinner fa-spin-pulse"></i><span class="sr-only">' +
				$loadingText +
				"</span></div>"
		);

		const search =
			$("#jobs-search").val() !== ""
				? $("#jobs-search").val()
				: $("#jobs-search-mobile").val() !== ""
				? $("#jobs-search-mobile").val()
				: "";
		const filters = {};
		const order = {};

		// Collect all filter values
		$(".job-filter").each(function () {
			const taxonomy = $(this).data("taxonomy");
			const value = $(this).find("li.active").data("value");
			if (value) {
				filters[taxonomy] = value;
			}
		});

		$(".job-location").each(function () {
			const taxonomy = $(this).data("taxonomy");
			const value = $(this).val();
			if (value) {
				filters[taxonomy] = value;
			}
		});

		$(".jobs-ordering").each(function () {
			const $by = $(this).find("li.active").data("by");
			const $order = $(this).find("li.active").data("order");
			if ($order) {
				order[$by] = $order;
			}
		});

		// // Log the data being sent (for debugging)
		// console.log("Sending AJAX request with data:", {
		// 	action: "load_more_jobs",
		// 	nonce: jobsAjax.nonce,
		// 	page: currentPage,
		// 	search: search,
		// 	filters: filters,
		// 	order: order,
		// });

		$.ajax({
			url: jobsAjax.ajaxurl,
			type: "POST",
			data: {
				action: "load_more_jobs",
				nonce: jobsAjax.nonce,
				page: currentPage,
				search: search,
				filters: filters,
				order: order,
			},

			success: function (response) {
				console.log(response.data);
				// Remove loading indicator
				$(".loading-indicator").remove();
				if ($("#jobs-search").val() !== "") {
					$(".jobs-header-search-query").text($("#jobs-search").val());
					$(".jobs-header").removeClass("d-none");
				} else if ($("#jobs-search-mobile").val() !== "") {
					$(".jobs-header-search-query").text($("#jobs-search-mobile").val());
					$(".jobs-header").removeClass("d-none");
				} else {
					$(".jobs-header").addClass("d-none");
				}

				const count = response.data[0].count;
				if (currentPage < 2) {
					$(".jobs-list-count > .number").html(count);
				}
				response.data.shift();
				if (response.success && response.data.length > 0) {
					response.data.forEach(function (job) {
						const jobHtml = `
                            <div class="job-item mb-6" data-job-id="${job.id}">
                                <div class="job-item-content py-md-5 py-4 ps-md-7 ps-4 pe-md-14 pe-13">
									<span class="lead fw-bold mt-0">${job.title}</span>
									<div class="job-meta small d-flex flex-column">
										${
											job.salaryMin || job.salaryMax
												? `<div class="job-meta-item"><i class="meta-icon me-3 icon-job-salary"></i>${
														job.salaryMin
															? "€ " + formattedNumber(job.salaryMin)
															: ""
												  }&nbsp;&nbsp;-&nbsp;&nbsp;${
														job.salaryMax
															? "€ " + formattedNumber(job.salaryMax)
															: ""
												  }</div>`
												: ""
										}
										${Object.entries(job.meta)
											.map(
												([key, value]) =>
													`<div class="job-meta-item"><i class="meta-icon me-3 icon-${key}"></i>${value}</div>`
											)
											.join("")}
									</div>
									<div class="job-meta-right py-md-5 py-4 pe-md-7 pe-4">
										<a href="#" class="job-like d-none">
											<i class="fa-regular fa-heart"></i>
										</a>
										<div class="job-date">
											${job.date}
										</div>
									</div>
								</div>
								<a href="${job.permalink}" class="hidden-href"></a>
                            </div>
                        `;
						if (!$('[data-job-id="' + job.id + '"]').length > 0) {
							$("#jobs-list").append(jobHtml);
						}
					});
					currentPage++;
				} else {
					noMorePosts = true;

					let countText =
						$lang === "nl-NL"
							? "Geen vacatures gevonden..."
							: "No jobs found...";
					if (currentPage > 1) {
						countText =
							$lang === "nl-NL"
								? "Geen vacatures meer gevonden..."
								: "No more jobs found...";
					}
					$("#jobs-list").append(
						`<div class="no-results p-4 text-center">${countText}</div>`
					);
				}
				loading = false;
			},
			error: function (xhr, status, error) {
				// Remove loading indicator
				$(".loading-indicator").remove();

				// Log the error
				logAjaxError(xhr, status, error);

				// Show error message to user
				let $errorText =
					$lang === "nl-NL"
						? "Fout bij het laden van de vacatures. Probeer het nog een keer..."
						: "Error loading jobs. Please try again...";
				$("#jobs-list").append(
					`
						<div class="error-message p-4 mb-4 text-red-600">
								${$errorText}
						</div>
					`
				);
				loading = false;
			},
		});
	}

	// Filter change handler with debounce
	let filterTimeout;
	$(".job-filter > li").on("click", function () {
		$(this).parent().parent().prev().text($(this).text());
		$(this).parent().find("li").removeClass("active");
		$(this).addClass("active");
		clearTimeout(filterTimeout);
		filterTimeout = setTimeout(function () {
			// Clear current jobs
			$("#jobs-list").empty();
			// Reset pagination
			currentPage = 1;
			noMorePosts = false;
			// Load filtered jobs
			loadMoreJobs();
		}, 300);
	});

	$(".clear-filter").on("click", function () {
		$(this).parent().prev().text($(this).data("default"));
		$(this).prev().find("li").removeClass("active");
		clearTimeout(filterTimeout);
		filterTimeout = setTimeout(function () {
			// Clear current jobs
			$("#jobs-list").empty();
			// Reset pagination
			currentPage = 1;
			noMorePosts = false;
			// Load filtered jobs
			loadMoreJobs();
		}, 300);
	});

	$(".jobs-ordering > li").on("click", function () {
		$(this).parent().prev().text($(this).find("a").text());
		$(this).parent().find("li").removeClass("active");
		$(this).addClass("active");
		clearTimeout(filterTimeout);
		filterTimeout = setTimeout(function () {
			// Clear current jobs
			$("#jobs-list").empty();
			// Reset pagination
			currentPage = 1;
			noMorePosts = false;
			// Load filtered jobs
			loadMoreJobs();
		}, 300);
	});

	// Search input handler with debounce
	let searchTimeout;
	$("#jobs-search, #jobs-search-mobile, #jobs-location").on(
		"input",
		function (e) {
			clearTimeout(searchTimeout);
			searchTimeout = setTimeout(function () {
				// Clear current jobs
				$("#jobs-list").empty();
				// Reset pagination
				currentPage = 1;
				noMorePosts = false;
				// Load filtered jobs
				let url = new URL(window.location);
				if ($(e.target).attr("id") === "jobs-location") {
					url.searchParams.set("l_query", $(e.target).val());
				} else {
					url.searchParams.set("s_query", $(e.target).val());
				}
				window.history.pushState({}, "", url);
				loadMoreJobs();
			}, 500);
		}
	);

	// Initial load
	loadMoreJobs();

	function loadJobContent(jobId) {
		let $loadingText = $lang === "nl-NL" ? "Laden..." : "Loading...";
		let $applyText = $lang === "nl-NL" ? "Easy Apply" : "Easy Apply";
		let $whatsappText =
			$lang === "nl-NL"
				? "Stel een vraag via WhatsApp"
				: "Ask a question via WhatsApp";
		let $callText =
			$lang === "nl-NL" ? "Plan een call met" : "Plan a call with";
		let $resumeText =
			$lang === "nl-NL"
				? "Wil je zien hoe je matcht?<br/>Upload vandaag nog je cv."
				: "Want to see how you match up?<br/>Upload your resume today.";
		let $errorText =
			$lang === "nl-NL"
				? "Fout bij het laden van vacature-inhoud…"
				: "Error loading job content...";
		let $uploadText =
			$lang === "nl-NL"
				? "Solliciteer voor deze functie"
				: "Apply for this job";
		$("#job-content").html(
			'<div class="text-center"><i class="fa-solid fa-spinner fa-spin-pulse"></i><span class="sr-only">' +
				$loadingText +
				"</span></div>"
		);

		$.ajax({
			url: jobsAjax.ajaxurl,
			type: "POST",
			data: {
				action: "load_job_content",
				nonce: jobsAjax.nonce,
				job_id: jobId,
			},
			success: function (response) {
				if (response.success) {
					const job = response.data;
					let recruiter = "";
					$("#job-content-meta").html(`
                        <div class="d-flex justify-content-between mb-xxl-4 mb-2 align-items-start">
							<h6 class="m-0 job-content-title">${job.title}</h6>
							<button type="button" data-bs-toggle="modal" data-bs-target="#jobAppModal" data-jobtitle="${
								job.title
							}" data-jobid="${
						job.jobID
					}" class="btn btn-sm btn-tertiary"><i class="fa-solid fa-bolt me-2 ms-0"></i>${$applyText}</button>
						</div>
						<div class="d-flex justify-content-between align-items-stretch">
							<div class="job-meta small d-flex flex-wrap flex-grow-1">
								${
									job.salaryMin || job.salaryMax
										? `<div class="job-meta-item w-auto me-7"><i class="meta-icon me-3 icon-job-salary"></i>${
												job.salaryMin
													? "€ " + formattedNumber(job.salaryMin)
													: ""
										  }&nbsp;&nbsp;-&nbsp;&nbsp;${
												job.salaryMax
													? "€ " + formattedNumber(job.salaryMax)
													: ""
										  }</div>`
										: ""
								}
								${Object.entries(job.meta)
									.map(
										([key, value]) =>
											`<div class="job-meta-item w-auto me-7"><i class="meta-icon me-3 icon-${key}"></i>${value}</div>`
									)
									.join("")}
							</div>
							<div class="job-meta-right">
								<div class="job-date text-nowrap">
									${job.date}
								</div>

							</div>
						</div>
					`);
					$("#job-content").html(`
                        <div class="job-content small">${job.content}</div>
                    `);
					if (job.recruiter.photo) {
						const r_phone = job.recruiter.phone
							? `<a class="text-nowrap nowrap fw-semibold text-secondary py-1" href="tel:${job.recruiter.phone}"><i class="fa-regular fa-phone"></i> <span class="small ms-2 d-xl-inline-block d-lg-none">${job.recruiter.phone}</span></a>`
							: "";
						const r_whatsapp = job.recruiter.whatsapp
							? `<a class="text-nowrap nowrap fw-semibold text-success py-lg-1" href="${job.recruiter.whatsapp}"><i class="fa-lg fa-brands fa-whatsapp"></i> <span class="small ms-2 d-xl-inline-block d-lg-none">${$whatsappText}</span></a>`
							: "";
						const r_cal = job.recruiter.calendly
							? `<a class="text-nowrap nowrap fw-semibold py-1" href="${job.recruiter.calendly}"><i class="fa-regular fa-video"></i> <span class="small ms-2 d-xl-inline-block d-lg-none">${$callText} ${job.recruiter.name}</span></a>`
							: "";
						recruiter = `
							<div class="col-xl-6 col-lg-4 col-md-6 d-flex align-items-center mb-md-0 mb-4">
								<div class="job-content-footer__recruiter-photo">
									${job.recruiter.photo}
								</div>
								<div class="job-content-footer__recruiter-info ms-4 d-flex flex-column justify-content-center">
									${r_phone}
									${r_whatsapp}
									${r_cal}
								</div>
							</div>
						`;
					}
					$("#job-content-footer").html(`
                        <div class="row vw-100 justify-content-end align-items-end">
							${recruiter}
							<div class="col-xl-6 col-lg-8 col-md-6 d-flex flex-column justify-content-between">
								<span class="fs-6 text-md-end d-block fw-semibold">
									${$resumeText}
								</span>
								<a href="#" data-bs-toggle="modal" data-bs-target="#jobAppModal" data-jobtitle="${job.title}" data-jobid="${job.jobID}" class="btn btn-tertiary btn-sm ms-md-auto me-md-0 mt-md-4 mt-3 ms-0 me-auto">
									<i class="fa-regular fa-folder-arrow-up ms-0 me-2"></i>
									${$uploadText}
								</a>
							</div>
						</div>
					`);
				} else {
					$("#job-content-meta").html(
						'<div class="error">' + $errorText + "</div>"
					);
				}
			},
			error: function (error) {
				console.log(error);
				$("#job-content").html('<div class="error">' + $errorText + "</div>");
			},
		});

		if ($(window).width() < 992) {
			$(".job-content-container-scroll").insertAfter(
				$('.job-item[data-job-id="' + jobId + '"]')
			);
			if (jobId) {
				setTimeout(function () {
					document
						.querySelector(".job-content-container-scroll")
						.scrollIntoView({
							behavior: "smooth",
							block: "start", //scroll to top of the target element
						});
				}, 200);
			}
		}
	}

	$(document).on("click", '[data-bs-target="#jobAppModal"]', function () {
		$("#jobAppModal").find(".modal-job-title").text($(this).data("jobtitle"));
		$("#jobAppModal")
			.find('.gform_hidden[name="input_10"]')
			.val($(this).data("jobid"));
	});
});
