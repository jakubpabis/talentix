<?php

/**
 * Template Name: Slider
 */
?>

<div <?php component_row(); ?>>

	<div class="col-12">

		<div <?php component_container(); ?>>

			<div <?php component_row(); ?>>

				<?php require locate_template('template-parts/component-heading.php'); ?>

			</div>

		</div>

	</div>

	<div <?php component_col(); ?>>

		<?php if (has_field('slides')): ?>
			<?php
			$breakpoints = [
				'breakpoints' => array(
					'0' => array(
						"slidesPerView" => 1,
					),
					'576' => array(
						"slidesPerView" => 1,
					),
					'768' => array(
						"slidesPerView" => 1,
					),
					'992' => array(
						"slidesPerView" => 2,
					),
					'1200' => array(
						"slidesPerView" => 2,
					),
					'1400' => array(
						"slidesPerView" => 2,
					),
				),
			];
			$slider_config = [
				'centeredSlides' => true,
				'loop' => true
			];
			?>
			<div <?php component_swiper_attributes([], $breakpoints, $slider_config); ?>>

				<div class="swiper-wrapper align-items-center">

					<?php foreach (get_has_field('slides', []) as $slide) : ?>

						<?php include component_part_path('slide'); ?>

					<?php endforeach; ?>

				</div>

				<div <?php component_container(); ?>>

					<div <?php component_row(); ?>>

						<div class="col-12 position-relative">

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

					</div>

				</div>

			</div>

		<?php endif; ?>

	</div>

</div>
