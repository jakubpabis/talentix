<?php
declare( strict_types = 1 );
namespace App\Setup;

class Blog {

	/**
	 * Initialization
	 * This method should be run from functions.php
	 */
	public static function init() {
		add_filter( 'get_the_archive_title', [ __CLASS__, 'blennder_archive_title' ] );
		add_filter( 'post_thumbnail_html', [ __CLASS__, 'post_thumbnail_html' ], 10, 5 );
	}


	/**
	 * Return the default image HTML
	 *
	 * This function is hooked to the `post_thumbnail_html` filter. If the
	 * contents of that filter are not empty, then return the HTML of the
	 * image set as the blog default image in the theme options.
	 *
	 * @param string       $html
	 * @param int          $post_id
	 * @param int          $post_thumbnail_id
	 * @param string|int[] $size
	 * @param string|array $attr
	 *
	 * @since 2.6.3
	 *
	 * @return string
	 */
	public static function post_thumbnail_html( string $html, int $post_id, int $post_thumbnail_id, $size, $attr ) : string {
		if( ! empty( $html ) ) {
			return $html;
		}
		$blog_default_image_id = get_theme_option( 'blog_default_image' );
		return wp_get_attachment_image( $blog_default_image_id, $size, false, $attr );
	}


	/**
	 * Blennder Archive Title
	 * Remove the Category/Tag/Taxonomy Prefix from archive titles
	 */
	public static function blennder_archive_title($title) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		}

		return $title;
	}
}
