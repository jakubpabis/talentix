<?php

/**
 * Template Name: Jobs Cards Grid
 */
?>

<?php $the_query = component_query('jobs'); ?>

<div <?php component_row(); ?>>

	<?php require locate_template('template-parts/component-heading.php'); ?>

</div>

<div <?php component_card_group_row('jobs'); ?>>

	<?php while ($the_query->have_posts()): $the_query->the_post(); ?>

		<div <?php component_col(); ?>>

			<?php include component_part_path('jobs-card'); ?>

		</div>

	<?php endwhile; ?>

</div>