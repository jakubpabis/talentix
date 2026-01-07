<?php

declare(strict_types=1);

use App\Gutenberg\Setup;

/**
 * Component Functions
 */

/**
 * Render the component
 *
 * @param array $block_attributes
 *
 * @since 2.7.2
 */
function component_render_callback(array $block_attributes): void
{
	// If called as a callback for an ACF block,
	// `get_fields()` returns the ACF block fields
	// not the fields for the page
	$fields = get_fields();
	if (! $fields) {
		return;
	}

	if (
		! is_admin() &&
		'hidden' === get_has_field('block_visibility', 'visible', $fields)
	) {
		return;
	}

	if (! empty($block_attributes['className'])) {
		$fields['className'] = $block_attributes['className'];
	}

	$name = str_replace('acf/', '', $block_attributes['name']);

	the_component($name, $fields, false);
}

/**
 * Prints the component name
 *
 * @since 2.4.0
 */
function component_name()
{
	echo get_component_name();
}

/**
 * Returns the component name
 *
 * @since 2.4.0
 *
 * @return string The component name
 */
function get_component_name()
{
	return get_has_field('name', 'default');
}

/**
 * Returns the component directory.
 *
 * @since 0.7.5
 * @since 0.7.6 $fields argument removed.
 */
function component_directory($dir = '')
{
	$dir = ltrim($dir, '/');
	$path = get_theme_file_path('components');
	if (! empty($dir)) {
		$path = trailingslashit($path) . $dir;
	}
	return trailingslashit($path);
}

/**
 * Returns an array of component blocks.
 *
 * This function uses caching to eliminate the need to parse the directory
 * structure on each page load. To bust the cache, it's necessary to bump
 * the version number.
 *
 * @since 2.7.1
 *
 * @return array
 */
function component_get_blocks(): array
{
	$theme   = wp_get_theme();
	$blocks  = get_option('blennder_blocks');
	$version = get_option('blennder_blocks_version');

	if (
		empty($blocks) ||
		version_compare($theme->get('Version'), $version)
	) {
		$dir = get_stylesheet_directory() . '/components';
		$dirs = array_filter(glob("$dir/*"), 'is_dir');

		$blocks = [];
		foreach ($dirs as $key => $dir) {
			$path = pathinfo($dir);
			$block = $path['basename'] ?? '';
			$blocks[] = $block;
		}
		update_option('blennder_blocks', $blocks);
		update_option('blennder_blocks_version', $theme->get('Version'));
	}
	return $blocks;
}

/**
 * Return the default component template directory.
 *
 * @since 0.7.4
 *
 * @return string The default component template directory.
 */
function component_default_template(): string
{
	return component_directory() . 'template.php';
}

/**
 * Return the component template.
 *
 * @since 2.7.3
 *
 * @return string
 */
function get_component_template(): string
{
	$layout = get_component_name();
	$block_template = get_has_field("{$layout}_block_template", '');
	$block_template = str_replace('THEMEPATH', get_stylesheet_directory(), $block_template);
	return $block_template;
}

/**
 * Prints the component template.
 *
 * @since 0.7.5
 * @since 0.7.6 $fields argument removed.
 * @since 2.7.0 Added support for block templates.
 */
function component_template(): void
{
	$block_template = get_component_template();
	if (file_exists($block_template)) {
		require $block_template;
		return;
	}

	$layout = get_component_name();
	$templates = component_templates($layout);
	if (is_array($templates) && count($templates) > 0) {
		$keys = array_keys($templates);

		if (file_exists($keys[0])) {
			require $keys[0];
		}
	}
}

/**
 * Returns the component templates.
 *
 * @param string $name  Name of component.
 *
 * @since 2.7.0
 *
 * @return array
 */
function component_templates(string $name): array
{
	$template_dir = component_directory($name . '/templates');
	$files = [];
	if (file_exists($template_dir)) {
		$files = list_files($template_dir);
	}

	$templates = [];
	foreach ($files as $file) {
		if (preg_match('|Template Name(.*)$|mi', file_get_contents($file), $header)) {
			$file = str_replace(get_template_directory(), 'THEMEPATH', $file);
			$template_name = str_replace(': ', '', $header[1]);
			$templates[$file] = $template_name;
		}
	}
	asort($templates);
	return $templates;
}

/**
 * Return the component block template.
 *
 * @since 2.3.0 Unused $fields parameter removed.
 *
 * @return string The component template.
 */
