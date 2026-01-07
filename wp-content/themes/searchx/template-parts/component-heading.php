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

				<?php endif; ?>

			</div>

		</div>

	</div>

<?php endif; ?>