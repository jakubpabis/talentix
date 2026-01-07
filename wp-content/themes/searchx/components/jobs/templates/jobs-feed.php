<?php

/**
 * Template Name: Jobs Feed
 */
?>

<?php $the_query = component_query('jobs'); ?>

<div <?php component_row(); ?>>

	<?php require locate_template('template-parts/component-heading.php'); ?>

</div>

<div <?php component_row(); ?>>

	<div <?php component_col(); ?>>

		<div class="jobs-feed jobs-feed--list-view">

			<?php while ($the_query->have_posts()): $the_query->the_post(); ?>

				<?php get_template_part('template-parts/content', 'post'); ?>

			<?php endwhile; ?>

		</div>

	</div>

</div>
