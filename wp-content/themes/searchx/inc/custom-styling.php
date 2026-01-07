<?php

declare(strict_types=1);

/**
 * Custom Styling from WP
 */

function hexToRGB($hex)
{
	// Remove the # if it's there
	$hex = ltrim($hex, '#');

	// Convert the hex string to an integer
	$int = hexdec($hex);

	// Extract the RGB values
	$r = ($int >> 16) & 255;
	$g = ($int >> 8) & 255;
	$b = $int & 255;

	// Return an array with the RGB values
	return array('red' => $r, 'green' => $g, 'blue' => $b);
}

function hexToHSL($hex)
{
	// Remove the # if present
	$hex = ltrim($hex, '#');

	// Convert hex to RGB
	$r = hexdec(substr($hex, 0, 2)) / 255;
	$g = hexdec(substr($hex, 2, 2)) / 255;
	$b = hexdec(substr($hex, 4, 2)) / 255;

	// Find minimum and maximum values
	$max = max($r, $g, $b);
	$min = min($r, $g, $b);

	// Calculate lightness
	$l = ($max + $min) / 2;

	// If min and max are the same, it's a shade of gray
	if ($max == $min) {
		$h = $s = 0;
	} else {
		// Calculate saturation
		$d = $max - $min;
		$s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);

		// Calculate hue
		switch ($max) {
			case $r:
				$h = ($g - $b) / $d + ($g < $b ? 6 : 0);
				break;
			case $g:
				$h = ($b - $r) / $d + 2;
				break;
			case $b:
				$h = ($r - $g) / $d + 4;
				break;
		}
		$h /= 6;
	}

	// Convert to percentages and degrees
	return [
		'h' => round($h * 360), // Hue in degrees (0-360)
		's' => round($s * 100), // Saturation as percentage (0-100)
		'l' => round($l * 100)  // Lightness as percentage (0-100)
	];
}

function getContrastColor($hexColor)
{
	// hexColor RGB
	$R1 = hexdec(substr($hexColor, 1, 2));
	$G1 = hexdec(substr($hexColor, 3, 2));
	$B1 = hexdec(substr($hexColor, 5, 2));

	// Black RGB
	$blackColor = "#183152";
	$R2BlackColor = hexdec(substr($blackColor, 1, 2));
	$G2BlackColor = hexdec(substr($blackColor, 3, 2));
	$B2BlackColor = hexdec(substr($blackColor, 5, 2));

	// Calc contrast ratio
	$L1 = 0.2126 * pow($R1 / 255, 2.2) +
		0.7152 * pow($G1 / 255, 2.2) +
		0.0722 * pow($B1 / 255, 2.2);

	$L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
		0.7152 * pow($G2BlackColor / 255, 2.2) +
		0.0722 * pow($B2BlackColor / 255, 2.2);

	$contrastRatio = 0;
	if ($L1 > $L2) {
		$contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
	} else {
		$contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
	}

	// If contrast is more than 5, return black color
	if ($contrastRatio > 5) {
		return '#183152';
	} else {
		// if not, return white color.
		return '#FFFFFF';
	}
}

