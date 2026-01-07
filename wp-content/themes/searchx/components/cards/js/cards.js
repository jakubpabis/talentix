(function ($) {
	function initFontAwesomePreview() {
		if (typeof acf === "undefined") return;

		acf.addAction("load_field/type=text", function (field) {
			if (field.get("name") === "card_icon") {
				field.$input().on("change", function () {
					var selectedIcon = $(this).val();
					var $preview = field.$el.find(".font-awesome-preview");
					if ($preview.length === 0) {
						$preview = $(
							'<div class="font-awesome-preview"></div>'
						).insertAfter(field.$input());
					}
					$preview.html(selectedIcon);
				});

				// Trigger change to show initial selection
				field.$input().trigger("change");
			}
		});
	}

	$(document).ready(initFontAwesomePreview);
})(jQuery);
