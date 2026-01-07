<?php

declare(strict_types=1);

/**
 * ACF display helper functions.
 *
 * These functions are included to reduce duplicate code and ease in new website
 * development. The API for these functions will be frozen on release of v1.0.
 * These functions **SHOULD NOT** be edited as it will almost certainly cause
 * unintended side effects. Please open a Github issue if you experience
 * problems or bugs with these functions.
 *
 * @see https://www.advancedcustomfields.com/resources/
 *
 * @version 1.0.0
 *
 * @since 0.7.4
 */

/**
 * Pre-process the ACF field array
 *
 * This is an internal function and should not be used outside of the
 * following ACF display functions.
 *
 * @since 0.7.4
 *
 * @param string $field
 * @param array  $fields
 * @param string $return
 *
 * @return mixed
 */
function _acf_process(string $field, array $fields = [], string $return = 'value')
{
	if (empty($fields)) {
		$fields = $GLOBALS['fields'] ?? null;
	}

	if (empty($fields[$field])) {
		return null;
	}
	if (
		is_array($fields[$field]) &&
		isset($fields[$field][$return])
	) {
		$fields[$field] = $fields[$field][$return];
	}
	return $fields[$field];
}

/**
 * Print an ACF text field.
 *
 * @since 0.7.4
 *
 * @param string $field  The ACF text field to print.
 * @param array  $fields The ACF $fields array. Useful for repeater fields.
 */
function acf_text(string $field, array $fields = [])
{
	echo _acf_process($field, $fields);
}

/**
 * Print an ACF text field with attributes.
 *
 * @since 0.7.4
 *
 * @param string $field  The ACF text field to print.
 * @param array  $atts   An array of attributes to add to the paragraph tags.
 * @param array  $fields The ACF $fields array. Useful for repeater fields.
 */
function acf_wysiwyg(string $field, array $atts = [], array $fields = [])
{
	$value = _acf_process($field, $fields);
	// $atts['data-aos'] = 'fade';
	echo str_replace(array('<p', '<ul', '<ol', '<span', '<h1', '<h2', '<h3', '<h4', '<h5', '<h6'), array('<p ' . get_html_atts($atts), '<ul ' . get_html_atts($atts), '<ol ' . get_html_atts($atts), '<span ' . get_html_atts($atts), '<h1 ' . get_html_atts($atts), '<h2 ' . get_html_atts($atts), '<h3 ' . get_html_atts($atts), '<h4 ' . get_html_atts($atts), '<h5 ' . get_html_atts($atts), '<h6 ' . get_html_atts($atts)), strval($value));
}

/**
 * Print an ACF link field.
 *
 * @since 0.7.4
 *
 * @param string $field  The ACF text field to print.
 * @param array  $atts   An array of attributes to add to the anchor tags.
 * @param array  $fields The ACF $fields array. Useful for repeater fields.
 */
function acf_link(string $field, array $attr = [], array $fields = [])
{
	$value = _acf_process($field, $fields);
	$show_icon = get_field('button_icon_choosed', "options");
	$icon = '';
	if (!empty($show_icon)) {
		$string = get_html_atts($attr);
		$pattern = '/' . implode('|', $show_icon) . '/i';
		if (preg_match($pattern, $string)) {
			$icon = get_field('button_icon', "options") ? get_field('button_icon', "options") : '';
		}
	}
	if ($value === null) {
		return;
	}
	$attr['href']   = $value['url'] ?? $attr['href'] ?? '';
	$attr['title']  = $value['title'] ?? $attr['title'] ?? '';
	$attr['target'] = ! empty($value['target']) ? $value['target'] : $attr['target'] ?? '_self';
	printf(
		'<a %1$s>%2$s%3$s</a>',
		get_html_atts($attr),
		$value['title'] ? '<span>' . $value['title'] . '</span>' : '',
		$icon,
	);
}

/**
 * Print then ACF link from a single field.
 *
 * @since 0.7.4
 *
 * @param mixed $link (optional) The array for the link.
 * @param array $attr (optional) An array of attributes to pass to acf_link()
 */
function acf_single_link($link = null, array $attr = [])
{
	if (! array($link)) {
		return;
	}
	acf_link('link', $attr, ['link' => $link]);
}

/**
 * Print an ACF image.
 *
 * @since 0.7.4
 *
 * @param string $field  The ACF field name.
 * @param mixed  $size   (Optional) The display size of the image.
 * @param array  $attr   (Optional) Attributes for the image.
 * @param array  $fields (Optional) The $fields array. Useful for repeaters.
 */
function acf_image(string $field, $size = 'thumbnail', array $attr = [], array $fields = [])
{
	$img = _acf_image_process($field, $size, $attr, $fields);
	echo $img['src'];
}

/**
 * Print an ACF image.
 *
 * @since 2.7.1
 *
 * @param int    $post_id The post_id of the image to display.
 * @param mixed  $size    (Optional) The display size of the image.
 * @param array  $attr    (Optional) Attributes for the image.
 */
function acf_single_image(int $post_id, $size = 'thumbnail', array $attr = [])
{
	$url = wp_get_attachment_image_url($post_id, $size);
	acf_image('url', $size, $attr, ['url' => $url]);
}

/**
 * Output a background image.
 *
 * @since 0.7.4
 * @since 0.7.6 Function signature changed to be consistent with acf_image().
 *
 * @param string $field  The ACF field name.
 * @param mixed  $size   (Optional) The display size of the image.
 * @param array  $attr   (Optional) Attributes for the image.
 * @param array  $fields (Optional) The $fields array. Useful for repeaters.
 */
