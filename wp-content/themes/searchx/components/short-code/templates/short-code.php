<?php

/**
 * Template Name: Short code
 */
?>

<div <?php component_row(); ?>>

	<?php require locate_template('template-parts/component-heading.php'); ?>

</div>

<div <?php component_row(); ?>>

	<div <?php component_col('col-12'); ?>>
		<?php echo do_shortcode(get_has_field('shortcode', '')); ?>
	</div>

</div>