function component_block_template(): string
{
	$layout = get_component_name();
	$template = component_directory($layout) . "$layout-template.php";
	if (! file_exists($template)) {
		$template = component_default_template();
	}
	return $template;
}

/**
 * Outputs the component background image
 *
 * @param array $attributres Array of attributes for the background image
 *
 * @since 2.6.0 Added $attributes parameter.
 */
function component_background_image(array $attributes = [])
{
	if ('image' !== get_has_field('background_type', '')) {
		return;
	}
	$defaults = [
		'class' => 'object-fit-cover',
	];
	if (0 === Setup::get_block_number()) {
		$defaults['loading'] = 'eager';
		$defaults['fetchpriority'] = 'high';
	}
	$attributes = array_merge_recursive($defaults, $attributes);
	acf_image('background_image', 'full', $attributes);
}

/**
 * Returns styling properties of component container from WP.
 *
 * @since 2.7.9.
 */
function component_container_styling($fields)
{
	$padding_top = get_has_theme_option('component_padding_bottom', '0');
	if (get_field('component_padding_top') > -1) {
		$padding_top = get_field('component_padding_top');
	} elseif (get_has_field('component_padding_top', '', $fields) !== '') {
		$padding_top = get_has_field('component_padding_top', '', $fields);
	}

	$padding_bottom = get_has_theme_option('component_padding_bottom', '0');
	if (get_field('component_padding_bottom') > -1) {
		$padding_bottom = get_field('component_padding_bottom');
	} elseif (get_has_field('component_padding_bottom', '', $fields) !== '') {
		$padding_bottom = get_has_field('component_padding_bottom', '', $fields);
	}

	$styling = '';

	if ($padding_top !== null && strlen($padding_top) > 0) {

		if (intval($padding_top) !== 0) {
			$padding_top = intval($padding_top) / 16 . 'rem';
		}
		$styling .= 'padding-top: ' . $padding_top . '; ';
	}
	if ($padding_bottom !== null && strlen($padding_bottom) > 0) {
		if (intval($padding_bottom) !== 0) {
			$padding_bottom = intval($padding_bottom) / 16 . 'rem';
		}
		$styling .= 'padding-bottom: ' . $padding_bottom . '; ';
	}

	return $styling;
}



/**
 * Returns the name of the component template file.
 *
 * This function returns the name of the component template file. This name is used
 * to get the template file name without the directory path.
 *
 * @since 2.7.9
 *
 * @return string The name of the component template file.
 */
function get_component_template_name()
{
	// Get the component template file path.
	$template = get_component_template();

	// Split the path by '/' and get the last element.
	$parts = explode('/', $template);
	$template_name = end($parts);

	// Split the last element by '.' and get the first element.
	$template_name = explode('.', $template_name)[0];

	// Return the template file name.
	return $template_name;
}


/**
 * Prints the component container.
 *
 * @since 0.7.5
 * @since 0.7.6 $fields argument removed.
 * @since 2.7.3 Container class added to block template.
 */
function component_container()
{
	$template_name = get_component_template_name();
	$file = get_component_template();
	$container = $template_name === 'banner-full' ? 'container-full overflow-hidden' : 'container';
	if (file_exists($file)) {
		if (preg_match('|Container Class:(.*)$|mi', file_get_contents($file), $header)) {
			$container = $header[1];
		}
	}
	$attr = ['class' => $container];
	html_atts($attr);
}

/**
 * Returns the component classes.
 *
 * @since 0.7.5
 * @since 0.7.6 $fields argument removed.
 *
 * @return array An array of the component classes.
 */
function component_classes(): array
{
	global $fields;

	$layout = get_component_name();

	$block_template = get_has_field("{$layout}_block_template", '');
	$classes = [
		'component',
		$layout,
	];
	if (!empty(get_field('component_class')) && get_field('component_class')) {
		$classes[] = get_field('component_class');
	}
	if ('' === $block_template) {
		return $classes;
	}

	$pathinfo = pathinfo($block_template);
	$filename = $pathinfo['filename'];
	$filename = str_replace($layout . '-', $layout . '--', $filename);
	$classes[] = $filename;

	if (isset($fields['className'])) {
		$classes[] = $fields['className'];
	}

	return $classes;
}

/**
 * Print the component row attributes.
 *
 * @since 0.7.5
 * @since 0.7.6 $fields argument removed.
 * @since 2.4.0 Remove calls to {component}_row() functions.
 */
