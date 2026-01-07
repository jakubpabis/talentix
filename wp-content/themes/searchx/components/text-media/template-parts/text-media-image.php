<?php

use App\Gutenberg\Setup;

$ratio = get_has_field('text_media_image_aspect_ratio', null);

$attributes = [];
$attributes['class'] = 'w-100';
if (0 === Setup::get_block_number()) {
	$attributes['loading'] = 'lazy';
	$attributes['fetchpriority'] = 'low';
}
if ($ratio && $ratio !== null && get_component_template_name() !== 'text-media-card-right' && get_component_template_name() !== 'text-media-card-left') {
	$attributes['class'] .= ' img-fluid object-fit-cover';
	echo '
		<div class="ratio ratio-' . $ratio . '">
	';
}
acf_image('text_media_image', 'medium_large', $attributes);
if ($ratio && $ratio !== null) {
	echo '</div>';
}
