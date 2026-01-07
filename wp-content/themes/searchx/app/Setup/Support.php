<?php
declare( strict_types = 1 );
namespace App\Setup;

/**
 * Class to register theme support
 *
 * @since 0.7.0
 */
final class Support {

	/**
	 * Adds theme support for various options
	 *
	 * @since 0.7.0
	 *
	 * @return void
	 */
	public function after_setup_theme() : void {
		add_post_type_support( 'page', 'excerpt' );

		add_theme_support( 'custom-logo', [
			'width'       => 250,
			'height'      => 40,
			'flex-height' => true,
		] );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		// add_theme_support( 'woocommerce' );
	}

}
