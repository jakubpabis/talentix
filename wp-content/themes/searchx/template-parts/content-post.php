<div id="blog-post-<?php the_ID(); ?>" <?php post_class('blog-post card shadow-none notched bg-light'); ?> data-mobile="swiper-slide">

	<a href="<?php the_permalink(); ?>" class="wrapped-link">

		<?php if (has_post_thumbnail()): ?>

			<div class="card-img-wrapper ratio ratio-16x9 p-0 m-0">

				<?php the_post_thumbnail('blog_feed', ['class' => 'card-img-top card-image p-0']); ?>

			</div>

		<?php endif; ?>

		<div class="card-body h-100 d-flex flex-column justify-content-between">

			<div class="card-text blog-card__excerpt my-0">

				<h3 class="h6 card-title blog-card__title my-0">

					<?php the_title(); ?>

				</h3>

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

			<span class="card-link btn btn-primary btn-sm"><?php pll_e('Read more'); ?></span>

		</div>

	</a>

</div>