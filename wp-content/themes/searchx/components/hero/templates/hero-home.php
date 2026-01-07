<?php

/**
 * Template Name: Hero Home
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
$style .= 'style="' . $corners . ' ' . $cont_bg . '"';
echo $cornerStyle;
?>

<div class="row justify-content-end">
	<div class="col-12">
		<div class="card shadow-none px-lg-10 px-md-8 px-sm-6 px-4 py-lg-16 py-md-14 py-sm-12 py-10 <?php echo $cornerClass; ?>" <?php echo $style; ?>>
			<div <?php component_row('align-items-end justify-content-lg-start justify-content-md-between justify-content-end'); ?>>

				<div class="col-lg-1"></div>

				<div <?php component_col('col-lg-8 col-md-8 col-12 d-block ' . $content_class . ' ' . 'text-' . $content_align . ' align-items-' . $content_align); ?> data-aos="fade-up">

					<?php component_sub_header(); ?>

					<?php component_header(); ?>

					<?php component_text(true); ?>

					<?php

					if (!empty(get_field('component_link')) || !empty(get_field('component_link_2')) || !empty(get_field('component_link_3')) || !empty(get_field('component_link_4')) || !empty(get_field('component_link_5'))) {
						echo '<div class="d-flex flex-wrap">';
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

				<div <?php component_col('col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 hero__the-dog d-flex position-relative' . $img_class); ?> data-aos="fade-up">

					<?php acf_image('hero_image', 'full', ['class' => 'img-fluid position-absolute']); ?>

				</div>

				<div class="col-lg-1"></div>

				<div class="col-lg-10" data-aos="fade-up">
					<div class="mt-10 bg-white py-3 px-md-8 px-4 z-3 position-relative">
						<form action="<?php echo get_page_url_by_template_in_current_language('templates/template-jobs.php'); ?>" class="w-100">
							<div class="row align-items-center justify-content-between">
								<div class="col-auto flex-grow-1 px-2">
									<input name="s_query" class="w-100 fw-semibold px-5" type="search" placeholder="<?php pll_e('Job title, skill, industry...'); ?>">
								</div>
								<div class="col-auto flex-grow-1 px-2 mt-md-0 mt-4">
									<input name="l_query" class="w-100 fw-semibold px-5" type="text" placeholder="<?php pll_e('Location...') ?>">
								</div>
								<div class="col-lg-3 col-12 mt-lg-0 mt-4 px-2">
									<button type="submit" class="btn btn-primary w-100">
										<?php pll_e('Search'); ?>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>

	</div>

	<?php /*
	<div class="col-xl-11 position-absolute top-0 z-n3">

		<div class="px-6 py-16">

			<div <?php component_row('align-items-center justify-content-center'); ?>>

				<div <?php component_col('col-lg-6 col-12 d-block ' . $content_class . ' ' . 'text-' . $content_align . ' align-items-' . $content_align); ?> data-aos="fade-up">

					<?php component_sub_header(); ?>

					<?php component_header(); ?>

					<?php component_text(true); ?>

					<?php component_link();  ?>

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

				<div class="col-xl-1 d-none d-xl-block"></div>

				<div <?php component_col('col-xl-4 col-lg-6 col-12 pt-10 pt-sm-12 pt-xl-0 d-flex h-100 position-relative ' . $img_class); ?> data-aos="fade-up">

					<?php acf_image('hero_image', 'full', ['class' => 'position-absolute']); ?>

				</div>

			</div>

		</div>

	</div>
	*/ ?>

</div>

<div id="hero-bottom-<?php echo $uniqid; ?>"></div>