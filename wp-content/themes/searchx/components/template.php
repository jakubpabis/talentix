<?php if (get_component_name() === 'global-component' || get_component_name() === 'html' || get_component_name() === 'image'): ?>
	<?php component_template(); ?>
<?php else: ?>
	<?php
	$cornerClass = '';
	if (component_corners()['type'] === 'background') {
		$cornerClass = 'corners-' . uniqid();
		$cornerStyle = component_corners_style($cornerClass);
		echo $cornerStyle;
	}

	?>
	<section <?php component_attributes($cornerClass); ?> data-aos="fade-up">

		<?php if (get_field('background_color_2')): ?>
			<div class=" component__background_2" style="background-color:<?php echo get_field('background_color_2'); ?>;">
			</div>
		<?php endif; ?>

		<?php component_background_image(); ?>

		<div <?php component_container(); ?>>

			<?php

			$style = '';
			$cornerClass = '';
			if (get_has_field('container_color_1', '')) {
				$cont_bg = 'background-color: ' . get_field('container_color_1') . ';';
				$style .= $cont_bg;
			}
			if (component_corners()['type'] === 'container') {
				$cornerClass = 'corners-' . uniqid();
				$cornerStyle = component_corners_style($cornerClass);
				echo $cornerStyle;
			}
			?>

			<div class="<?php echo $cornerClass; ?>" style="<?php echo $style; ?>">

				<?php component_template(); ?>

			</div>

		</div>

	</section>
<?php endif; ?>