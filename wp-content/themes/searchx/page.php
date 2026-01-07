<?php

/**
 * The page template file.
 */

get_header(); ?>

<main id="main" role="main">
	<?php
	get_template_part('template-parts/breadcrumbs');
	if (have_posts()) :
		while (have_posts()) : the_post();
			the_content();
		endwhile;
	else :
		get_template_part('template-parts/content', 'none');
	endif;
	?>
</main><!-- #main -->

<?php get_footer(); ?>