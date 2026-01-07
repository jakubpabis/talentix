<?php

/**
 * Template Name: Accordions Half
 */
?>

<div <?php component_row(); ?>>

	<?php get_template_part('template-parts/component-heading'); ?>
</div>

<div <?php component_row(); ?>>

	<div <?php component_col(); ?>>

		<?php $parent_id = uniqid(); ?>

		<div class="accordion" id="accordion-<?php echo $parent_id; ?>">

			<?php
			$json = [];
			$items = get_has_field('accordion_items', []);
			$break = round(count($items) / 2) - 1;

			foreach ($items as $count => $accordion_item) {
				include component_part_path('accordion-item');

				if ((int) $break === (int) $count) : ?>

					<div class="column-break"></div>

			<?php endif;
			}
			?>

		</div>

	</div>

</div>

<?php include component_part_path('accordion-schema');
