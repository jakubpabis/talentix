<?php

/**
 * Template Name: Stripe
 */
?>

<div <?php component_row('align-items-center justify-content-between'); ?> data-aos="fade-up">

	<div <?php component_col(); ?>>

		<?php component_sub_header('my-0'); ?>

	</div>

	<div <?php component_col('ms-auto me-0 d-flex align-items-center justify-content-end'); ?>>

		<?php component_header('my-0'); ?>

		<?php if (has_field('component_header') && has_field('component_header')): ?>

			<div class="stripe__divider mx-5"></div>

		<?php endif; ?>

		<?php component_link('my-0 h5');  ?>

	</div>

</div>
