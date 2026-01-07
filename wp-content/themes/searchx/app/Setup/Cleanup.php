<?php
declare( strict_types = 1 );
namespace App\Setup;

class Cleanup
{
	/**
	 * Initialization
	 * This method should be run from functions.php
	 */
	public static function init()
	{
		add_action( 'init', [ __CLASS__, 'cleanup_head' ] );
		add_filter( 'redirect_canonical', [ __CLASS__, 'remove_author_from_redirects' ], 10, 2 );
	}

	public static function remove_author_from_redirects( $redirect, $request ) {
		if( !is_admin() && preg_match('/author=([0-9]*)/i', $_SERVER['QUERY_STRING']) ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			get_template_part( 404 );
			exit;
		}
		return $redirect;
	}


	/**
	 * Cleanup the head of our application
	 */
	public static function cleanup_head()
	{
		// EditURI link.
		remove_action( 'wp_head', 'rsd_link' );
		// Category feed links.
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		// Post and comment feed links.
		remove_action( 'wp_head', 'feed_links', 2 );
		// Windows Live Writer.
		remove_action( 'wp_head', 'wlwmanifest_link' );
		// Index link.
		remove_action( 'wp_head', 'index_rel_link' );
		// Previous link.
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
		// Start link.
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		// Canonical.
		remove_action( 'wp_head', 'rel_canonical', 10, 0 );
		// Shortlink.
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		// Links for adjacent posts.
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		// WP version.
		remove_action( 'wp_head', 'wp_generator' );
		// Emoji detection script.
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		// Emoji styles.
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		// Remove duotone filters
		remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
		remove_action( 'in_admin_header', 'wp_global_styles_render_svg_filters' );
	}
}
