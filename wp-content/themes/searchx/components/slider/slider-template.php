<section <?php component_attributes(); ?>>

	<?php if (get_field('background_color_2')): ?>
		<div class="component__background_2" style="background-color:<?php echo get_field('background_color_2'); ?>;"></div>
	<?php endif; ?>

	<?php component_background_image(); ?>

	<div class="container-fluid">

		<?php

		$style = '';
		if (get_has_field('container_color_1', '')) {
			$cont_bg = 'background-color: ' . get_field('container_color_1') . ';';
			$style .= $cont_bg;
		}
		if (component_corners()['type'] === 'container') {
			$corners = component_corners()['style'];
			if ($corners) {
				$style .= $corners . ';';
			}
		}
		?>

		<div style="<?php echo $style; ?>">

			<?php component_template(); ?>

		</div>

	</div>

</section>