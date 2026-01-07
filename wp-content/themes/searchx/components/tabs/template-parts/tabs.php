
<div <?php component_row();?>>

	<?php require locate_template( 'template-parts/component-heading.php' ); ?>

</div>

<div <?php component_row();?>>

	<div <?php component_col(); ?>>

		<?php $id = uniqid(); ?>

		<div class="tabs__menu">

			<?php include component_part_path( 'tabs-nav' ); ?>

		</div>

		<div class="tabs__panels my-auto">

			<?php include component_part_path( 'tabs-panel' ); ?>

		</div>

	</div><!-- /.col -->

</div><!-- /.row -->
