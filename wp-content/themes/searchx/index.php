<?php

/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

$args = [
	'hero_block_template'  => component_directory('hero') . '/templates/hero-default.php',
];

get_header(); ?>

<main id="main" role="main">

	<?php the_component('hero', $args); ?>

	<section class="component">

		<div class="container">

			<div class="row">

				<div class="col">

					<?php
					if (have_posts()) :
						while (have_posts()) : the_post();
							the_content();
						endwhile;
					else :
						get_template_part('template-parts/content', 'none');
					endif;
					?>

				</div><!-- .col -->

			</div><!-- .row -->

		</div><!-- #container -->

	</section> <!-- #section -->

</main><!-- #main -->

<?php get_footer(); ?>
