<div class="row justify-content-center mb-sm-16 mb-8" data-aos="fade-up">
	<div class="col-lg-10 col-12">
		<div class="card shadow-none team__list-item bg-white">

			<div class="card-body d-flex p-0">

				<?php if (has_post_thumbnail()): ?>

					<div class="team__list-image-wrapper">

						<?php the_post_thumbnail('medium_large', ['class' => 'team__image']); ?>

					</div>

				<?php endif; ?>

				<div class="team__list-body position-relative">

					<div class="team__socials d-flex">
						<?php if (get_field('whatsapp', get_the_ID())): ?>
							<a href="<?php echo get_field('whatsapp', get_the_ID()); ?>" class="ms-3 fw-medium">
								<i class="fab fa-whatsapp fa-xl"></i>
							</a>
						<?php endif; ?>
						<?php if (get_field('linkedin', get_the_ID())): ?>
							<a href="<?php echo get_field('linkedin', get_the_ID()); ?>" class="ms-3 fw-medium">
								<i class="fab fa-linkedin fa-xl"></i>
							</a>
						<?php endif; ?>
					</div>

					<h3 class="team__title my-0 w-100 pe-20">

						<?php the_title(); ?>

					</h3>

					<div class="team__text">

						<?php if (get_field('title', get_the_ID())): ?>

							<p class="lead mt-sm-2 mt-0 fw-medium font-primary">

								<?php echo get_field('title', get_the_ID()); ?>

							</p>

						<?php endif; ?>

						<?php if (get_field('phone', get_the_ID()) || get_field('email', get_the_ID())): ?>

							<div class="team__contact mt-1 d-flex flex-column">

								<?php if (get_field('email', get_the_ID())) : ?>
									<a href="mailto:<?php echo get_field('email', get_the_ID()); ?>" class="my-1 fw-medium">
										<i class="far fa-envelope fa-lg me-3"></i><?php echo get_field('email', get_the_ID()); ?>
									</a>
								<?php endif; ?>

								<?php if (get_field('phone', get_the_ID())) : ?>
									<a href="tel:<?php echo get_field('phone', get_the_ID()); ?>" class="my-1 fw-medium">
										<i class="far fa-phone fa-lg me-3"></i><?php echo get_field('phone', get_the_ID()); ?>
									</a>
								<?php endif; ?>

							</div>

						<?php endif; ?>

						<?php if (get_field('short_bio', get_the_ID())): ?>

							<p>

								<?php echo get_field('short_bio', get_the_ID()); ?>

							</p>

						<?php endif; ?>

						<?php if (get_field('calendly', get_the_ID())): ?>
							<a href="<?php echo get_field('calendly', get_the_ID()); ?>" class="mt-3 btn btn-tertiary">
								<?php echo pll_e('Schedule a call or a meeting'); ?>
							</a>
						<?php endif; ?>

					</div>

				</div>

			</div>

		</div>
	</div>
</div>