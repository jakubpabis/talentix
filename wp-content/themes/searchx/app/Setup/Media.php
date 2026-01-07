<?php
declare( strict_types = 1 );
namespace App\Setup;

/**
 * Class to register and manipulate media sizes
 *
 * @since 0.7.0
 */
final class Media {


	/**
	 * Add filters and actions to manipulate media.
	 *
	 * @since 0.7.0
	 *
	 * @return void
	 */
	public function init() : void {
		\add_action( 'after_setup_theme', [ $this, 'set_post_thumbnail_size' ] );
		\add_action( 'after_setup_theme', [ $this, 'add_image_sizes' ] );
		\add_filter( 'embed_oembed_html', [ $this, 'responsive_embeds'], 10, 3 );
		\add_filter( 'wp_get_attachment_link_attributes', [ $this, 'wp_get_attachment_link_attributes' ], 10, 2 );
	}


	/**
	 * Sets default thumbnail size
	 *
	 * @since 0.7.0
	 *
	 * @return void
	 */
	public function set_post_thumbnail_size() : void {
		\set_post_thumbnail_size( 1440, 9999 );
	}


	/**
	 * Add Custom Image Sizes
	 *
	 * @since 0.7.0
	 *
	 * @return void
	 */
	public function add_image_sizes() : void {
		add_image_size( 'blog_feed', 600, 350, true) ;
		add_image_size( 'blog_card', 420, 440, true );
		add_image_size( 'gallery', 500, 500, true );
		add_image_size( 'gallery_tall', 660, 750, true );
		add_image_size( 'menu_image', 500, 300, true );
		add_image_size( 'team', 540, 450, [ 'center','top' ] );
		add_image_size( 'video', 1280, 768, true );
	}

	/**
	 * Add fancybox attribute to attachment links.
	 *
	 * @since 0.7.0
	 * @since 2.7.6 Use new wp_get_attachment_link_attributes filter
	 *
	 * @param array $attributes
	 * @param int $post_id
	 *
	 * @return array
	 */

	function wp_get_attachment_link_attributes( array $attributes, int $post_id ) : array {
		$attributes[ 'data-fancybox' ] = 'gallery';
		return $attributes;
	}


	/**
	 * Wrap all oEmbed objects in an embed container div for responsive.
	 *
	 * @since 0.7.0
	 *
	 * @param string $html
	 * @param string $url
	 * @param array  $attr
	 *
	 * @return string
	 */
	public function responsive_embeds( string $html, string $url, array $attr ) : string {
		return "<div class=\"embed-responsive embed-responsive-16by9\">$html</div>";
	}
}
