<?php

/**
 * Template Name: Cards Carousel Full
 */
?>

<div <?php component_row(); ?>>

	<?php require locate_template('template-parts/component-heading.php'); ?>

</div>

<div <?php component_row(); ?>>

	<div <?php component_col('px-0'); ?> data-aos="fade-up">

		<?php include component_part_path('cards-carousel-slider'); ?>

	</div>

</div>
