<?php

declare(strict_types=1);

/**
 * Template Tags
 */


/**
 * Return the HTML tag.
 *
 * @since 0.7.0
 *
 * @param string  $tag        The HTML tag.
 * @param array   $attributes Attributes for the HTML tag.
 * @param string  $content    Content inside the HTML tag.
 *
 * @return string Returns the HTML tag with attributes.
 */
function get_the_tag($tag, $attributes, $content)
{
	return sprintf(
		'<%1$s %2$s>%3$s</%4$s>',
		$tag,
		get_html_atts($attributes),
		$content,
		$tag
	);
}

/**
 * Echo the HTML tag.
 *
 * @since 0.7.3
 *
 * @param string  $tag        The HTML tag.
 * @param array   $attributes Attributes for the HTML tag.
 * @param string  $content    Content inside the HTML tag.
 */
function the_tag(string $tag, array $attributes, string $content)
{
	echo get_the_tag($tag, $attributes, $content);
}

/**
 * Return an HTML element with attributes.
 *
 * @since 0.7.0
 *
 * @param string $tag        The HTML tag.
 * @param array  $attributes Attributes for the HTML tag.
 *
 * @return string Returns the HTML tag with attributes.
 */
function get_the_single_tag($tag, $attributes)
{
	return sprintf(
		'<%1$s %2$s/>',
		$tag,
		get_html_atts($attributes)
	);
}

/**
 * Return an HTML element with attributes.
 *
 * @since 0.7.3
 *
 * @param  string $tag        The HTML tag.
 * @param  array  $attributes Attributes for the HTML tag.
 *
 * @return string Echo the HTML tag with attributes.
 */
function the_single_tag($tag, $attributes)
{
	echo get_the_single_tag($tag, $attributes);
}

/**
 * Print HTML with meta information for the current post (category, tags and permalink).
 *
 * @since 0.7.0
 *
 * @param string $type The type of taxonomy
 */
function blennder_posted_in($type = 'category')
{
	// Retrieves tag list of current post, separated by commas.
	if ($type == 'category') {
		$list = '';
		if (is_object_in_taxonomy(get_post_type(), 'category')) {
			$posted_in = 'Category: %1$s';
			$list = get_the_category_list(', ');
		} else {
			$posted_in = '';
		}
	} elseif ($type == 'tag') {
		$list = get_the_tag_list('', ', ');
		if ($list && ! is_wp_error($list)) {
			$posted_in = 'Tags: %1$s';
		} else {
			$posted_in = '';
		}
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		$list
	);
}

/**
 * Get related posts by tag to the current post
 *
 * @since 0.7.0
 * @since 2.6.0 Updated WP_Query logic to improve performance.
 *
 * @param int $num (optional) An integer number of related posts.
 *
 * @return \WP_Query The WP_Query object for the related posts.
 */
function blennder_related_posts(int $num = 3): WP_Query
{

	$post_id = get_the_ID();
	$tags = wp_get_post_tags($post_id, ['fields' => 'ids']);
	$the_query = new WP_Query([
		'posts_per_page'         => $num + 1,
		'no_found_rows'          => true,
		'ignore_sticky_posts'    => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	]);

	// Don't show the current post
	foreach ($the_query->posts as $key => $thePost) {
		if ($thePost->ID === $post_id) {
			unset($the_query->posts[$key]);
		}
	}
	return $the_query;
}

/**
 * Social Media Icons
 *
 * Output the social media icons list based on
 * the links added in global theme options
 *
 * @since 0.7.5
 */
