<div class="testimonials__card card d-flex h-100 align-items-stretch">

	<div class="bg-white text-primary testimonials__content card-body text-start d-flex flex-column h-100">

		<?php /* if (has_post_thumbnail()): ?>

			<?php the_post_thumbnail([150, 150], ['class' => 'testimonials__image']); ?>

		<?php endif; */ ?>

		<p class="mt-0 mb-6">
			<?php echo wp_trim_words(get_the_content(), 36, '...'); ?>
		</p>

		<?php /* $author = get_field('testimonial_author', get_the_ID());  ?>

		<?php if ($author): */ ?>

		<span class="testimonials__author mt-auto mb-0 fw-medium">

			<?php the_title(); ?>

		</span>

		<?php /* endif; */ ?>

	</div>

</div>