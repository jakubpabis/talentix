<div class="card blog__card shadow-none notched bg-info" data-aos="fade-up">

	<a href="<?php the_permalink(); ?>" class="wrapped-link">

		<?php if (has_post_thumbnail()): ?>

			<div class="card-img-wrapper ratio-16x9">

				<?php the_post_thumbnail('blog_feed', ['class' => 'card-img-top card-image']); ?>

			</div>

		<?php endif; ?>

		<div class="card-body h-100 d-flex flex-column justify-content-between">

			<div class="card-text blog-card__excerpt mt-2">

				<h6 class="fw-semibold blog-card__title my-0">

					<?php the_title(); ?>

				</h6>

				<?php
				$exceprt_len = 40;
				if (has_post_thumbnail()) {
					$exceprt_len = 20;
				}
				?>

				<?php if (has_excerpt()): ?>

					<p><?php echo wp_trim_words(get_the_excerpt(), $exceprt_len, ' [...] '); ?></p>

				<?php else: ?>

					<p><?php echo wp_trim_words(get_the_content(), $exceprt_len, ' [...] '); ?></p>

				<?php endif; ?>

			</div>

			<span class="card-link btn btn-primary"><?php pll_e('Read more'); ?></span>

		</div>

	</a>

</div>