function acf_background_image(string $field, $size = 'thumbnail', array $attr = [], array $fields = [])
{
	$img = _acf_image_process($field, $size, $attr, $fields);
	$defaults = [
		'class' => ['acf-background-image'],
		'style' => ["background-image: url({$img['url']});"],
	];
	$attr = array_merge_recursive($attr, $defaults);
	the_tag('div', $attr, '');
}

/**
 * Print an ACF image gallery.
 *
 * @since 0.7.4
 *
 * @param string $field  The ACF field name.
 * @param mixed  $size   (Optional) The display size of the image.
 * @param array  $attr   (Optional) Attributes for the image.
 * @param array  $fields (Optional) The $fields array. Useful for repeaters.
 */
function acf_gallery(string $field, $size = 'thumbnail', array $attr = [], array $fields = [])
{
	$gallery = _acf_process($field, $fields);
	foreach ($gallery as $key => $item) {
		$img = _acf_image_process($key, $size, $attr, $gallery);
		echo $img['src'];
	}
}

/**
 * Return a WordPress attachment image.
 *
 * ACF returns an image as either an Image URL, Image, ID, or Image Array.
 * This function processes the output of ACF and prints an image. If the
 * image is part of the WordPress media library, it does so using the
 * `wp_get_attachment_image()` function which prints attributes for the
 * alt text, lazy loading, and srcset.
 *
 * @since 0.7.4
 *
 * @param string $field  The ACF field name.
 * @param mixed  $size   (Optional) The display size of the image.
 * @param array  $attr   (Optional) Attributes for the image.
 * @param array  $fields (Optional) The $fields array. Useful for repeaters.
 *
 * @return array
 */
function _acf_image_process(string $field, $size = 'thumbnail', array $attr = [], array $fields = [])
{
	$img = _acf_process($field, $fields);

	// Make sure all elements of $attr are string as required by WordPress
	foreach ($attr as $key => $att) {
		if (
			is_string($att)
		) {
			// Already a string!
			continue;
		} else if (
			is_array($att) &&
			array_sum(array_map('is_string', $att)) == count($att)
		) {
			$attr[$key] = implode(' ', $att);
		} else {
			unset($attr[$key]);
		}
	}

	// The image does not exist. Return early.
	if (is_null($img)) {
		return _acf_image_process_invalid();
	}

	// ACF is set to return an Image URL or the field is a string literal.
	if (is_string($img)) {
		$id = attachment_url_to_postid($img);
	}

	// The image set is a string but not in the WordPress media library.
	if (isset($id) && 0 === $id) {
		$attr = wp_parse_args(['src' => $img], $attr);
		return [
			'id'  => null,
			'url' => $img,
			'src' => get_the_single_tag('img', $attr),
		];
	}

	// ACF is set to return an Image ID
	if (isset($id) && is_integer($id)) {
		$img = $id;
	}

	// ACF is set to return an Image Array
	if (is_array($img)) {
		if (! isset($img['id'])) {
			// This should never happen. Congratulations!
			return _acf_image_process_invalid();
		}
		$img = $img['id'];
	}

	if (! is_integer($img)) {
		// $img should be an interger at this point. If it's not, return because
		// something went terribly wrong.
		return _acf_image_process_invalid();
	}

	return [
		'id'  => $img,
		'url' => wp_get_attachment_image_url($img, $size),
		'src' => wp_get_attachment_image($img, $size, false, $attr),
	];
}

/**
 * Return an invalid ACF image.
 *
 * @since 0.7.4
 *
 * @return array An array with invalid data.
 */
function _acf_image_process_invalid()
{
	return [
		'id'  => -1,
		'url' => '',
		'src' => '',
	];
}

/**
 * Returns the ACF URL.
 *
 * @since 0.7.4
 *
 * @param string $field  The ACF field for the URL.
 * @param array  $fields (optional) The ACF $fields array.
 */
function acf_url(string $field, array $fields = []): string
{
	$url = _acf_process($field, $fields);
	if (is_string($url)) {
		return $url;
	}
	if (is_array($url) && ! empty($url['url'])) {
		return $url['url'];
	}
	return '';
}

/**
 * Returns the conditional logic necessary for the field to show on specific templates.
 *
 * The function takes the component and an array of templates to create the necessary
 * ACF conditional logic to display the ACF field only on the templates specified. It
 * uses the ACF `OR` logic when the value is equal to the template name. The template
 * names should use the full filename of the template - minus the extension. An example
 * usage to show a field only on the blog-grid template would be:
 *
 * `'conditional_logic' => acf_block_conditional_logic( 'blog', [ 'blog-grid' ] ),`
 *
 * @since 2.7.8
 *
 * @param string $component The component to which this conditional logic applies.
 * @param array  $templates The template strings where the field should be shown.
 *
 * @return array The ACF conditional logic array.
 */
function acf_block_conditional_logic(string $component, array $templates): array
{

	$block_template_field_name = '34923ioqwneadfaweae';
	$conditional_logic = [];

	foreach ($templates as $template) {

		$conditional_logic[] = [
			[
				'field' => 'field_' . md5($component) . $block_template_field_name,
				'operator' => '==',
				'value' => component_relpath($template, $component),
			]
		];
	}

	return $conditional_logic;
}