function component_row(string $class = '')
{
	$layout = get_component_name();
	$attr = [
		'class' => [
			'row',
			"{$layout}__row",
			$class,
		],
	];
	html_atts($attr);
}

/**
 * Print the component col attributes.
 *
 * @param string $class
 *
 * @since 2.7.0
 */
function component_col(string $class = '')
{
	$layout = get_component_name();
	$attr = [
		'class' => [
			'col',
			"{$layout}__col",
			$class,
		],
	];
	html_atts($attr);
}

/**
 * Checks if a field is not empty
 *
 * @since 0.7.5
 *
 * @param string $name field name
 *
 * @return bool Returns a field value
 */
function has_field(string $field, array $fields = []): bool
{
	if (empty($fields)) {
		$fields = $GLOBALS['fields'];
	}
	return ! empty($fields[$field]);
}

/**
 * Gets the value of a field if it is not empty. Returns the fallback if field is empty.
 *
 * @since 0.7.5
 *
 * @param string $name field name
 * @param string $fallback value to fallback to if the field is empty
 *
 * @return mixed  Returns a field value
 */
function get_has_field($name, $fallback, array $fields = [])
{
	if (empty($fields)) {
		$fields = $GLOBALS['fields'];
	}

	return (has_field($name, $fields)) ? $fields[$name] : $fallback;
}

/**
 * Returns a component template part.
 *
 * @since 0.7.6
 * @since 2.3.0 $fields parameter removed.
 *
 * @param string $part      The component part name.
 * @param string $component The component name.
 * @param array  $fields    The current fields array
 *
 * @return string           The path to the component part.
 */
function component_part_path(string $part, string $component = ''): string
{
	if ($component === '') {
		$component = get_component_name();
	}

	return locate_template('components/' . trailingslashit($component) . trailingslashit('template-parts') . "$part.php");
}

/**
 * Return the relative path for the component block template.
 *
 * @param string $part      The component part name.
 * @param string $component The component name.
 *
 * @since 2.7.6
 *
 * @return string The component relative path.
 */
function component_relpath(string $part, string $component): string
{
	return trailingslashit('THEMEPATH') . trailingslashit('components') . trailingslashit($component) . trailingslashit('templates') . "$part.php";
}

/**
 * Returns the component. A thin wrapper to get the Block component.
 *
 * @since 0.7.5
 *
 * @param string $component The component name.
 * @param array  $args      The arguments to pass to the Block App.
 *
 * @return string The HTML for the component.
 */
function get_component(string $component, array $args = [])
{
	ob_start();
	the_component($component, $args);
	return ob_get_clean();
}

/**
 * A thin wrapper to echo the Block component.
 *
 * @since 0.7.5
 * @since 2.7.0 $enqueue parameter added
 *
 * @param string  $component The component name.
 * @param array   $args      The arguments to pass to the Block App.
 * @param boolean $enqueue   Whether to enqueue the component style and script.
 */
function the_component(string $component, array $args = [], bool $enqueue = true)
{

	if (true === $enqueue) {
		wp_enqueue_style("blennder/$component");
		wp_enqueue_script("blennder/$component");
	}

	$args['name'] = $component;
	$fields = $args;
	$fields = component_remove_empty_fields($fields);

	$func_file = component_directory($component) . "{$component}-functions.php";
	if (file_exists($func_file)) {
		include_once $func_file;
	}

	$GLOBALS['fields'] = $fields;
	$template = component_block_template($fields);
	if (file_exists($template)) {
		include $template;
	}
	unset($GLOBALS['fields']);
}

/**
 * Prints the components attributes.
 *
 * @since 0.7.0
 * @since 0.7.6 $fields argument removed.
 * @since 2.3.0 $classes argument removed.
 */
