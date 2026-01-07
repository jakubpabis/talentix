<?php
/**
 * The single-global-components template file.
 *
 * @since 2.3.0
 */
add_filter( 'wp_robots', 'wp_robots_no_robots' );
get_header(); ?>

<main id="main" role="main">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>

		<?php endwhile; ?>

	<?php endif; ?>

</main> <!-- #main -->

<?php get_footer(); ?>