function root_vars()
{

	$roots_fonts_family = array(
		"--bs-body-font-family" => "font_primary",
		"--bs-font-primary" => "font_primary",
		"--bs-font-secondary" => "font_secondary",
		"--bs-font-monospace" => "font_tertiary",
	);

	$roots_border_radius = array(
		"--bs-border-radius-sm" => "border_radius_sm",
		"--bs-border-radius-md" => "border_radius_md",
		"--bs-border-radius" => "border_radius_md",
		"--bs-border-radius-lg" => "border_radius_lg",
	);

	$roots_colors = array(
		"--bs-primary" => "color_primary",
		"--bs-secondary" => "color_secondary",
		"--bs-tertiary" => "color_tertiary",
		"--bs-success" => "color_success",
		"--bs-info" => "color_info",
		"--bs-warning" => "color_warning",
		"--bs-danger" => "color_danger",
		"--bs-light" => "color_light",
		"--bs-dark" => "color_dark",
		"--bs-link" => "color_link",
	);

	$roots_fonts = array(
		"--bs-body-font-size" => "font_size_base",
		"--bs-font-size-base" => "font_size_base",
		"--bs-font-size-sm" => "font_size_small",
		"--bs-font-size-lg" => "font_size_large",
		"--bs-font-size-h1" => "font_size_h1",
		"--bs-font-size-h2" => "font_size_h2",
		"--bs-font-size-h3" => "font_size_h3",
		"--bs-font-size-h4" => "font_size_h4",
		"--bs-font-size-h5" => "font_size_h5",
		"--bs-font-size-h6" => "font_size_h6",
		"--bs-font-size-h1-mobile" => "mobile_font_size_h1",
		"--bs-font-size-h2-mobile" => "mobile_font_size_h2",
		"--bs-font-size-h3-mobile" => "mobile_font_size_h3",
		"--bs-font-size-h4-mobile" => "mobile_font_size_h4",
		"--bs-font-size-h5-mobile" => "mobile_font_size_h5",
		"--bs-font-size-h6-mobile" => "mobile_font_size_h6",
	);

	$roots_properties = [
		'font_weight',
		'margin_top',
		'margin_bottom'
	];

	$roots_sizes = [
		'base',
		'sm',
		'lg',
		'h1',
		'h2',
		'h3',
		'h4',
		'h5',
		'h6',
	];

	$sizes = [
		'sm',
		'md',
		'lg'
	];

	$paddings = [
		'button_padding_y' => 'padding-y',
		'button_padding_x' => 'padding-x',
	];

	$style = ":root, [data-bs-theme=light], [data-bs-theme=dark], body { ";

	foreach ($roots_fonts_family as $key => $value) {
		if (!empty(get_field($value, "options"))) {
			$style .= $key . ": " . get_field($value, "options") . "!important; ";
		}
	}

	foreach ($roots_colors as $key => $value) {
		if (!empty(get_field($value, "options"))) {
			$rgb = hexToRGB(get_field($value, "options"));
			// $hsl = hexToHSL(get_field($value, "options"));
			$style .= $key . ": " . get_field($value, "options") . "; ";
			$style .= $key . "-hex: " . $rgb['red'] . ', ' . $rgb['green'] . ', ' . $rgb['blue'] . "; ";
			$style .= $key . "-rgb: " . $rgb['red'] . ', ' . $rgb['green'] . ', ' . $rgb['blue'] . "; ";
			// $style .= $key . "-hsl: " . $hsl['h'] . ', ' . $hsl['s'] . ', ' . $hsl['l'] . "; ";
		}
	}

	foreach ($roots_fonts as $key => $value) {
		if (!empty(get_field($value, "options"))) {
			$style .= $key . ": " . get_field($value, "options") / 16 . "rem; ";
		}
	}

	foreach ($roots_border_radius as $key => $value) {
		if (!empty(get_field($value, "options"))) {
			$style .= $key . ": " . get_field($value, "options") / 16 . "rem; ";
		}
	}

	foreach ($roots_sizes as $size) {
		foreach ($roots_properties as $property) {
			$prop = $property . '_' . $size;
			$key = '--bs-' . str_replace('_', '-', $property) . '-' . $size;
			if (!empty(get_field($prop, "options"))) {
				if ($property === 'font_weight') {
					$style .= $key . ": " . get_field($prop, "options") . "; ";
				} else {
					$style .= $key . ": " . get_field($prop, "options") . "em; ";
				}
			}
		}
	}

	foreach ($sizes as $size) {
		foreach ($paddings as $property => $name) {
			$field = $property . '_' . $size;
			$style .= '--bs-' . $name . '-' . $size . ': ' . get_field($field, "options") / 16 . 'rem; ';
		}
	}

	$style .= " } ";

	return $style;
}

function component_styling()
{
	$component_padding_top = get_field("component_padding_top", "options");
	$component_padding_bottom = get_field(
		"component_padding_bottom",
		"options"
	);

	$style = '';

	if (!empty($component_padding_top) || !empty($component_padding_bottom)) {
		$style .= ".component { ";
		$component_padding_top
			? ($style .=
				"padding-top: " . $component_padding_top / 16 . "rem!important; ")
			: "";
		$component_padding_bottom
			? ($style .=
				"padding-bottom: " . $component_padding_bottom / 16 . "rem!important; ")
			: "";
		$style .= " }";
	}

	return $style;
}

