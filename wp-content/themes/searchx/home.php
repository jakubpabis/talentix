<?php

/**
 * The main blog template.
 */

get_header(); ?>

<main id="main" role="main">

	<?php
	get_template_part('template-parts/breadcrumbs');

	$post = get_queried_object();
	setup_postdata($post);
	the_content();
	wp_reset_postdata();
	?>

	<?php get_template_part('template-parts/archive', 'component'); ?>

</main>

<?php get_footer(); ?>