<?php

/**
 * Template Name: Scrollable
 */
?>

<?php $ids = []; ?>

<div <?php component_row(); ?>>

	<div <?php component_col('col-lg-4 scrollable__sticky col-12 pb-8 pb-lg-0'); ?> data-aos="fade-up">

		<div class="scrollable__sticky-content">

			<?php if (has_field('component_sub_header') || has_field('component_header') || has_field('component_text') || has_field('component_link')) : ?>

				<div <?php component_col(); ?> data-aos="fade-up">

					<?php
					$component_align = get_has_field('component_text_align', '');
					$content_align = $component_align ? ('justify-content-' . $component_align) : '';
					$text_align = $component_align ? ('text-' . $component_align) : '';
					$text_width = get_has_field('component_text_width', '');
					?>

					<div <?php component_row($content_align . ' ' . $text_align); ?>>

						<div <?php component_col('component__header ' . $text_width); ?>>

							<?php if (has_field('component_sub_header') || has_field('component_header')) : ?>

								<div class="<?php component_name(); ?>__heading">

									<?php component_sub_header(); ?>

									<?php component_header(); ?>

								</div>

							<?php endif; ?>

							<?php if (has_field('component_text') || has_field('component_link')) : ?>

								<div class="<?php component_name(); ?>__content">

									<?php component_text(); ?>

									<div class="d-lg-block d-none">
										<?php if (!empty(get_field('component_link')) || !empty(get_field('component_link_2'))): ?>
											<div class="d-flex flex-wrap mx-n3">
												<?php if (!empty(get_field('component_link'))): ?>
													<div class="mb-2">
														<?php component_link(); ?>
													</div>
												<?php endif; ?>
												<?php if (!empty(get_field('component_link_2'))): ?>
													<div class="mb-2">
														<?php component_link_2(); ?>
													</div>
												<?php endif; ?>
												<?php if (!empty(get_field('component_link_3'))): ?>
													<div class="mb-2">
														<?php component_link_3(); ?>
													</div>
												<?php endif; ?>
												<?php if (!empty(get_field('component_link_4'))): ?>
													<div class="mb-2">
														<?php component_link_4(); ?>
													</div>
												<?php endif; ?>
												<?php if (!empty(get_field('component_link_5'))): ?>
													<div class="mb-2">
														<?php component_link_5(); ?>
													</div>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									</div>

								</div>

							<?php endif; ?>

						</div>

					</div>

				</div>

			<?php endif; ?>

			<ul>

				<?php foreach (get_has_field('scrollables', []) as $key => $scrollable) : ?>

					<?php $ids[] = 'scroll_' . $key; ?>

					<li>
						<a href="#<?php echo $ids[$key]; ?>" class="d-block pb-1"><?php echo $scrollable['title']; ?></a>
					</li>

				<?php endforeach; ?>

			</ul>

			<div class="d-lg-none d-block mt-4">
				<?php if (!empty(get_field('component_link')) || !empty(get_field('component_link_2'))): ?>
					<div class="d-flex flex-wrap mx-n3">
						<?php if (!empty(get_field('component_link'))): ?>
							<div class="mb-2">
								<?php component_link(); ?>
							</div>
						<?php endif; ?>
						<?php if (!empty(get_field('component_link_2'))): ?>
							<div class="mb-2">
								<?php component_link_2(); ?>
							</div>
						<?php endif; ?>
						<?php if (!empty(get_field('component_link_3'))): ?>
							<div class="mb-2">
								<?php component_link_3(); ?>
							</div>
						<?php endif; ?>
						<?php if (!empty(get_field('component_link_4'))): ?>
							<div class="mb-2">
								<?php component_link_4(); ?>
							</div>
						<?php endif; ?>
						<?php if (!empty(get_field('component_link_5'))): ?>
							<div class="mb-2">
								<?php component_link_5(); ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

		</div>

	</div>

	<div <?php component_col('col-lg-1 scrollable__divider d-flex justify-content-center d-none d-lg-block'); ?> data-aos="fade-up">
		<div class="scrollable__divider-line"></div>
	</div>

	<?php if (has_field('scrollables')): ?>

		<div <?php component_col('col-lg-7 col-12'); ?> data-aos="fade-up">

			<?php foreach (get_has_field('scrollables', []) as $key => $scrollable) : ?>

				<div id="<?php echo $ids[$key]; ?>" class="scrollable__item pt-xxl-20 pt-md-12 pt-8 <?php echo $key === 0 ? 'mt-xxl-n20' : ''; ?> <?php count(get_has_field('scrollables', [])) === $key - 1 ? '' : 'mb-n15' ?>">

					<?php if (has_field('title', $scrollable)) : ?>

						<?php the_tag(get_has_field('title_tag', 'h2', $scrollable), ['class' => ['mb-4', 'mt-0']], $scrollable['title']); ?>

					<?php endif; ?>

					<?php if (has_field('text', $scrollable)): ?>
						<?php acf_text('text', $scrollable); ?>
					<?php endif; ?>

				</div>

			<?php endforeach; ?>

		</div>

	<?php endif; ?>

</div>