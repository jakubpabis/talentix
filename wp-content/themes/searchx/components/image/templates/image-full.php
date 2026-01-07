<?php

/**
 * Template Name: Image FULL
 */
?>
<section <?php component_attributes(); ?>>

	<?php if (get_field('background_color_2')): ?>
		<div class="component__background_2" style="background-color:<?php echo get_field('background_color_2'); ?>;"></div>
	<?php endif; ?>

	<?php component_background_image(); ?>

	<div class="container-fluid">

		<div class="row">

			<?php $ratio = !empty(get_field('image_ratio')) ? 'ratio ' . get_field('image_ratio') : ''; ?>

			<div class="col-12 p-0 <?php echo $ratio; ?>">

				<?php acf_image('image', 'full', ['class' => 'img-fluid w-100 object-fit-cover' . ' ' . $ratio]); ?>

			</div>

		</div>

	</div>

</section>