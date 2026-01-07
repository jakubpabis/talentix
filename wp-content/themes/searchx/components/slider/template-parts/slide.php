<?php

use App\Gutenberg\Setup;

if (! isset($slide_number)) {
	$slide_number = 0;
}

$image_layout = get_has_field('slide_image_layout', 'background', $slide);
$is_video = get_has_field('slide_video', false, $slide) ? 'is_video' : '';

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
if ('contained' === $image_layout) {
	$contained_class = ' slide__contained';
}
?>

<div class="swiper-slide swiper-lazy swiper-slide--full<?php echo $contained_class; ?>">

	<?php if ($has_content) : ?>

		<div class="slide__content">

			<?php if (has_field('slide_preheader', $slide)) : ?>

				<p class="preheader" data-swiper-parallax="-1000"><?php acf_text('slide_preheader', $slide) ?></p>

			<?php endif; ?>

			<?php if (has_field('slide_header', $slide)) : ?>

				<h2 data-swiper-parallax="-1800"><?php acf_text('slide_header', $slide) ?></h2>

			<?php endif; ?>

			<?php if (has_field('slide_content', $slide)) : ?>

				<div class="lead" data-swiper-parallax="-2800">

					<?php acf_wysiwyg('slide_content', [], $slide); ?>

				</div>

			<?php endif; ?>

			<?php if (has_field('slide_button', $slide)) : ?>

				<div data-swiper-parallax="-2200">

					<?php acf_link('slide_button', ['class' => "btn btn-primary"], $slide); ?>

				</div>

			<?php endif; ?>

		</div><!-- .container -->

	<?php endif; ?>


	<div class="<?php echo $is_video; ?> slide__image-wrapper<?php echo ($has_content) ? ' slide-overlay' : ''; ?>">
		<?php
		$attributes = ['class' => 'slide__image'];
		if (
			0 === Setup::get_block_number() &&
			0 === $slide_number
		) {
			$slide_number++;
			$attributes['loading'] = 'lazy';
			$attributes['fetchpriority'] = 'low';
			$attributes['decoding'] = 'sync';
		}
		?>

		<?php if (get_has_field('slide_video', false, $slide)): ?>

			<?php if ($src = get_has_field('slide_video', false, $slide)) : ?>
				<video src="<?php echo $src['url']; ?>" <?php echo !empty(get_has_field('slide_image', false, $slide)) ? 'poster="' . get_has_field('slide_image', false, $slide)['url'] . '"' : ''; ?>>
					Your browser does not support the video tag.
				</video>
			<?php endif; ?>

			<a href="#" class="slider__video-pause video-pause-btn">

				<div class="video-btn-wrap">

					<i class="fas fa-play"></i>

				</div>

				<span class="visually-hidden">Pause Video</span>

			</a>

		<?php elseif (get_has_field('slide_image', false, $slide)): ?>

			<?php acf_image('slide_image', 'full', $attributes, $slide); ?>

		<?php endif; ?>

	</div>

</div><!-- .swiper-slide -->
