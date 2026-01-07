<?php
declare( strict_types = 1 );
namespace App\Setup;

class Header {

	/**
	 * Initialization
	 * This method should be run from functions.php
	 */
	public static function init() {
		add_action( 'wp_head', [ __CLASS__, 'wp_head' ] );
	}

	/**
	 * WP Head
	 * Adds custom script to the head tag from global and page level options
	 */
	public static function wp_head() {
		// Output the global custom header tag code
		the_theme_option( 'global_head_scripts' );
	}
}