function component_attributes($class = '')
{
	$fields = $GLOBALS['fields'];
	$layout = get_component_name();

	$id = get_has_field('component_id', $layout . '-' . uniqid());
	$atts = [
		'id'    => $id,
		'class' => component_classes($fields),
		'style' => '',
	];
	$atts['class'][] = $class;

	// if (get_component_template_name() === 'hero-default') {
	// 	if (get_field('background_image') && !empty('background_image')) {
	// 		array_push($atts['class'], 'hero__background-img');
	// 	}
	// 	if (get_field('hero_image_position') === 'left') {
	// 		array_push($atts['class'], 'hero__background-img--left');
	// 	}
	// }
	if (
		'color' === get_has_field('background_type', '', $fields) &&
		! empty(get_has_field('background_color', '', $fields))
	) {
		$atts['style'] .= "background-color: {$fields['background_color']};";
	}
	if (component_container_styling($fields) && !empty(component_container_styling($fields))) {
		$atts['style'] .= $atts['style'] && !empty($atts['style']) ? $atts['style'] . ' ' . component_container_styling($fields) : component_container_styling($fields);
	} else {
	}

	if ('hidden' === get_has_field('block_visibility', 'visible')) {
		$atts['hidden'] = true;
	}

	$atts['data-bs-theme'] = get_has_field('component_color_theme', 'light');

	html_atts($atts);
}

/**
 * Prints the component content
 *
 * @since 2.7.0
 */
function component_content()
{
	component_sub_header();
	component_header();
	component_text();
	if (!empty(get_field('component_link')) || !empty(get_field('component_link_2')) || !empty(get_field('component_link_3')) || !empty(get_field('component_link_4'))) {
		echo '<div class="d-flex flex-wrap component__header-buttons mx-n3">';
		if (!empty(get_field('component_link'))) {
			component_link();
		}
		if (!empty(get_field('component_link_2'))) {
			component_link_2();
		}
		if (!empty(get_field('component_link_3'))) {
			component_link_3();
		}
		if (!empty(get_field('component_link_4'))) {
			component_link_4();
		}
		if (!empty(get_field('component_link_5'))) {
			component_link_5();
		}
		echo '</div>';
	}
}

/**
 * Prints the component header
 *
 * @since 0.7.0
 * @since 0.7.6 $fields argument removed.
 * @since 2.0.1 $attributes removed.
 */
function component_header(string $class = '')
{
	$header = get_has_field('component_header', '');
	if ('' === $header) {
		return;
	}

	$tag = get_has_field('component_header_tag', 'h2');
	$attr['class'] = [
		get_component_name() . '__header',
		get_has_field('component_header_style', ''),
		get_has_field('component_header_class', ''),
	];
	$layout = get_has_field('name', '');
	if ('true' === get_has_field('screen_reader_header', 'false')) {
		$attr['class'][] = 'visually-hidden';
	}
	// $attr['data-aos'] = 'fade';
	$attr['class'] = array_merge($attr['class'], explode(' ', $class));
	the_tag($tag, $attr, $header);
}

/**
 * Prints the component sub header
 *
 * @since 0.8.0
 * @since 2.0.1 $attributes removed.
 */
function component_sub_header(string $class = '')
{
	$subheader = get_has_field('component_sub_header', '');
	if ('' === $subheader) {
		return;
	}

	$tag = get_has_field('component_sub_header_tag', 'p');
	$attr['class'] = [
		get_component_name() . '__subheader',
		get_has_field('component_sub_header_style', ''),
		get_has_field('component_sub_header_class', ''),
	];
	// $attr['data-aos'] = 'fade';
	$attr['class'] = array_merge($attr['class'], explode(' ', $class));
	the_tag($tag, $attr, $subheader);
}

/**
 * Prints the component intro text
 *
 * @since 0.8.0
 * @since 2.0.1 $attributes removed.
 */
function component_text(bool $container = false, string $container_class = '')
{
	$wrapper_start = '';
	$wrapper_end = '';
	$font_size = get_has_field('component_text_font_size', false);
	if ($container || $font_size) {
		$wrapper_start = '<div class="' . $font_size . ' ' . get_component_name() . '__text ' . $container_class . '">';
		$wrapper_end = '</div>';
	}
	echo $wrapper_start;
	acf_wysiwyg('component_text');
	echo $wrapper_end;
}

/**
 * Prints the component link
 *
 * @since 2.4.0
 */
function component_link(string $class = '')
{
	acf_link('component_link', ['class' => get_has_field('component_link_style', 'btn btn-primary ') . ' m-3 ' . $class]);
}

/**
 * Prints the component link
 *
 * @since 2.4.0
 */
function component_link_2(string $class = '')
{
	acf_link('component_link_2', ['class' => get_has_field('component_link_style_2', 'btn btn-primary ') . ' m-3 ' . $class]);
}

/**
 * Prints the component link
 *
 * @since 2.4.0
 */
function component_link_3(string $class = '')
{
	acf_link('component_link_3', ['class' => get_has_field('component_link_style_3', 'btn btn-primary ') . ' m-3 ' . $class]);
}

