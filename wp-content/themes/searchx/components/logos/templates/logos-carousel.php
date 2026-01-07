<?php
/**
 * Template Name: Logos Carousel
 */

?>

<div <?php component_row();?> >

	<?php require locate_template( 'template-parts/component-heading.php' ); ?>

</div>

<div <?php component_row();?> >

	<div <?php component_col(); ?>>

		<?php include component_part_path( 'logos-carousel-slider' ); ?>

	</div>

</div>
