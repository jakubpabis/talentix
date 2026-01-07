<?php foreach( component_get_blocks() as $component ): ?>

	<article id="components__<?php echo sanitize_title( $component ) ; ?>">

		<?php
			$slug = sanitize_title( $component );
			$description = style_guide_description( $slug );
			$args = [
				'component_header' => ucwords( $component ),
				'component_text' => wpautop( $description ),
			];

			$custom = style_guide_custom_content( $component );
			$args = array_merge( $args, $custom );

			$templates = component_templates( $slug );
			foreach( $templates as $file => $name ) {
				$args[ "{$slug}_block_template" ] = $file;
				$args[ 'component_sub_header' ] = $name;
				the_component( $slug, $args );
			}
		?>

	</article>

<?php endforeach; ?>
