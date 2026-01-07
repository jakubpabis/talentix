<?php

use App\Gutenberg\Setup;

if (! isset($slide_number)) {
	$slide_number = 0;
}

$has_content = false;
if (
	has_field('slide_preheader', $slide) ||
	has_field('slide_header', $slide) ||
	has_field('slide_content', $slide) ||
	has_field('slide_button', $slide)
) {
	$has_content = true;
}

$contained_class = '';
?>

<div class="swiper-slide swiper-lazy swiper-slide--full">

	<?php if ($has_content) : ?>

		<div>

			<div class="slide__content card notched bg-white px-8 pt-10 pb-6">

				<?php if (has_field('slide_header', $slide)) : ?>

					<h3 class="slide__header"><?php acf_text('slide_header', $slide) ?></h3>

				<?php endif; ?>

				<?php if (has_field('slide_content', $slide)) : ?>

					<div class="lead">

						<?php acf_wysiwyg('slide_content', [], $slide); ?>

					</div>

				<?php endif; ?>

				<?php if (has_field('slide_button', $slide)) : ?>

					<div>

						<?php acf_link('slide_button', ['class' => "btn btn-primary"], $slide); ?>

					</div>

				<?php endif; ?>



			</div><!-- .container -->

			<div class="triangle"></div>

			<?php if (!empty(get_has_field('slide_icon', [], $slide))): ?>
				<?php acf_image('slide_icon', 'full', ['class' => 'slide__icon'], $slide); ?>
			<?php elseif (!empty(get_has_field('slide_icon_fa', [], $slide))): ?>
				<div class="slide__icon">
					<?php echo get_has_field('slide_icon_fa', '', $slide); ?>
				</div>
			<?php endif; ?>

		</div>

	<?php endif; ?>

</div><!-- .swiper-slide -->
