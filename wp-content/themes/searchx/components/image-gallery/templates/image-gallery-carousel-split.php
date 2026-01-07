<?php
/**
 * Template Name: Image Gallery Carousel Split
 */
?>

<div <?php component_row();?> >

	<?php require locate_template( 'template-parts/component-heading.php' ); ?>

	<div <?php component_col(); ?>>

		<?php include component_part_path( 'image-gallery-carousel-slider' ); ?>

	</div><!-- .col -->

</div><!-- .row -->