/**
 * Prints the component link
 *
 * @since 2.4.0
 */
function component_link_4(string $class = '')
{
	acf_link('component_link_4', ['class' => get_has_field('component_link_style_4', 'btn btn-primary ') . ' m-3 ' . $class]);
}

/**
 * Prints the component link
 *
 * @since 2.4.0
 */
function component_link_5(string $class = '')
{
	acf_link('component_link_5', ['class' => get_has_field('component_link_style_5', 'btn btn-primary ') . ' m-3 ' . $class]);
}

/**
 * Return the WP_Query object
 *
 * @since 2.7.8
 *
 * @return \WP_Query
 */
function component_query(string $post_type = 'post'): \WP_Query
{
	$args = component_get_wp_query_args($post_type);
	return new \WP_Query($args);
}

function my_title_only_search_filter($search, $wp_query)
{
	global $wpdb;
	if (!empty($search)) {
		$q = $wp_query->query_vars;
		if (!empty($q['s'])) {
			$like = '%' . $wpdb->esc_like($q['s']) . '%';
			$search = $wpdb->prepare(" AND ({$wpdb->posts}.post_title LIKE %s) ", $like);
		}
	}
	return $search;
}

/**
 * Prepare WP_Query arguments from Blog Component Fields
 *
 * @since 0.7.0
 * @since 0.7.6 $fields argument removed.
 * @since 2.7.0 $component field removed.
 *
 * @param   string $post_type Post Type to query. Defaults to 'post'.
 *
 * @return  array Arguments for WP_Query
 */
function component_get_wp_query_args(string $post_type = 'post'): array
{

	$component = get_component_name();

	$source = get_has_field('posts_source', 'wp_query');
	$args = [
		'post_type' => $post_type,
	];

	$json = component_json($component);
	if (isset($json->blennder) && isset($json->blennder->query_args)) {
		$json_args = $json->blennder->query_args;
		$json_args = json_decode(json_encode($json_args), true);
		$args = array_merge($args, $json_args);
	}

	if ('post_picker' === $source) {
		$post_picker = get_has_field('post_picker', []);
		$args['orderby'] = 'post__in';
		$args['post__in'] = array_merge([PHP_INT_MAX], $post_picker);
	}
	if ('filter_picker' === $source) {
		$post_picker = get_has_field('jobs_category', []);
		$search_term = get_has_field('jobs_search', '');
		if (!empty($post_picker)) {
			$args['tax_query'][] = [
				'taxonomy' => 'job-category',
				'field'    => 'term_id',
				'terms'    => $post_picker,
				'operator' => 'IN'
			];
		}

		if (!empty($search_term)) {
			$args['s'] = $search_term;
			// Filter to limit search to titles only
			add_filter('posts_search', 'my_title_only_search_filter', 10, 2);
		}
		$args['orderby'] = 'modified';
		$args['order'] = 'DESC';
		//var_dump($args);
	}
	return apply_filters("{$component}_get_wp_query_args", $args, $post_type);
}

/**
 * Print the swiper attributes.
 *
 * @since 2.7.0
 */
function component_swiper_attributes(array $class = [], array $breakpoints = [], array $slider_config = []): void
{
	$component = get_component_name();

	$config = [
		'loop' => false,
		'speed' => '1000',
		'autoplay' => false,
		'preloadImages' => false,
		'watchSlidesVisibility' => true,
		'lazy' => [
			'loadPrevNext' => true,
			'loadOnTransitionStart' => true,
		],
		'parallax' => true,
	];
	if (!empty($slider_config)) {
		$config = array_merge($config, $slider_config);
	}

	$json = component_json($component);
	if (isset($json->blennder) && isset($json->blennder->carousel_config)) {
		$json_config = $json->blennder->carousel_config;
		$json_config = json_decode(json_encode($json_config), true);
		$config = array_merge($config, $json_config);
	}

	if (get_component_name() !== 'logos' && get_component_name() !== 'testimonials' && empty($breakpoints)) {
		$breakpoints = array(
			'breakpoints' => array(
				'0' => array(
					"slidesPerView" => get_has_field('cards_cols_xs', 1),
				),
				'576' => array(
					"slidesPerView" => get_has_field('cards_cols_sm', 1),
				),
				'768' => array(
					"slidesPerView" => get_has_field('cards_cols_md', 2),
				),
				'992' => array(
					"slidesPerView" => get_has_field('cards_cols_lg', 2),
				),
				'1200' => array(
					"slidesPerView" => get_has_field('cards_cols_xl', 3),
				),
				'1400' => array(
					"slidesPerView" => get_has_field('cards_cols_xxl', 3),
				),
			),
		);
		$breakpoints = json_decode(json_encode($breakpoints), true);
		$config = array_merge($config, $breakpoints);
	} elseif (!empty($breakpoints)) {
		$breakpoints = json_decode(json_encode($breakpoints), true);
		$config = array_merge($config, $breakpoints);
	}

	$config = apply_filters("{$component}_carousel_config", $config);
	$config = blennder_array_to_json($config);

	$attr = [
		'id'          => 'slider-' . uniqid(),
		'class'       => ['swiper'],
		'data-config' => $config,
	];
	foreach ($class as $value) {
		array_push($attr['class'], $value);
	}
	html_atts($attr);
}

