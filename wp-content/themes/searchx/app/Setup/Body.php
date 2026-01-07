<?php
declare( strict_types = 1 );
namespace App\Setup;

class Body {

	/**
	 * Initialization
	 * This method should be run from functions.php
	 */
	public static function init() {
		add_action( 'wp_body_open', [ __CLASS__, 'wp_body_open' ] );
		add_filter( 'body_class', [ __CLASS__, 'body_class' ], 10, 2 );
	}

	/**
	 * WP Body Open
	 * Adds scripts and optional code to the beginning of the body tag
	 */
	public static function wp_body_open() {
		// Global options body scrips
		the_theme_option( 'global_body_open_scripts' );
	}

	/**
	 * Body Class
	 * Adds custom classes to the body tag
	 */
	public static function body_class( array $classes, array $class ) {

		// use home as body class instead of blog
		$classes = array_diff( $classes, [ 'blog' ] );
		if( is_home() ) {
			$classes[] = 'home';
		}

		if ( is_single() ) {
			// also need to be changed on single.php
			$classes[] = 'single--one';
		}

		if( true === get_field( 'header_transparent', get_the_ID() ) ) {
			$classes[] = 'header-transparent';
		}

		return $classes;
	}
}
