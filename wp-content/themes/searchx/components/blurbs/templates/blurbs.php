<?php
/**
 * Template Name: Blurbs
 */
?>

<div <?php component_row(); ?>>

	<?php require locate_template( 'template-parts/component-heading.php' ); ?>

</div>

<div <?php component_card_group_row( 'blurbs' ); ?>>

	<?php foreach( get_has_field( 'blurbs', [] ) as $blurb ): ?>

		<div <?php component_col(); ?>>

			<?php include component_part_path( 'blurbs-blurb' ); ?>

		</div>

	<?php endforeach; ?>

</div>
