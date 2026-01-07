<?php $class = get_has_field('carousel_pagination_position', 'right') === 'center' ? ['swiper-centered'] : []; ?>
<div <?php component_swiper_attributes($class); ?>>

	<div class="swiper-wrapper">

		<?php $cards = get_has_field('cards', []); ?>

		<?php foreach ($cards as $card): ?>

			<div class="swiper-slide swiper-lazy">

				<?php include component_part_path('cards-card'); ?>

			</div>

		<?php endforeach; ?>

	</div>

	<?php
	get_template_part(
		'template-parts/swiper',
		'controls',
		[
			'navigation_position' => get_has_field('carousel_pagination_position', 'right'),
			'pagination_position' => get_has_field('carousel_pagination_position', 'left'),
		]
	);
	?>

</div>
