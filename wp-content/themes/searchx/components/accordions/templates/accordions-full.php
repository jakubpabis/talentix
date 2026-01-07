<?php
/**
 * Template Name: Accordions Full
 */
?>

<div <?php component_row(); ?>>

	<?php get_template_part( 'template-parts/component-heading' ); ?>

</div>

<div <?php component_row(); ?>>

	<div <?php component_col(); ?>>

		<?php $parent_id = uniqid(); ?>

		<div class="accordion" id="accordion-<?php echo $parent_id; ?>">

			<?php
				$json = [];
				$items = get_has_field( 'accordion_items', [] );

				foreach( $items as $count => $accordion_item ) {
					include component_part_path( 'accordion-item' );
				}
			?>

		</div>

	</div>

</div>

<?php include component_part_path( 'accordion-schema' );