function button_styling()
{
	$sizes = [
		'md',
		'sm',
		'lg'
	];

	$properties = [
		'button_padding_y' => 'button_padding_y',
		'button_padding_x' => 'button_padding_x',
		'button_font' => 'font-size',
		'button_weight' => 'font-weight',
		'button_radius' => 'border-radius',
	];

	$style = '';

	foreach ($sizes as $size) {
		$style .= $size === 'md' ? '.btn, body input, html input { ' : '.btn-' . $size . '{ ';
		foreach ($properties as $property => $name) {
			$field = $property . '_' . $size;
			if (!empty(get_field($field, "options"))) {
				if ($property === 'button_padding_y') {
					$style .= "padding-top: " . get_field($field, "options") / 16 . "rem; ";
					$style .= "padding-bottom: " . get_field($field, "options") / 16 * 0.8 . "rem; ";
				} elseif ($property === 'button_padding_x') {
					$style .= "padding-left: " . get_field($field, "options") / 16 . "rem; ";
					$style .= "padding-right: " . get_field($field, "options") / 16 . "rem; ";
				} elseif ($property === 'button_radius') {
					if (get_field($field, "options") !== 'none') {
						$style .= $name . ": " . get_field("border_radius" . '_' . $size, "options") / 16 . "rem; ";
					}
				} elseif ($property === 'button_weight') {
					$style .= $name . ": " . get_field($field, "options") . "; ";
				} else {
					$style .= $name . ": " . get_field($field, "options") / 16 . "rem; ";
				}
			}
		}
		$style .= ' }';
	}


	return $style;
}

function cards_styling()
{

	$properties = [
		'cards_padding_y' => 'cards_padding_y',
		'cards_padding_x' => 'cards_padding_x',
		'cards_gutter' => 'cards_gutter',
		'cards_radius' => 'border-radius',
	];

	$style = '';

	$style .= '.card { ';
	foreach ($properties as $property => $name) {
		if (!empty(get_field($property, "options"))) {
			if ($property === 'cards_radius') {
				if (get_field($property, "options") !== 'none') {
					$style .= $name . ": " . get_field("border_" . get_field($property, "options"), "options") / 16 . "rem; ";
				}
			}
		}
	}
	$style .= ' }';

	$style .= '.card-body { ';
	foreach ($properties as $property => $name) {
		if (!empty(get_field($property, "options"))) {
			if ($property === 'cards_padding_y') {
				$style .= "padding-top: " . get_field($property, "options") / 16 . "rem; ";
				$style .= "padding-bottom: " . get_field($property, "options") / 16 . "rem; ";
				$style .= "@media(max-width:991px){";
				$style .= "padding-top: " . get_field($property, "options") / 16 / 1.25 . "rem; ";
				$style .= "padding-bottom: " . get_field($property, "options") / 16 / 1.25 . "rem; ";
				$style .= "}";
				$style .= "@media(max-width:575px){";
				$style .= "padding-top: " . get_field($property, "options") / 16 / 1.75 . "rem; ";
				$style .= "padding-bottom: " . get_field($property, "options") / 16 / 1.75 . "rem; ";
				$style .= "}";
			} elseif ($property === 'cards_padding_x') {
				$style .= "padding-left: " . get_field($property, "options") / 16 . "rem; ";
				$style .= "padding-right: " . get_field($property, "options") / 16 . "rem; ";
				$style .= "@media(max-width:991px){";
				$style .= "padding-left: " . get_field($property, "options") / 16 / 1.25 . "rem; ";
				$style .= "padding-right: " . get_field($property, "options") / 16 / 1.25 . "rem; ";
				$style .= "}";
				$style .= "@media(max-width:575px){";
				$style .= "padding-left: " . get_field($property, "options") / 16 / 1.75 . "rem; ";
				$style .= "padding-right: " . get_field($property, "options") / 16 / 1.75 . "rem; ";
				$style .= "}";
			}
		}
	}
	$style .= ' }';


	$style .= '.accordions__btn { ';
	$style .= '
		border-bottom-width: ' . get_has_theme_option('accordion_border_b', '0') . 'px;
		border-radius: ' . get_has_theme_option('border_' . get_field('accordion_radius', "options"), "options") . 'px;
		padding-left: ' . get_has_theme_option('accordion_padding_x', '0') / 16 . 'rem!important;
		padding-right: ' . get_has_theme_option('accordion_padding_x', '0') / 16 . 'rem!important;
		@media(max-width: 991px) {
			padding-left: ' . get_has_theme_option('accordion_padding_x', '0') / 16 / 1.5 . 'rem!important;
			padding-right: ' . get_has_theme_option('accordion_padding_x', '0') / 16 / 1.5 . 'rem!important;
		}
		@media(max-width: 575px) {
			padding-left: ' . get_has_theme_option('accordion_padding_x', '0') / 16 / 1.75 . 'rem!important;
			padding-right: ' . get_has_theme_option('accordion_padding_x', '0') / 16 / 1.75 . 'rem!important;
		}
	';
	$style .= ' }';
	$style .= '.accordions__body { ';
	$style .= '
		padding-left: ' . get_has_theme_option('accordion_padding_x', '0') / 16 . 'rem!important;
		padding-right: ' . get_has_theme_option('accordion_padding_x', '0') / 16 . 'rem!important;
		@media(max-width: 991px) {
			padding-left: ' . get_has_theme_option('accordion_padding_x', '0') / 16 / 1.5 . 'rem!important;
			padding-right: ' . get_has_theme_option('accordion_padding_x', '0') / 16 / 1.5 . 'rem!important;
		}
		@media(max-width: 575px) {
			padding-left: ' . get_has_theme_option('accordion_padding_x', '0') / 16 / 1.75 . 'rem!important;
			padding-right: ' . get_has_theme_option('accordion_padding_x', '0') / 16 / 1.75 . 'rem!important;
		}
	';
	$style .= ' }';

	$style .= '.g-4 {  ';
	foreach ($properties as $property => $name) {
		if (!empty(get_field($property, "options"))) {
			if ($property === 'cards_gutter') {
				$style .= "--bs-gutter-y: " . get_field($property, "options") / 16 . "rem!important; ";
				$style .= "--bs-gutter-x: " . get_field($property, "options") / 16 . "rem!important; ";
			}
		}
	}
	$style .= ' }';

	return $style;
}

