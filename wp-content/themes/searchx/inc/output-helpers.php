<?php

declare(strict_types=1);

/**
 * Output Helpers
 */

/**
 * Print the HTML attributes
 *
 * @since 0.7.6
 * @since 2.7.0 $callback parameter removed
 *
 * @param array<string,string|array> $attr Associative array of attribute names and values.
 */
function html_atts(array $attr)
{
	echo get_html_atts($attr);
}

/**
 * Generate a string of HTML attributes
 *
 * @since 0.7.0
 * @since 2.7.0 $callback parameter removed
 *
 * @param array<string,string|array> $attr Associative array of attribute names and values.
 *
 * @return string Returns a string of HTML attributes.
 */
function get_html_atts(array $attr): string
{
	$value = array_map(function ($val, $key) {
		if (is_array($val)) {
			$val = implode(' ', array_filter($val, 'esc_attr'));
		}
		return sprintf('%1$s="%2$s"', esc_attr($key), esc_attr($val));
	}, $attr, array_keys($attr));
	return implode(' ', $value);
}

function blennder_array_to_json($config)
{
	return htmlspecialchars(json_encode($config, JSON_FORCE_OBJECT | JSON_NUMERIC_CHECK));
}


function get_breadcrumbs()
{
	$data_links = [];
	$data_source = get_field('breadcrumb_data_source');

	if ($data_source === 'automatic') {
		if (!is_search() || !is_404()) {
			$data_links = get_page_breadcrumbs();
		}
	} elseif ($data_source === 'manual') {
		$data_links = get_breadcrumbs_manual_ids(get_field('breadcrumbs_manual_pages'));
	} else {
		if (!is_search() || !is_404()) {
			$data_links = get_page_breadcrumbs();
		}
	}
	return $data_links;
}


/* Get Breadcrumbs for Pages and Posts */
function get_page_breadcrumbs()
{

	$post = get_queried_object();
	$post_type = get_post_type();
	$post_type_object  = get_post_type_object($post_type);
	$post_type_archive = get_post_type_archive_link($post_type);

	$crumbs = [];

	// get all ancestors — except CPT archive
	if (!is_archive() && !is_post_type_archive() && !is_single()) {
		$crumb_tree = get_post_ancestors($post->ID); // empty array or array of ids
	} elseif (is_single()) {
		$id = get_the_ID();
		$post_category = get_the_category($id);
		if (!empty($post_category)) {
			$ancestors = get_ancestors($post_category[0]->term_id, 'category');
			array_unshift($ancestors, $post_category[0]->term_id);
			$crumb_tree = $ancestors;
		}
	} else {
		$crumb_tree[] = get_option('page_for_posts');
	}

	//FRONT PAGE
	if (is_front_page()) {
		return $crumbs;
	}

	// PARENT BASES
	if (!empty($crumb_tree)) {
		$crumb_tree = array_reverse($crumb_tree);
		foreach ($crumb_tree as $crumb_id) {
			$crumbs[] = [
				'title' => get_the_title($crumb_id) ? get_the_title($crumb_id) : get_the_category_by_ID($crumb_id),
				'url' => get_the_permalink($crumb_id) ?  get_the_permalink($crumb_id) : get_category_link($crumb_id),
			];
		}
	}


	// CURRENT PAGE
	if (is_page() || is_single()) {
		$crumbs[] = [
			'title' => get_the_title($post->ID),
			'url' => get_the_permalink($post->ID),
		];
	}

	//SEARCH RESULTS PAGE
	if (is_search()) {
		$crumbs[] = [
			'title' => get_search_query(),
			'url' => get_search_link(),
		];
	}

	// BACK BUTTON
	// if (is_single() && $post->post_type === 'post') {
	// 	// overwrite crumbs
	// 	$crumbs = [[
	// 		'title' => '<i class="far fa-chevron-left"></i> Back to ' . get_the_title($blog_id),
	// 		'url' => get_the_permalink($blog_id),
	// 	]];
	// }

	// add home icon
	array_unshift($crumbs, [
		'title' => '<i class="fas fa-home"></i><span class="sr-only">' . pll__('Home') . '</span>',
		'url' => get_home_url(),
	]);

	return $crumbs;
}

function get_breadcrumbs_manual_ids($breadcrumbs)
{
	$data_links = [];
	if (!empty($breadcrumbs)) {
		foreach ($breadcrumbs as $breadcrumb) {
			if ($breadcrumb['breadcrumb_post_object'] !== false) {
				$data_links[] = [
					'url' => get_the_permalink($breadcrumb['breadcrumb_post_object']),
					'title' => get_the_title($breadcrumb['breadcrumb_post_object']),
				];
			}
		}
	}
	array_unshift($data_links, [
		'title' => '<i class="fas fa-home"></i><span class="sr-only">Home</span>',
		'url' => get_home_url(),
	]);
	return $data_links;
}

/**
 * Get the time elapsed since the post was published.
 *
 * @param int|WP_Post|null $post Optional. Post ID or WP_Post object. Default is global $post.
 * @return string Time elapsed since publication (e.g., '5d', '12h', '30m', '30d+').
 */
function get_time_since_published($full = false, $post = null, $lang = 'en')
{
	// Get the post object
	$post = get_post($post);

	// Ensure the post exists
	if (!$post) {
		return '';
	}

	// Get the post's publication date in Unix timestamp
	$post_time = get_post_datetime($post);
	if ($post_time) {
		$post_timestamp = $post_time->getTimestamp();
	}
	// $post_time = get_post_time('U', true, $post);

	// Get the current time in Unix timestamp
	$current_time = current_time('timestamp');

	// Calculate the time difference in seconds
	$time_diff = $current_time - $post_timestamp;

	// Calculate the time differences in minutes, hours, and days
	$minutes = round($time_diff / 60);
	$hours = round($time_diff / 3600);
	$days = round($time_diff / 86400);

	// Determine the appropriate time format to return
	if ($days > 30) {
		if ($full) {
			return '30+ days ago';
		}
		return '30d+';
	} elseif ($days >= 1) {
		if ($full) {
			return $days . ' days ago';
		}
		return $days . 'd';
	} elseif ($hours >= 1) {
		if ($full) {
			return $hours . ' hours ago';
		}
		return $hours . 'h';
	} else {
		if ($full) {
			return $minutes . ' minutes ago';
		}
		return $minutes . 'm';
	}
}

function get_page_url_by_template($template)
{
	$args = array(
		'post_type'      => 'page',
		'posts_per_page' => 1, // Limit to 1 result
		'meta_key'       => '_wp_page_template',
		'meta_value'     => $template,
		'fields'         => 'ids', // Return only the page ID
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		$page_id = $query->posts[0]; // Get the first page ID
		return get_permalink($page_id); // Return the page URL
	}

	return false; // No page found with the template
}

function get_page_url_by_template_in_current_language($template)
{
	// Check if Polylang is active
	if (!function_exists('pll_current_language')) {
		return false;
	}

	// Get the current language
	$current_language = pll_current_language();

	// Query pages with the specified template
	$args = array(
		'post_type'      => 'page',
		'posts_per_page' => 1, // Limit to 1 result
		'meta_key'       => '_wp_page_template',
		'meta_value'     => $template,
		'fields'         => 'ids', // Return only the page ID
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		$page_id = $query->posts[0]; // Get the first page ID

		// Get the translated page ID for the current language
		$translated_page_id = pll_get_post($page_id, $current_language);

		if ($translated_page_id) {
			return get_permalink($translated_page_id); // Return the translated page URL
		} else {
			return get_permalink($page_id); // Fallback to the original page URL
		}
	}

	return false; // No page found with the template
}
