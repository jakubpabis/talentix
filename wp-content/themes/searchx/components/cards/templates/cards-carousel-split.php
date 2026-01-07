<?php

/**
 * Template Name: Cards Carousel Split
 */
?>

<div <?php component_row(); ?>>

	<?php require locate_template('template-parts/component-heading.php'); ?>

	<div <?php component_col(); ?> data-aos="fade-up">

		<?php include component_part_path('cards-carousel-slider'); ?>

	</div><!-- .col -->

</div><!-- .row -->