function output_custom_fonts()
{
	$google_fonts_url = get_field("google_fonts_url", "options");
	$adobe_fonts_url = get_field("adobe_fonts_url", "options");

	if (!empty($google_fonts_url) && $google_fonts_url) {
		echo '
			<link rel="preconnect" href="https://fonts.googleapis.com">
			<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
			<link href="' . $google_fonts_url . '" rel="stylesheet">
		';
	}
	if (!empty($adobe_fonts_url) && $adobe_fonts_url) {
		echo '
			<link href="' . $adobe_fonts_url . '" rel="stylesheet">
		';
	}
}

function output_custom_styles()
{
	$styles = '<style type="text/css">';
	$styles .= root_vars();
	// $styles .= component_styling();
	$styles .= button_styling();
	$styles .= cards_styling();
	$styles .= "</style>";

	echo $styles;
}

function output_logo_header()
{
	if (get_field("logo_header", "options") || !empty(get_field("logo_header", "options"))) {
		echo '<a href="' . pll_home_url() . '" class="custom-logo-link"><img style="max-width:' . get_field("logo_header_width", "options") . 'px;" src="' . get_field("logo_header", "options")['url'] . '" class="custom-logo w-100" alt="' . get_bloginfo('name', 'display') . '" width="' . get_field("logo_header", "options")['width'] . '" height="' . get_field("logo_header", "options")['height'] . '" /></a>';
	}
}

function output_logo_footer()
{
	if (get_field("logo_footer", "options") || !empty(get_field("logo_footer", "options"))) {
		echo '<a href="' . pll_home_url() . '" class="custom-logo-footer"><img style="max-width:' . get_field("logo_footer_width", "options") . 'px;" src="' . get_field("logo_footer", "options")['url'] . '" class="custom-logo w-100" alt="' . get_bloginfo('name', 'display') . '" width="' . get_field("logo_footer", "options")['width'] . '" height="' . get_field("logo_footer", "options")['height'] . '" /></a>';
	}
}