function social_media_icons()
{
	$social_media = array(
		array(
			'name' => 'facebook',
			'icon' => 'facebook-f',
		),
		array(
			'name' => 'instagram',
			'icon' => 'instagram',
		),
		array(
			'name' => 'twitter',
			'icon' => 'x-twitter',
		),
		array(
			'name' => 'youtube',
			'icon' => 'youtube',
		),
		array(
			'name' => 'linkedin',
			'icon' => 'linkedin-in',
		),
		array(
			'name' => 'pinterest',
			'icon' => 'pinterest',
		),
		array(
			'name' => 'flickr',
			'icon' => 'flickr',
		),
		array(
			'name' => 'tiktok',
			'icon' => 'tiktok',
		),
	);

?>
	<ul class="social-share d-flex list-unstyled">
		<?php
		foreach ($social_media as $sm) {
			$link = get_has_theme_option($sm['name'] . '_link', '');
			if ($link) {
				printf(
					'<li class="social-icon list-inline-item">%s</li>',
					sprintf(
						'<a href="%s" title="%s" class="%s" target="_blank"> %s %s </a>',
						esc_url($link),
						ucfirst($sm['name']),
						'social-' . $sm['name'],
						sprintf(
							'<i class="fab fa-%s"></i>',
							$sm['icon']
						),
						sprintf(
							'<span class="visually-hidden">%s</span>',
							ucfirst($sm['name'])
						)
					)
				);
			}
		}
		?>
	</ul>
<?php
}

/**
 * Fallback menu if the footer legal nav menu is not assigned
 *
 * @since 0.7.5
 */
function footer_legal_fallback()
{
	$links = [
		[
			'url' => get_privacy_policy_url(),
			'title' => 'Privacy Policy',
			'value' => 'Privacy Policy',
			'target' => '_self',
		],
		[
			'url' => esc_url(home_url('sitemap_index.xml')),
			'title' => 'Sitemap',
			'value' => 'Sitemap',
			'target' => '_self',
		],
	];
?>
	<ul id="footer-legal" class="footer-legal">
		<?php foreach ($links as $link) : ?>
			<li class="menu-item list-inline-item">
				<?php
				printf(
					'<a class="footer-legal__link" href="%1$s" title="%2$s" target="%3$s">%4$s</a>',
					$link['url'],
					$link['title'],
					$link['target'],
					$link['value']
				);
				?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php
}

/**
 * Outputs the search form.
 *
 * @since 0.7.3
 *
 * @param array $args {
 *     Optional. Array of display arguments.
 *
 *     @type string $title            The title of the form.
 *     @type string $placeholder      The placeholder of the form.
 *     @type string $aria-label       ARIA label for the search form. Useful to distinguish
 *                                    multiple search forms on the same page and improve
 *                                    accessibility. Default empty.
 *     @type string $aria-describedby ARIA label for the search form. Useful to distinguish
 *                                    multiple search forms on the same page and improve
 *                                    accessibility. Default empty.
 *     @type array $button {
 *       @type string 'class'         The button class.
 *       @type string 'text'          The button text.
 *     }
 *  }
 */
function blennder_search_form(array $args = array())
{
	global $blennder_search_form_atts;
	$default_args              = array(
		'form_id'          => 'search',
		'form_class'       => 'search-form h-100',
		'input_id'         => 'search-input',
		'title'            => pll__('Search'),
		'placeholder'      => pll__('Search articles...'),
		'aria-label'       => pll__('Search'),
		'aria-describedby' => 'search-btn',
		'button'           => array(
			'class' => 'btn btn-primary',
			'text'  => '<i class="fas fa-search"></i> ' . pll__('Search'),
		),
	);
	$blennder_search_form_atts = wp_parse_args($args, $default_args);
	get_search_form();
}

/**
 * Print the search query results.
 *
 * @since 0.9.0
 */
function the_search_query_results()
{
	global $wp_query;
	$total = $wp_query->found_posts;
	$page  = $wp_query->query['paged'] ?? 1;
	$per   = $wp_query->query_vars['posts_per_page'];
	$low   = ($page - 1) * $per + 1;
	$high  = $low + $per - 1;
	if ($high > $total) {
		$high = $total;
	}
	echo "$low - $high of $total";;
}

/**
 * Output the posts pagination.
 *
 * @since 2.7.0
 */
function posts_pagination()
{
	the_posts_pagination([
		'mid_size'  => 3,
		'end_size' => 2,
		'show_all' => false,
		'prev_text' => '<i class="far fa-xl fa-arrow-left-long"></i> <span class="sr-only">' . __('Previous') . '</span>',
		'next_text' => '<span class="sr-only">' . __('Next') . '</span> <i class="far fa-xl fa-arrow-right-long"></i>',
	]);
}
