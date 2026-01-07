<?php

declare(strict_types=1);

namespace App\Setup;

/**
 * Class to register and enqueue styles and scripts.
 *
 * @since 2.6.0
 */
class Scripts
{


	/**
	 * Registered components array.
	 *
	 * @since 2.6.0
	 * @var array []
	 */
	protected $components = [];

	/**
	 * Registered components array.
	 *
	 * @since 2.7.6
	 * @var string
	 */
	protected $firstComponent = '';


	/**
	 * Add filters and actions to register styles and scripts.
	 *
	 * @since 2.6.0
	 *
	 * @return void
	 */
	public function init(): void
	{
		add_filter('wp_resource_hints', [$this, 'resource_hints'], 10, 2);
		add_filter('style_loader_tag', [$this, 'style_loader_tag'], 10, 4);
		add_filter('script_loader_tag', [$this, 'script_loader_tag'], 10, 3);
		add_action('load-post.php', [$this, 'register_styles_and_scripts']);
		add_action('admin_enqueue_scripts', [$this, 'register_styles_and_scripts']);
		add_action('wp_enqueue_scripts', [$this, 'register_styles_and_scripts']);
	}


	/**
	 * Add DNS prefetch resource hints.
	 *
	 * DNS prefetching may decrease page load times. Only domains that are
	 * loaded on all pages should be prefetched.
	 *
	 * @param array $hints
	 * @param string $relation_type
	 *
	 * @since 2.6.0
	 *
	 * @return array
	 */
	public function resource_hints(array $hints, string $relation_type)
	{
		if ('dns-prefetch' === $relation_type) {
			$hints = array_merge($hints, [
				'https://cdnjs.cloudflare.com',
			]);
		}
		if ('preconnect' === $relation_type) {
			$hints = array_merge($hints, [
				'//fonts.googleapis.com',
				'//fonts.gstatic.com',
			]);
		}
		return $hints;
	}


	/**
	 * Preload select CSS links.
	 *
	 * To improve page speed, some assets are transformed from
	 * <link rel="stylesheet"> elements to <link rel="preload"> elements. The
	 * original styles are still loaded in <noscript> tags for browsers with
	 * javascript disabled.
	 *
	 * @param string $tag
	 * @param string $handle
	 * @param string $href
	 * @param string $media
	 *
	 * @since 2.6.0
	 *
	 * @return string
	 */
	public function style_loader_tag(string $tag, string $handle, string $href, string $media): string
	{
		$orig = trim($tag);
		if (
			'fancybox' === $handle ||
			'aos' === $handle ||
			'swiper' === $handle ||
			'wp-block-library' === $handle ||
			'wp-block-library-theme' === $handle ||
			'wc-blocks-style' === $handle
		) {
			$tag = str_replace("rel='stylesheet'", "rel='preload' as='style'", $tag);
			$tag = '<link rel="preload" href="' . $href . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
			$tag .= "<noscript>$orig</noscript>\n";
		}
		return $tag;
	}

	/**
	 * Defer select JS links.
	 *
	 * To improve page speed, some assets are transformed from
	 * <script> elements to <script defer> elements.
	 *
	 * The main script, the component scripts, and 3rd-pary scripts
	 * enqueued by the theme are deferred by default.
	 *
	 * @param string $tag
	 * @param string $handle
	 * @param string $src
	 *
	 * @since 2.6.0
	 *
	 * @return string
	 */
	public function script_loader_tag($tag, $handle, $src)
	{

		$defer = [
			'aos' => true,
			'bootstrap' => true,
			'fancybox' => true,
			'fontawesome' => true,
			'imagesloaded' => true,
			'main' => true,
		];

		if (empty($this->components)) {
			$dir = get_stylesheet_directory() . '/components';
			$dirs = array_filter(glob("$dir/*"), 'is_dir');
			foreach ($dirs as $key => $dir) {
				$path = pathinfo($dir);
				$block = $path['basename'] ?? '';
				$this->components[$block] = true;
			}
		}

		$defer = array_merge($defer, $this->components);

		if (isset($defer[$handle])) {
			$tag = str_replace('<script ', '<script defer ', $tag);
		}

		return $tag;
	}


	/**
	 * Register styles and scripts.
	 *
	 * @since 2.6.0
	 *
	 * @return void
	 */
	public function register_styles_and_scripts(): void
	{
		//wp_enqueue_style( 'open-sans', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800' );
		// Move jQuery to the footer
		wp_scripts()->add_data('jquery', 'group', 1);
		wp_scripts()->add_data('jquery-core', 'group', 1);
		wp_scripts()->add_data('jquery-migrate', 'group', 1);

		wp_register_style('adobe', 'https://use.typekit.net/qpw5hyo.css', [], '1.0.0');

		// Register dependencies
		wp_register_style('aos', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css', [], '2.3.4');
		wp_register_script('aos', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js', ['jquery'], '2.3.4', true);

		wp_enqueue_style('header', get_stylesheet_directory_uri() . '/dist/css/header.css', [], THEME_VERSION);

		wp_register_style('bootstrap', get_stylesheet_directory_uri() . '/dist/css/bootstrap.css', [], '5.3.0');
		wp_register_script('bootstrap', get_stylesheet_directory_uri() . '/dist/js/bootstrap.js', [], '5.3.0', true);

		wp_register_style('fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css', [], '3.5.7');
		wp_register_script('fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', ['jquery'], '3.5.7', true);

		wp_enqueue_script('fontawesome', 'https://kit.fontawesome.com/2ab395ec92.js', [], '6.6.0', true); // pro
		//wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css', [], '6.6.0'); // free

		wp_register_script('imagesloaded', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.min.js', [], '4.1.4', true);

		wp_register_style('swiper', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.0.7/swiper-bundle.min.css', [], '8.0.7');
		wp_register_script('swiper', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.0.7/swiper-bundle.min.js', [], '8.0.7', true);

		// Enqueue main script
		wp_enqueue_style('main', get_stylesheet_directory_uri() . '/dist/css/style.css', ['bootstrap', 'adobe', 'swiper', 'fancybox', 'aos'], THEME_VERSION);
		wp_enqueue_script('main', get_stylesheet_directory_uri() . '/dist/js/scripts.js', ['bootstrap', 'swiper', 'fancybox', 'aos', 'imagesloaded', 'masonry'], THEME_VERSION, true);

		// templates

		if (is_404()) {
			wp_enqueue_style('main-404', get_stylesheet_directory_uri() . '/dist/templates/error-404.css', ['main'], THEME_VERSION);
		}

		if (is_single()) {
			wp_enqueue_style('main-single', get_stylesheet_directory_uri() . '/dist/templates/single.css', ['main'], THEME_VERSION);
		}

		if (is_search()) {
			wp_enqueue_style('main-search', get_stylesheet_directory_uri() . '/dist/templates/search.css', ['main'], THEME_VERSION);
		}

		if (is_page_template('templates/template-style-guide.php')) {
			wp_enqueue_style('main-style-guide', get_stylesheet_directory_uri() . '/dist/templates/style-guide.css', ['main'], THEME_VERSION);
		}

		if (is_admin()) {


			echo '<style>
				.font-awesome-preview {
					font-size: 48px;
					margin-top: 10px;
					text-align: center;
					padding: 20px;
					border: 1px solid #ddd;
					background-color: #f9f9f9;
				}
			</style>';
		}
	}
}
