<?php

/**
 * Template Name: Global Component
 */
?>
<?php

$content = get_has_field('component_picker', []);

if (!empty($content)) {
	foreach ($content as $page) {
		$component = get_the_content(false, false, $page);
		$blocks = parse_blocks($component);

		foreach ($blocks as $block) {
			echo render_block($block);
		}
	}
}

?>
