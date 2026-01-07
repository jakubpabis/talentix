<?php

/**
 * Template Name: Slider Text
 */
?>

<div <?php component_row(); ?>>

	<?php require locate_template('template-parts/component-heading.php'); ?>

	<div <?php component_col(); ?>>

		<?php if (has_field('slides')): ?>

			<div <?php component_swiper_attributes(); ?>>

				<div class="swiper-wrapper">

					<?php foreach (get_has_field('slides', []) as $slide) : ?>

						<?php include component_part_path('slide'); ?>

					<?php endforeach; ?>

				</div>

				<?php
				get_template_part(
					'template-parts/swiper',
					'controls',
					[
						'navigation_position' => 'right',
						'pagination_position' => 'left',
					]
				);
				?>

			</div>

		<?php endif; ?>

	</div>

</div>