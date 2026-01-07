<div <?php component_swiper_attributes(); ?> data-aos="fade-up">

	<div class="swiper-wrapper">

		<?php while ($the_query->have_posts()): $the_query->the_post(); ?>

			<div class="swiper-slide swiper-lazy">

				<?php include component_part_path('blog-card'); ?>

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
