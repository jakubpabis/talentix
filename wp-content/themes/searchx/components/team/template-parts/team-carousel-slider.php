<div <?php component_swiper_attributes(); ?>>

	<div class="swiper-wrapper">

		<?php while( $the_query->have_posts() ): $the_query->the_post(); ?>

			<div class="swiper-slide swiper-lazy">

				<?php
				$modal_id = '';
				if( 'modal' === get_has_field( 'team_show_bio_type', false ) ) {
					$modal_id = sanitize_title( get_the_title() ) . '-' . uniqid();
					include component_part_path( 'team-bio' );
				}
				?>
				
				<?php include component_part_path( 'team-card' ); ?>

			</div>

		<?php endwhile; ?>

	</div>

	<?php
		get_template_part(
			'template-parts/swiper',
			'controls',
			[
				'navigation_position' => 'right',
				'pagination_position' => 'left',
			]
		);
	?>

</div>
