<?php
declare( strict_types = 1 );
namespace App\Setup;

class Analytics {

	/**
	 * @since 2.6.3
	 * @var string
	 */
	protected $GTM = '';

	/**
	 * Conditionally add actions to load the GTM scripts
	 *
	 * @since 2.6.3
	 */
	public function init() {

		$this->GTM = get_has_theme_option( 'google_analytics', '' );

		if( '' !== $this->GTM ) {
			add_action( 'wp_head', [ $this, 'google_analytics_head' ], 0 );
			add_action( 'wp_body_open', [ $this, 'google_analytics_body' ] );
		}
	}


	/**
	 * Output the script GTM code
	 *
	 * @since 2.6.3
	 */
	public function google_analytics_head() {
		echo "\n<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-{$this->GTM}');</script>\n";
	}


	/**
	 * Output the noscript GTM code
	 *
	 * @since 2.6.3
	 */
	public function google_analytics_body() {
		echo "\n<noscript><iframe src='https://www.googletagmanager.com/ns.html?id=GTM-{$this->GTM}' height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>\n";
	}
}