/**
 * Return the Yoast SEO primary term. Falls back to the first term.
 *
 * @since 2.1.0
 *
 * @param  int    $post_id (Optional) The post ID.
 * @param  string $term    (Optional) The term.
 *
 * @return string Return the primary term if it exists.
 */
function get_primary_term(int $post_id = 0, string $term = 'category'): string
{

	$primary_cat_id = get_post_meta($post_id, "_yoast_wpseo_primary_$term", true);
	if ($primary_cat_id) {
		$primary_cat = get_term($primary_cat_id, $term);
		return $primary_cat->name;
	}

	$terms = get_the_terms($post_id, $term);
	return (is_array($terms) && count($terms) >= 1) ? $terms[0]->name : '';
}

/**
 * Prints the primary category.
 *
 * @since 2.1.0
 */
function the_primary_category()
{
	echo get_primary_term();
}

/**
 * Cleanup $fields array by removing empty elements.
 *
 * @since 2.3.0
 *
 * @param array $fields The fields array.
 *
 * @return array The fields array with empty elements removed.
 */
function component_remove_empty_fields(array $fields): array
{
	foreach ($fields as $key => $field) {
		if (! isset($field)) {
			unset($fields[$key]);
		}
	}
	return $fields;
}


/**
 * Print the card group classes.
 *
 * @since 2.7.8
 *
 * @param string $component The name of the component
 *
 * @return void
 */
function component_card_group_row(string $component, array $classes = [], array $breakpoints = []): void
{
	$attr['class'] = array_merge(['row', "{$component}__row", 'gx-8 gy-10'], $classes);

	if (empty($breakpoints)) {

		$breakpoints = [
			'xs'  => '1',
			'sm'  => '1',
			'md'  => '2',
			'lg'  => '2',
			'xl'  => '3',
			'xxl' => '3',
		];

		$json = component_json($component);
		if (isset($json->blennder) && isset($json->blennder->card_group)) {
			$json_breakpoints = $json->blennder->card_group;
			$json_breakpoints = json_decode(json_encode($json_breakpoints), true);
			$breakpoints = array_merge($breakpoints, $json_breakpoints);
		}

		foreach ($breakpoints as $key => $value) {
			if (!empty(get_field('cards_cols_' . $key, "options"))) {
				$breakpoints[$key] = get_field('cards_cols_' . $key, "options");
			}
		}
	}



	$breakpoints = apply_filters("{$component}_card_group", $breakpoints);

	foreach ($breakpoints as $breakpoint => $cards_per_view) {
		if ('xs' === $breakpoint) {
			$attr['class'][] = sprintf('row-cols-%s', $cards_per_view);
		} else {
			$attr['class'][] = sprintf('row-cols-%s-%s', $breakpoint, $cards_per_view);
		}
	}
	html_atts($attr);
}

/**
 * Returns the component JSON data.
 *
 * @since 2.3.0
 * @since 2.4.0 Add static caching to improve performance.
 *
 * @param string $component The component name
 *
 * @return object|null
 */
function component_json(string $component): ?object
{
	static $component_json;
	if (isset($component_json[$component])) {
		return $component_json[$component];
	}
	$file = component_directory() . "$component/block.json";
	if (file_exists($file)) {
		$contents = file_get_contents($file);
		$json = json_decode($contents);
		$component_json[$component] = $json;
		if ($json) {
			return $json;
		}
	}
	return null;
}

/**
 * Return the component dependencies
 *
 * @param string $component
 *
 * @since 2.7.3
 *
 * @return object|null
 */
