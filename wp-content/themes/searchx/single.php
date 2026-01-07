<?php

/**
 * The single template file.
 */

get_header(); ?>

<main id="main" role="main">

	<?php get_template_part('template-parts/breadcrumbs'); ?>

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

			<?php // also need to be changed on App/Setup/Body.php
			?>
			<?php get_template_part('template-parts/single', 'three'); ?>

			<?php get_template_part('template-parts/related-posts'); ?>

		<?php endwhile; ?>

	<?php else : ?>

		<?php get_template_part('template-parts/content', 'none'); ?>

	<?php endif; ?>

	<?php
	$options = [
		'global-component_block_template' => component_directory('global-component') . 'templates/global-component.php',
		'component_picker' => get_has_theme_option('post_component_picker', []),
	];
	the_component('global-component', $options);
	?>

</main> <!-- #main -->

<?php get_footer(); ?>