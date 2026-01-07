<div <?php component_swiper_attributes(); ?>>

	<div class="swiper-wrapper">

		<?php $imgs = get_has_field( 'image_gallery', [] ); ?>

		<?php $uniqid = uniqid(); ?>

		<?php foreach( $imgs as $img ): ?>

			<div class="swiper-slide swiper-lazy">

				<?php acf_single_image( $img[ 'ID' ], 'gallery' ); ?>

			</div>

		<?php endforeach; ?>

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
