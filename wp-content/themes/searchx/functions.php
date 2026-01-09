<?php

/**
 * Blennd Theme Starter functions and definitions
 */


declare(strict_types=1);
define("THEME_VERSION", "1.0.2");

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

use App\Setup\ACF;
use App\Setup\Analytics;
use App\Setup\Media;
use App\Setup\REST;
use App\Setup\Scripts;
use App\Setup\Support;

use App\PostTypes\GlobalComponent;
// use App\PostTypes\Jobs;
use App\PostTypes\Testimonials;
use App\PostTypes\Team;
//use App\PostTypes\SEO;
// use App\PostTypes\Werken;
// use App\PostTypes\Prospect;

// Bail if ACF Pro is not installed
include_once ABSPATH . "wp-admin/includes/plugin.php";
if (!is_plugin_active("advanced-custom-fields-pro/acf.php")) {
	add_action("admin_notices", function () {
		echo '<div class="notice notice-error"><p>Warning: The Advanced Custom Fields PRO plugin is required for this theme.</p></div>';
	});
	return;
}

/**
 * Load the autoloader
 */
if (!class_exists("\App\Psr4AutoloaderClass")) {
	require __DIR__ . "/app/autoload.php";
}
$loader = new \App\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace("App", __DIR__ . "/app");

/**
 * Set up theme
 */
add_action("init", [new ACF(), "init"]);
App\Setup\Admin::init();
add_action("init", [new Analytics(), "init"]);
App\Setup\Blog::init();
App\Setup\Body::init();
App\Setup\Cleanup::init();
App\Setup\Client::init();
App\Setup\Footer::init();
App\Setup\Forms::init();
App\Setup\Header::init();
add_action("after_setup_theme", [new Media(), "init"], 5);
App\Setup\Menus::init();
App\Setup\Options::init();
add_action("init", [new REST(), "init"]);
add_action("init", [new Scripts(), "init"]);
add_action("after_setup_theme", [new Support(), "after_setup_theme"]);

/**
 * Set up post types and taxonomies
 */

new GlobalComponent();
new Testimonials();
new Team();
// new Jobs();
//new SEO();
// new Werken();
// new Prospect();

/**
 * Set up Gutenberg
 */
$gutenberg = new App\Gutenberg\Setup();
$gutenberg->init();

/**
 * Include Cron Job
 */
// require_once __DIR__ . "/inc/jobs-cron.php";

/**
 * Include Header Functions
 */
require_once __DIR__ . "/inc/header-functions.php";

/**
 * Include Output Helper Functions
 */
require_once __DIR__ . "/inc/output-helpers.php";

/**
 * Include Template tag Functions
 */
require_once __DIR__ . "/inc/template-tags.php";

/**
 * Include Theme Functions
 */
require_once __DIR__ . "/inc/theme-functions.php";

/**
 * Include Component Functions
 */
require_once __DIR__ . "/inc/component-functions.php";

/**
 * Include ACF Functions
 */
require_once __DIR__ . "/inc/acf-functions.php";

/**
 * Include Custom Styling
 */
require_once __DIR__ . "/inc/custom-styling.php";

// Prevent accessing posts with incomplete category hierarchy
add_filter('template_redirect', 'enforce_full_category_hierarchy');
function enforce_full_category_hierarchy()
{
	if (is_single()) {
		global $post, $wp_query;

		// Get the current category path from the request
		$current_category_path = get_query_var('category_name');

		// Get all categories for the current post
		$post_categories = get_the_terms($post->ID, 'category');

		if ($post_categories) {
			$is_valid_path = false;

			foreach ($post_categories as $category) {
				// Build full category path for this category
				$full_category_path = '';
				$current_cat = $category;
				$category_slugs = [];

				while ($current_cat) {
					$category_slugs[] = $current_cat->slug;
					if ($current_cat->parent == 0) break;
					$current_cat = get_term($current_cat->parent, 'category');
				}

				$full_category_path = implode('/', array_reverse($category_slugs));

				// Check if the requested path matches the full category path
				if ($full_category_path === $current_category_path) {
					$is_valid_path = true;
					break;
				}
			}

			// If no valid path is found, return a 404
			if (!$is_valid_path) {
				$wp_query->set_404();
				status_header(404);
				include(get_query_template('404'));
				exit;
			}
		}
	}
}

