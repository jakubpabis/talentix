<?php

/**
 * The archive template file.
 */

get_header(); ?>

<main id="main" role="main">

	<?php get_template_part('template-parts/breadcrumbs'); ?>

	<?php get_template_part('template-parts/archive', 'component'); ?>

</main>

<?php get_footer(); ?>