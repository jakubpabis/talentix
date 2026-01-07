<?php
/**
 * Template Name: Testimonials List
 */
?>

<?php $the_query = component_query(); ?>

<div <?php component_row(); ?>>

	<?php require locate_template( 'template-parts/component-heading.php' ); ?>

</div>

<div <?php component_row(); ?>>

	<div <?php component_col(); ?>>

		<?php

			if( $the_query->have_posts() ) {

				include component_part_path( 'testimonials-list' );

			}

		?>

	</div>

</div>
