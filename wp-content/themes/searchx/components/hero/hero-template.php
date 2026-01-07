<section <?php component_attributes(); ?>>

	<?php component_background_image(); ?>

	<?php
	if ('video' === get_has_field('background_video', 'other')) {
		include component_part_path('hero-video');
	}
	?>

	<?php
	if (get_component_template_name() === 'hero-default') {
		if (get_field('background_image') && !empty('background_image')) {
			if (get_field('hero_image_position') === 'left') {
				echo '<div class="hero__background-img hero__background-img--left"></div>';
			} else {
				echo '<div class="hero__background-img hero__background-img--right"></div>';
			}
		}
	}
	?>

	<div <?php component_container(); ?>>

		<?php component_template(); ?>

	</div>

</section>
