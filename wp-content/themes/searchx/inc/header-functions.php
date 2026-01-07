<?php

/**
 * Arrow Down Menu adds arrow-down-mobile
 */
class Arrow_Walker_Nav_Menu extends Walker_Nav_Menu
{
	function start_lvl(&$output, $depth = 0, $args = [])
	{
		$indent = str_repeat("\t", $depth);
		if ($depth == 0) {
			$output .= '<span class="arrow-down-mobile"><i class="fa fa-chevron-down"></i></span>';
		}
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}
}

/**
 * Add Aria Labels to Menu Items with Children
 */
function blennd_menu_add_aria($atts, $item, $args, $depth)
{
	if ($depth == 0) {
		$has_children = (is_array($item->classes) && in_array('menu-item-has-children', $item->classes));
		if ($has_children) {
			$atts['aria-label'] = strip_tags($item->title) . ' Menu';
			$atts['aria-expanded'] = 'false';
		}
	}
	return $atts;
}
add_filter('nav_menu_link_attributes', 'blennd_menu_add_aria', 10, 4);

/**
 * Add Images to Menu Item Output
 */
function blennd_dropdown_mega_images($item_output, $item, $depth, $args)
{
	$image = get_field('image', $item);
	if (
		'primary' !== $args->theme_location ||
		empty($image)
	) {
		return $item_output;
	}

	// You can limit it to certain menus with this check
	$img_html = '<figure>' . wp_get_attachment_image($image['id']) . $args->link_after . '</figure>';
	$item_output = $item_output . $img_html;
	return $item_output;
}
add_filter('walker_nav_menu_start_el', 'blennd_dropdown_mega_images', 10, 4);

/**
 * Add Description & SVG Image to Menu Item Link
 */

function blennd_submenu_images($item_output, $item, $depth, $args)
{
	// You can limit it to certain menus with this check
	if (('primary' == $args->theme_location || 'secondary' == $args->theme_location) && (!empty(get_field('svg_raw', $item)) || !empty(get_field('icon_code', $item)))) {

		$svg_html = '';
		$description_html = '';
		$svg_class = '';
		$description_class = '';

		// image check
		if (!empty($item->description)) {
			$description_html = '<span class="link-description">' . $item->description . '</span>';
			$description_class = 'has-description';
		}
		// svg check
		if (!empty(get_field('svg_raw', $item))) {
			$svg_raw = nl2br(get_field('svg_raw', $item));
			$svg_html = '<span class="svg-html">' . $svg_raw . '</span>';
			$svg_class = 'has-svg';
		} elseif (!empty(get_field('icon_code', $item))) {
			$svg_html = get_field('icon_code', $item);
		}
		$item_output = '<a href="' . $item->url . '" target="' . $item->target . '" class="' . $description_class . ' ' . $svg_class . '">';
		$item_output .= $svg_html;
		$item_output .= '<span class="title-wrap">';
		$item_output .= '<span class="link-title">' . $item->title . '</span>';
		$item_output .= $description_html;
		$item_output .= '</span>'; // .title-wrap
		$item_output .= '</a>';
	}

	return $item_output;
}
add_filter('walker_nav_menu_start_el', 'blennd_submenu_images', 10, 4);
