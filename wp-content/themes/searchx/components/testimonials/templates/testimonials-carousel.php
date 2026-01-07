<?php

/**
 * Template Name: Testimonials Carousel
 */
?>

<?php $the_query = component_query(); ?>

<div <?php component_row('align-items-end mb-6'); ?>>

	<div <?php component_col('col-lg-9 col-12'); ?> data-aos="fade-up">

		<?php
		$component_align = get_has_field('component_text_align', '');
		$content_align = $component_align ? ('justify-content-' . $component_align) : '';
		$text_align = $component_align ? ('text-' . $component_align) : '';
		$text_width = get_has_field('component_text_width', '');
		?>

		<div <?php component_row($content_align . ' ' . $text_align); ?>>

			<div <?php component_col('col-12 mb-0 ' . $text_width); ?>>

				<?php if (has_field('component_sub_header') || has_field('component_header')) : ?>

					<div class="<?php component_name(); ?>__heading">

						<?php component_sub_header(); ?>

						<?php component_header('my-0'); ?>

					</div>

				<?php endif; ?>

				<?php if (has_field('component_text') || has_field('component_link')) : ?>

					<div class="<?php component_name(); ?>__content">

						<?php component_text(); ?>

					</div>

				<?php endif; ?>

			</div>

		</div>

	</div>

	<div <?php component_col('col-lg-3 col-12 text-end d-flex justify-content-lg-end'); ?> data-aos="fade-up">
		<div class="d-flex flex-wrap mx-n3">
			<?php if (!empty(get_field('component_link'))): ?>
				<?php component_link(); ?>
			<?php endif; ?>
			<?php if (!empty(get_field('component_link_2'))): ?>
				<?php component_link_2(); ?>
			<?php endif; ?>
			<?php if (!empty(get_field('component_link_3'))): ?>
				<?php component_link_3(); ?>
			<?php endif; ?>
			<?php if (!empty(get_field('component_link_4'))): ?>
				<?php component_link_4(); ?>
			<?php endif; ?>
			<?php if (!empty(get_field('component_link_5'))): ?>
				<?php component_link_5(); ?>
			<?php endif; ?>
		</div>
	</div>

</div>

<div <?php component_row(); ?>>

	<div <?php component_col('px-0'); ?>>

		<?php include component_part_path('testimonials-carousel-slider'); ?>

	</div>

</div>