// Modify permalink to include full category hierarchy
add_filter('post_link', 'custom_hierarchical_post_permalink', 10, 3);
function custom_hierarchical_post_permalink($permalink, $post, $leavename)
{
	$categories = get_the_terms($post->ID, 'category');

	if (!$categories) {
		return $permalink;
	}

	// Find the most nested category
	$deepest_category = null;
	$max_depth = 0;

	foreach ($categories as $category) {
		$depth = 0;
		$current = $category;

		while ($current->parent != 0) {
			$depth++;
			$current = get_term($current->parent, 'category');
		}

		if ($depth > $max_depth) {
			$max_depth = $depth;
			$deepest_category = $category;
		}
	}

	if (!$deepest_category) {
		$deepest_category = reset($categories);
	}

	// Build full category path
	$full_category_path = '';
	$current = $deepest_category;
	$category_slugs = [];

	while ($current) {
		$category_slugs[] = $current->slug;
		if ($current->parent == 0) break;
		$current = get_term($current->parent, 'category');
	}

	$full_category_path = implode('/', array_reverse($category_slugs));

	return str_replace('%category%', $full_category_path, $permalink);
}

// require_once __DIR__ . "/inc/jobs-functions.php";

function search_by_title_only($search, $wp_query)
{
	global $wpdb;
	if (empty($search) || empty($wp_query->query_vars['search_terms'])) {
		return $search;
	}
	$search = '';
	$searchand = '';
	foreach ((array) $wp_query->query_vars['search_terms'] as $term) {
		$term = esc_sql($wpdb->esc_like($term));
		$search .= "{$searchand}($wpdb->posts.post_title LIKE '%{$term}%')";
		$searchand = ' AND ';
	}
	if (! empty($search)) {
		$search = " AND ({$search}) ";
		if (! is_user_logged_in())
			$search .= " AND ($wpdb->posts.post_password = '') ";
	}
	return $search;
}
add_filter('posts_search', 'search_by_title_only', 500, 2);

function sative_whitepapers_form_submit()
{

	$jobArray = array(
		'post_type'     => 'whitepapers-users',
		'post_status'   => 'private',
		'post_title'    => $_POST['whitepapers-email']
	);

	if (!post_exists($_POST['whitepapers-email'])) {
		$postID = wp_insert_post($jobArray, true);
		if ($_POST['whitepapers-filename']) {
			update_field('filename', $_POST['whitepapers-filename'], $postID);
		}
	}

	$link = $_POST['whitepapers-url'];

	header("Location: $link");
}
add_action('admin_post_nopriv_whitepapers_form', 'sative_whitepapers_form_submit');
add_action('admin_post_whitepapers_form', 'sative_whitepapers_form_submit');

function custom_post_type_whitepapers_users()
{

	// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x('Whitepapers Users', 'Post Type General Name', 'sative'),
		'singular_name'       => _x('Whitepapers Users', 'Post Type Singular Name', 'sative'),
		'menu_name'           => __('Whitepapers Users', 'sative'),
		'parent_item_colon'   => __('Parent Whitepapers Users', 'sative'),
		'all_items'           => __('All Whitepapers Users', 'sative'),
		'view_item'           => __('View Whitepapers Users', 'sative'),
		'add_new_item'        => __('Add New Whitepapers Users', 'sative'),
		'add_new'             => __('Add New', 'sative'),
		'edit_item'           => __('Edit Whitepapers Users', 'sative'),
		'update_item'         => __('Update Whitepapers Users', 'sative'),
		'search_items'        => __('Search Whitepapers Users', 'sative'),
		'not_found'           => __('Not Found', 'sative'),
		'not_found_in_trash'  => __('Not found in Trash', 'sative'),
	);

	// Set other options for Custom Post Type
	$args = array(
		'label'               => __('whitepapers-users', 'sative'),
		'description'         => __('Whitepapers Users', 'sative'),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array('title', 'custom-fields'),
		// You can associate this CPT with a taxonomy or custom taxonomy.
		'taxonomies'          => array(),
		/* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => false,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-groups',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => 'post',
	);
	// Registering your Custom Post Type
	register_post_type('whitepapers-users', $args);
}
/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/
add_action('init', 'custom_post_type_whitepapers_users', 0);

add_action('acf/include_fields', function () {
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(array(
		'key' => 'group_5eefec860543f',
		'title' => 'Whitepapers',
		'fields' => array(
			array(
				'key' => 'field_5eefec862bd53',
				'label' => 'File to download',
				'name' => 'file_download',
				'aria-label' => '',
				'type' => 'file',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'library' => 'all',
				'min_size' => '',
				'max_size' => '',
				'mime_types' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'tpl_article.php',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => false,
	));

	acf_add_local_field_group(array(
		'key' => 'group_64db13bd60d60',
		'title' => 'Whitepapers Users Filename',
		'fields' => array(
			array(
				'key' => 'field_64db13bd17efc',
				'label' => 'Filename',
				'name' => 'filename',
				'aria-label' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'translations' => 'ignore',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'whitepapers-users',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	));
});

function talentix_hide_admin_bar()
{
	return false;
}
add_filter('show_admin_bar', 'talentix_hide_admin_bar');