function component_dependencies(string $component): ?object
{
	$json = component_json($component);
	if (
		isset($json->blennder) &&
		isset($json->blennder->dependencies)
	) {
		return $json->blennder->dependencies;
	}

	return null;
}

/**
 * Return the component description
 *
 * @param string $component
 *
 * @since 2.7.3
 *
 * @return string
 */
function component_description(string $component): string
{
	$json = component_json($component);
	return $json->description ?? '';
}

/**
 * Print the global component.
 *
 * @since 2.3.0
 *
 * @param string $name The slug of the global component
 */
function global_component(string $name)
{
	$args = [
		'post_type' => 'globalcomponents',
		'name'      => $name,
	];
	$the_query = new \WP_Query($args);

	if ($the_query->have_posts()) {
		while ($the_query->have_posts()) {
			$the_query->the_post();
			the_content();
		}
	}
	wp_reset_postdata();
}

/**
 *
 */
function component_video_attributes()
{
	html_atts([
		'playsinline'      => true,
		'autoplay'         => true,
		'muted'            => get_has_field('background_video_muted', false),
		'loop'             => get_has_field('background_video_loop', false),
		'poster'           => acf_url('background_video_poster'),
		'data-mp4'         => acf_url('background_video_desktop_mp4'),
		'data-mp4-mobile'  => acf_url('background_video_mobile_mp4'),
		'data-webm'        => acf_url('background_video_desktop_webm'),
		'data-webm-mobile' => acf_url('background_video_mobile_webm'),
	]);
}

/**
 * Returns the primary taxonomy.
 *
 * Warning! This function will only work on the core blog post type and any custom post type
 * that is registered with the Blennder abstraction.
 *
 * @param string $post_type (Optional) The post type. Defaults to the current post type.
 *
 * @since 2.7.6
 *
 * @return string
 */
function get_primary_taxonomy(string $post_type = ''): string
{
	if ('' === $post_type) {
		$post_type = get_post_type();
	}

	if (! is_string($post_type)) {
		return '';
	}

	if ('post' === $post_type) {
		return 'category';
	}

	if (false !== $post_type) {
		$post_type = ucfirst($post_type);
		$class = "App\\PostTypes\\$post_type";

		if (class_exists($class)) {
			return $class::get_primary_taxonomy();
		}
	}
	return '';
}


function get_social_links()
{
	$links = [
		'facebook_link' => 'fa-facebook',
		'instagram_link' => 'fa-instagram',
		'twitter_link' => 'fa-x-twitter',
		'pinterest_link' => 'fa-pinterest',
		'youtube_link' => 'fa-youtube',
		'linkedin_link' => 'fa-linkedin',
		'flickr_link' => 'fa-flickr',
	];
	$social_links = [];
	foreach ($links as $key => $link) {
		if (get_field($key, "options") && !empty(get_field($key, "options"))) {
			$social_links[$link] = get_field($key, "options");
		}
	}
	return $social_links;
}

function component_corners()
{
	$fields = $GLOBALS['fields'];
	$corners = [
		'style' => '',
		'type' => get_has_field('component_cont_or_bg', 'container', $fields),
		'tlc' => get_has_field('component_tlc', 0, $fields),
		'trc' => get_has_field('component_trc', 0, $fields),
		'blc' => get_has_field('component_blc', 0, $fields),
		'brc' => get_has_field('component_brc', 0, $fields)
	];

	if (get_has_field('component_tlc', 0, $fields) > 0 || get_has_field('component_trc', 0, $fields) > 0 || get_has_field('component_blc', 0, $fields) > 0 || get_has_field('component_brc', 0, $fields) > 0) {
		$style = 'clip-path: polygon(';
		$style .= $corners['tlc'] . 'px 0, ';
		$style .= 'calc(100% - ' . $corners['trc'] . 'px) 0%, 100% ' . $corners['trc'] . 'px, ';
		$style .= '100% calc(100% - ' . $corners['brc'] . 'px), calc(100% - ' . $corners['brc'] . 'px) 100%, ';
		$style .= $corners['blc'] . 'px 100%, 0% calc(100% - ' . $corners['blc'] . 'px), ';
		$style .= '0 ' . $corners['tlc'] . 'px);';
		$corners['style'] = $style;
	}
	return $corners;
}

