<?php

declare(strict_types=1);

namespace App\Gutenberg;

use App\Gutenberg\Fields;

/**
 * Register class.
 *
 * @category Gutenberg
 */
class Register
{


	/**
	 * Enqueue blennder block CSS in the header.
	 *
	 * This method should be run after the WordPress object is setup and
	 * before the page starts rendering. The `wp` hook is perfect for this.
	 * However, the `wp` hook also sometimes fires on the backend, so check
	 * that this is not an admin request first.
	 *
	 * @since 2.7.6
	 *
	 * @return void
	 */
	public function enqueue_block_styles(): void
	{
		if (is_admin()) {
			return;
		}

		// Enqueue component CSS in header
		$content = get_the_content();
		$blocks = parse_blocks($content);

		foreach ($blocks as $block) {
			$component = $block['blockName'] ?? '';
			$component = str_replace('acf/', '', $component);
			$deps = component_dependencies($component);
			$cssDeps = $deps->css ?? [];
			$cssDeps[] = 'main';
			$endpoint = "/dist/css/$component.css";
			if (file_exists(get_stylesheet_directory() . $endpoint)) {
				wp_enqueue_style("blennder/$component", get_stylesheet_directory_uri() . $endpoint, $cssDeps);
			}
		}
	}

	/**
	 * Register all the components as an ACF blocks.
	 *
	 * @since 2.4.0
	 * @since 2.6.0 Register all blocks. They will only be enqueued when needed.
	 */
	public function register_all()
	{
		$blocks = component_get_blocks();
		foreach ($blocks as $block) {
			$fields = $this->get_block_acf($block);
			$this->register_acf_block($fields);
		}
	}


	/**
	 * Register the component as an ACF block
	 *
	 * @since 0.9.0
	 *
	 * @see https://www.advancedcustomfields.com/resources/acf_register_block_type/
	 */
	protected function register_acf_block(Fields $fields): void
	{
		$block = $fields->get_name();
		$json = component_json($block);

		if (empty($block)) {
			return;
		}

		$blennder_block = "blennder/$block";
		$deps = component_dependencies($block);
		$cssDeps = $deps->css ?? [];
		$cssDeps[] = 'main';
		$jsDeps = $deps->js ?? [];

		$style = get_template_directory() . "/dist/css/$block.css";
		if (file_exists($style)) {
			wp_register_style($blennder_block, get_template_directory_uri() . "/dist/css/$block.css", $cssDeps, THEME_VERSION);
		}

		$script = get_template_directory() . "/dist/js/$block.js";
		if (file_exists($script)) {
			wp_register_script($blennder_block, get_template_directory_uri() . "/dist/js/$block.js", $jsDeps, THEME_VERSION, true);
		}

		acf_add_local_field_group([
			'key' => "group_$block",
			'title' => $json->title,
			'fields' => $fields->get_fields(),
			'location' => [
				[
					[
						'param' => 'block',
						'operator' => '==',
						'value' => "acf/$block",
					],
				],
			],
		]);

		$json_file = component_directory() . "$block/block.json";
		if (file_exists($json_file)) {
			register_block_type(component_directory() . $block);
		}
	}


	/**
	 * Return the ACF fields for a block.
	 *
	 * @param string $block The block name.
	 *
	 * @since 0.9.0
	 * @since 2.7.6 Always return the default ACF fields.
	 *
	 * @return Fields
	 */
	protected function get_block_acf(string $block): Fields
	{
		$fileName = component_directory() . "$block/$block-acf.php";
		$acf = new Fields($fileName);
		return $acf;
	}
}
