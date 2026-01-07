<?php
$the_query = blennder_related_posts();
if (! $the_query->have_posts()) {
	return;
}
$ids = [];
foreach ($the_query->posts as $p) {
	$ids[] = $p->ID;
}
$options = [
	'blog_block_template' => component_directory('blog') . 'templates/blog-carousel.php',
	'component_sub_header' => pll__('Kennis'),
	'component_sub_header_style' => 'preheader',
	'component_header' => get_has_theme_option('related_posts_heading', pll__('Vergelijkbare artikelen')),
	'component_header_tag' => 'h2',
	'component_text_align' => 'left',
	'post_picker' => $ids,
	'component_color_theme' => 'light',
	'background_type' => 'color',
	'background_color' => '#FFFFFF',
];

the_component('blog', $options);