function component_corners_style($class = '')
{
	$fields = $GLOBALS['fields'];
	$style = '';
	$corners = [
		'style' => '',
		'type' => get_has_field('component_cont_or_bg', 'container', $fields),
		'tlc' => get_has_field('component_tlc', 0, $fields),
		'trc' => get_has_field('component_trc', 0, $fields),
		'blc' => get_has_field('component_blc', 0, $fields),
		'brc' => get_has_field('component_brc', 0, $fields)
	];

	$cornersMD = [
		'tlc' => get_has_field('component_tlc', 0, $fields) > 0 ? get_has_field('component_tlc', 0, $fields) / 2 : 0,
		'trc' => get_has_field('component_trc', 0, $fields) > 0 ? get_has_field('component_trc', 0, $fields) / 2 : 0,
		'blc' => get_has_field('component_blc', 0, $fields) > 0 ? get_has_field('component_blc', 0, $fields) / 2 : 0,
		'brc' => get_has_field('component_brc', 0, $fields) > 0 ? get_has_field('component_brc', 0, $fields) / 2 : 0
	];

	$cornersSM = [
		'tlc' => get_has_field('component_tlc', 0, $fields) > 0 ? get_has_field('component_tlc', 0, $fields) / 3 : 0,
		'trc' => get_has_field('component_trc', 0, $fields) > 0 ? get_has_field('component_trc', 0, $fields) / 3 : 0,
		'blc' => get_has_field('component_blc', 0, $fields) > 0 ? get_has_field('component_blc', 0, $fields) / 3 : 0,
		'brc' => get_has_field('component_brc', 0, $fields) > 0 ? get_has_field('component_brc', 0, $fields) / 3 : 0
	];

	if (get_has_field('component_tlc', 0, $fields) > 0 || get_has_field('component_trc', 0, $fields) > 0 || get_has_field('component_blc', 0, $fields) > 0 || get_has_field('component_brc', 0, $fields) > 0) {
		$style .= '<style type="text/css">.' . $class . '{';
		$style .= 'clip-path: polygon(';
		$style .= $corners['tlc'] . 'px 0, ';
		$style .= 'calc(100% - ' . $corners['trc'] . 'px) 0%, 100% ' . $corners['trc'] . 'px, ';
		$style .= '100% calc(100% - ' . $corners['brc'] . 'px), calc(100% - ' . $corners['brc'] . 'px) 100%, ';
		$style .= $corners['blc'] . 'px 100%, 0% calc(100% - ' . $corners['blc'] . 'px), ';
		$style .= '0 ' . $corners['tlc'] . 'px);';
		$style .= '} ';
		$style .= '@media(max-width: 991px){ ' . '.' . $class . '{';
		$style .= 'clip-path: polygon(';
		$style .= $cornersMD['tlc'] . 'px 0, ';
		$style .= 'calc(100% - ' . $cornersMD['trc'] . 'px) 0%, 100% ' . $cornersMD['trc'] . 'px, ';
		$style .= '100% calc(100% - ' . $cornersMD['brc'] . 'px), calc(100% - ' . $cornersMD['brc'] . 'px) 100%, ';
		$style .= $cornersMD['blc'] . 'px 100%, 0% calc(100% - ' . $cornersMD['blc'] . 'px), ';
		$style .= '0 ' . $cornersMD['tlc'] . 'px);';
		$style .= '}} ';
		$style .= '@media(max-width: 575px){ ' . '.' . $class . '{';
		$style .= 'clip-path: polygon(';
		$style .= $cornersSM['tlc'] . 'px 0, ';
		$style .= 'calc(100% - ' . $cornersSM['trc'] . 'px) 0%, 100% ' . $cornersSM['trc'] . 'px, ';
		$style .= '100% calc(100% - ' . $cornersSM['brc'] . 'px), calc(100% - ' . $cornersSM['brc'] . 'px) 100%, ';
		$style .= $cornersSM['blc'] . 'px 100%, 0% calc(100% - ' . $cornersSM['blc'] . 'px), ';
		$style .= '0 ' . $cornersSM['tlc'] . 'px);';
		$style .= '}}</style>';
		// $corners['style'] = $style;
	}
	return $style;
}

function days_since()
{
	$days = floor((current_time('timestamp') - get_the_time('U')) / (60 * 60 * 24));
	if ($days < 1) {
		$time = floor((current_time('timestamp') - get_the_time('U')) / (60 * 60));
		echo $time . 'h';
	} else {
		if ($days > 30) {
			echo '30d+';
		} else {
			echo $days . 'd';
		}
	}
}
