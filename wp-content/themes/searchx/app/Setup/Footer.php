<?php
declare( strict_types = 1 );
namespace App\Setup;

class Footer {

	/**
	 * Initialization
	 */
	public static function init() {
		add_action( 'wp_footer', [ __CLASS__, 'wp_footer' ] );
	}

	/**
	 * wp_footer
	 * Add code at the end of the body tag
	 */
	public static function wp_footer() {
		the_theme_option( 'global_footer_scripts' );
	}
}
