(($) => {
	$(function () {
		$("[data-target='#navbarDropdownMenu'").click(function () {
			$("body").toggleClass("mobile-menu-expanded");
		});

		$(".modal").each(function () {
			$(this).detach().appendTo("body");
		});

		// if (isset($_GET["jobid"])) {
		// 	loadJobContent($_GET["jobid"]);
		// }

		$(window).on("load", () => {
			const urlParams = new URLSearchParams(window.location.search);
			const uploadCV = urlParams.get("uploadCV");

			if (uploadCV && uploadCV === "true") {
				$("#uploadCVModal").modal("show");
			}
		});

		$(".gform_button").addClass("btn btn-primary");
	});
})(jQuery);
