<?php

/**
 * Template Name: Hero Default
 */

$uniqid = uniqid();
$content_align = get_has_field('hero_content_align', 'start');
$image_position = get_has_field('hero_image_position', false);
$img_class = '';
$content_class = '';
if ($image_position && $image_position === 'left') {
	$img_class = 'order-lg-1';
	$content_class = 'order-lg-3';
}
$style = '';
$corners = '';
if (component_corners()['type'] === 'container') {
	// $corners = component_corners()['style'] . ';';
}
$cornerClass = 'corners-' . uniqid();
$cornerStyle = component_corners_style($cornerClass);
$cont_bg = '';
if (get_has_field('container_color_1', '')) {
	$cont_bg = 'background-color: ' . get_field('container_color_1') . ';';
}
$style .= 'style="' . $corners . ' ' . $cont_bg . ';"';
echo $cornerStyle;
?>

<div class="card shadow-none <?php echo $cornerClass; ?>" <?php echo $style; ?>>
	<div <?php component_row('align-items-end'); ?>>

		<div class="col-lg-1 d-lg-block d-none order-lg-1 <?php echo $img_class; ?>"></div>
		<?php $cols = get_field('component_text_width') === 'mw-100' ? '' : 'col-xl-7 col-lg-6'; ?>
		<div <?php component_col('py-lg-16 py-12 ' . $cols . ' col-12 d-block order-lg-2 order-5 px-lg-4 px-md-16 px-8 ' . $content_class . ' ' . 'text-' . $content_align . ' align-items-' . $content_align); ?> data-aos="fade-up">

			<?php component_sub_header(); ?>

			<?php component_header(); ?>

			<?php component_text(true); ?>

			<?php

			if (!empty(get_field('component_link')) || !empty(get_field('component_link_2')) || !empty(get_field('component_link_3')) || !empty(get_field('component_link_4')) || !empty(get_field('component_link_5'))) {
				echo '<div class="d-flex flex-wrap mx-n3">';
				if (!empty(get_field('component_link'))) {
					component_link();
				}
				if (!empty(get_field('component_link_2'))) {
					component_link_2();
				}
				if (!empty(get_field('component_link_3'))) {
					component_link_3();
				}
				if (!empty(get_field('component_link_4'))) {
					component_link_4();
				}
				if (!empty(get_field('component_link_5'))) {
					component_link_5();
				}
				echo '</div>';
			}

			?>

			<?php if (!empty(get_field('hero_small_images'))) : ?>
				<div class="row" data-aos="fade-up">
					<?php foreach (get_has_field('hero_small_images', []) as $image) : ?>
						<div class="col-sm-4 mt-lg-10 mt-sm-8 mt-6">
							<?php if (has_field('hero_small_images_image', $image)): ?>
								<?php acf_image('hero_small_images_image', 'logo', ['class' => 'logos__image'], $image); ?>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>

		<div class="col-xl-1 d-none d-xl-block order-lg-3 <?php echo $content_class; ?>"></div>

		<?php if (get_has_field('hero_image', false)): ?>
			<div <?php component_col('col-xl-2 col-lg-3 col-12 pt-lg-16 pt-10 d-flex position-relative order-lg-4 order-1 ' . $img_class); ?> data-aos="fade-up">

				<?php acf_image('hero_image', 'large_medium'); ?>

			</div>
		<?php endif; ?>

		<div class="col-xl-1 d-lg-block d-none order-lg-5"></div>

	</div>
</div>

<div id="hero-bottom-<?php echo $uniqid; ?>"></div>