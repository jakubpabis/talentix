<?php

declare(strict_types=1);

namespace App\Gutenberg;

use App\Gutenberg\Register;
use WP_Block;

/**
 * Setup class.
 *
 * @category Gutenberg
 */
class Setup
{

	/**
	 * @var int
	 */
	protected static int $block_number = 0;


	/**
	 * Run on the WordPress init hook. Adds actions and filters.
	 */
	public function init(): void
	{
		add_filter('should_load_separate_core_block_assets', '__return_true');
		add_filter('block_categories_all', [$this, 'block_categories_all'], 10, 2);
		add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
		add_filter('allowed_block_types_all', [$this, 'allowed_block_types_all'], 10, 2);

		add_filter('render_block', [$this, 'render_block'], 10, 3);

		$register = new Register();
		add_action('init', [$register, 'register_all']);
		add_action('wp', [$register, 'enqueue_block_styles']);
	}


	/**
	 * Return order number of the rendered block
	 *
	 * @since 2.7.3
	 *
	 * @return int
	 */
	public static function get_block_number(): int
	{
		return self::$block_number;
	}


	/**
	 * Remove all core block types except heading and paragraph by default.
	 *
	 * @param bool|string[] $allowed_block_types
	 * @param WP_Block_Editor_Context $editor_context
	 *
	 * @since 2.7.3
	 *
	 * @return bool|string[]
	 */
	public function allowed_block_types_all(
		bool|array $allowed_block_types,
		\WP_Block_Editor_Context $editor_context
	): bool|array {
		$allowed_block_types = array_map(function ($component) {
			return "acf/$component";
		}, component_get_blocks());

		$core_allowed_block_types = [
			'core/heading',
			'core/paragraph',
			'core/shortcode',
			'core/group',
			'core/columns',
			'core/embed',
			'core/image',
			'core/list',
			'core/table',
			'core/classic',
			'core/quote',
			'core/video',
			'core/buttons',
			'seoaic/multistep-lead-block'
		];
		return array_merge($allowed_block_types, $core_allowed_block_types);
	}

	/**
	 * Run on the render_block hook. Filters HTML content.
	 *
	 * @param string   $block_content
	 * @param array    $block
	 * @param WP_Block $instance
	 *
	 * @return string Modified HTML content.
	 */
	public function render_block(string $block_content, array $block, WP_Block $instance): string
	{
		if (empty(trim($block_content))) {
			return '';
		}

		self::$block_number++;

		$section_element = apply_filters('gutenblocks_section_element', 'section', $block);
		$section_class   = apply_filters('gutenblocks_section_class', str_replace('/', ' ', $block['blockName'] ?? ''), $block);
		$container_class = apply_filters('gutenblocks_container_wrapper', 'container', $block);
		$row_class       = apply_filters('gutenblocks_row_wrapper', 'row', $block);

		$blocks = apply_filters('gutenblocks_blocks', [
			'core/group',
		]);

		if (in_array($block['blockName'], $blocks)) {
			$block_content = "<$section_element class='$section_class'><div class='$container_class'><div class='$row_class'>$block_content</div></div></$section_element>";
		}
		return $block_content;
	}


	/**
	 * Run on the block_categories_all hook.
	 *
	 * @param $block_categories
	 * @param $editor_context
	 */
	public function block_categories_all($block_categories, $editor_context)
	{
		if (! empty($editor_context->post)) {
			array_unshift(
				$block_categories,
				[
					'slug'  => 'components',
					'title' => 'Components',
					'icon'  => 'block-default',
				]
			);
		}
		return $block_categories;
	}


	/**
	 * Run on the admin_enqueue_scripts hook. Enqueues admin styles and scripts.
	 */
	public function admin_enqueue_scripts(): void
	{
		wp_enqueue_style('blennder-gutenberg-admin', trailingslashit(get_template_directory_uri()) . 'assets/admin/css/gutenberg.css', [], 1.0);

		$current_screen = get_current_screen();
		if ($current_screen->is_block_editor()) {

			wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/dist/css/bootstrap.css', [], '4.6.0');
			wp_enqueue_style('main', get_stylesheet_directory_uri() . '/dist/css/style.css', [], THEME_VERSION);
			wp_enqueue_script('main', get_stylesheet_directory_uri() . '/dist/js/scripts.js', [], THEME_VERSION, true);
		}
	}
}
