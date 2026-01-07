<?php

/**
 * Template Name: Map SVG
 */
?>

<div <?php component_row(); ?>>

	<?php require locate_template('template-parts/component-heading.php'); ?>

</div>

<div <?php component_row('align-items-center'); ?>>
	<div <?php component_col('col-12'); ?> data-aos="fade-up">
		<?php acf_image('map_svg', 'full'); ?>
	</div>
	<div <?php component_col('map__card offset-0 offset-md-6 offset-lg-7 offset-xl-8 col-12 col-md-6 col-lg-5 col-xl-4'); ?> data-aos="fade-up">
		<div class="card bg-white shadow-lg">
			<div class="card-body">
				<?php acf_wysiwyg('map_card'); ?>
			</div>
		</div>
	</div>
</div>
