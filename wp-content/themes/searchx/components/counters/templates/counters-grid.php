<?php

/**
 * Template Name: Counters Grid
 */
?>

<div <?php component_row(); ?>>

	<?php require locate_template('template-parts/component-heading.php'); ?>

</div>

<div <?php component_card_group_row('mt-sm-10 mt-2 counters'); ?>>

	<?php foreach (get_has_field('counters', []) as $counter) : ?>

		<div <?php component_col(); ?> data-aos="fade-up">

			<?php
			$config = [
				'startVal' => get_has_field('counter_start_val', null, $counter),
				'duration' => get_has_field('counter_duration', null, $counter),
				'separator' => get_has_field('counter_separator', null, $counter),
				'decimal' => get_has_field('counter_decimal', null, $counter),
				'decimalPlaces' => get_has_field('counter_decimal_places', null, $counter),
				'prefix' => get_has_field('counter_prefix', null, $counter),
				'suffix' => get_has_field('counter_suffix', null, $counter),
				'useEasing' => get_has_field('counter_use_easing', null, $counter),
				'useGrouping' => get_has_field('counter_use_grouping', null, $counter),
			];
			$config = component_remove_empty_fields($config);
			$config = blennder_array_to_json($config);
			?>

			<div class="card counters__card">

				<?php if (has_field('counter_image', $counter)): ?>

					<?php acf_image('counter_image', [200, 200], ['class' => 'counters__image'], $counter); ?>

				<?php endif; ?>

				<div class="counters__body d-flex flex-column align-items-end">

					<?php if (has_field('counter_number', $counter)): ?>

						<span
							id="counters__number-<?php echo uniqid(); ?>"
							class="counters__number text-primary"
							data-counter-number="<?php acf_text('counter_number', $counter); ?>"
							data-config="<?php echo $config; ?>">

							<?php acf_text('counter_start_val', $counter); ?>

						</span>

					<?php endif; ?>

					<p class="counters__title text-primary h6 mt-6">

						<?php acf_text('counter_title', $counter); ?>

					</p>

				</div>

			</div>

		</div>

	<?php endforeach; ?>

</div>