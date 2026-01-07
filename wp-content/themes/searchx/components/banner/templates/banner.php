<?php

/**
 * Template Name: Banner
 */
?>

<?php
$bg_primary = get_has_field('color_primary', get_field('color_tertiary', "options"));
$image_position = get_has_field('image_position', 'start');
$image_class = 'col-md-5 col-12 pt-10 text-center align-self-end';
$content_class = 'col-md-7 col-12 banner__content py-10';
$banner_position = 'left start-0';
if ($image_position === 'end') {
	$image_class .= ' order-md-3';
	$content_class .= ' order-md-1';
	$banner_position = 'right end-0';
}

?>

<div class="card shadow-none position-relative" data-aos="fade-up">
	<div class="card-body d-block py-0 px-lg-20 px-10 position-relative" style="background-color: <?php echo $bg_primary; ?>; color: <?php echo getContrastColor($bg_primary) ?>;">
		<?php if (!empty(get_field('color_secondary'))): ?>
			<div class="banner__shape <?php echo $banner_position; ?>" style="background-color: <?php echo get_field('color_secondary'); ?>;">
			</div>
		<?php endif; ?>
		<?php include component_part_path('banner'); ?>
	</div>
</div>