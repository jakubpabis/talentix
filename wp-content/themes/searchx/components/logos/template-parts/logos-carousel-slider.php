<div <?php component_swiper_attributes(); ?> data-aos="fade-up">

	<div class="swiper-wrapper">

		<?php $logos = get_has_field('logos', []); ?>

		<?php foreach ($logos as $logo): ?>

			<div class="swiper-slide swiper-lazy">

				<?php include component_part_path('logos-card'); ?>

			</div>

		<?php endforeach; ?>

	</div>

</div>
