<?php
/**
 * Template Name: Team Grid
 */
?>

<?php $the_query = component_query(); ?>

<div <?php component_row(); ?>>

	<?php require locate_template( 'template-parts/component-heading.php' ); ?>

</div>

<div <?php component_card_group_row( 'team' ); ?>>

	<?php while( $the_query->have_posts() ): $the_query->the_post(); ?>

		<div <?php component_col(); ?> >

			<?php
			$modal_id = '';
			if( 'modal' === get_has_field( 'team_show_bio_type', false ) ) {
				$modal_id = sanitize_title( get_the_title() ) . '-' . uniqid();
				include component_part_path( 'team-bio' );
			}
			?>

			<?php include component_part_path( 'team-card' ); ?>

		</div>

	<?php endwhile; ?>

</div>
