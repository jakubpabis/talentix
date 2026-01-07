<?php

/**
 * The single SEO template file.
 */

get_header(); ?>

<main id="main" role="main">

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

			<?php the_content(); ?>

		<?php endwhile; ?>

	<?php else : ?>

		<?php get_template_part('template-parts/content', 'none'); ?>

	<?php endif; ?>

</main> <!-- #main -->

<?php get_footer(); ?>