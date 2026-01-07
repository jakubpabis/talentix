<?php

/**
 * Template Name: WYSIWYG
 */
?>

<div <?php component_row('justify-content-between align-items-end'); ?>>

	<?php if (has_field('component_sub_header') || has_field('component_header') || has_field('component_text') || has_field('component_link')) : ?>

		<div <?php component_col('col-lg-7 col-12'); ?> data-aos="fade-up">

			<?php
			$component_align = get_has_field('component_text_align', '');
			$content_align = $component_align ? ('justify-content-' . $component_align) : '';
			$text_align = $component_align ? ('text-' . $component_align) : '';
			$text_width = get_has_field('component_text_width', '');
			?>

			<div <?php component_row($content_align . ' ' . $text_align); ?>>

				<div <?php component_col('component__header mb-lg-0 ' . $text_width); ?>>

					<?php if (has_field('component_sub_header') || has_field('component_header')) : ?>

						<div class="<?php component_name(); ?>__heading">

							<?php component_sub_header(); ?>

							<?php component_header(); ?>

						</div>

					<?php endif; ?>

					<?php if (has_field('component_text') || has_field('component_link')) : ?>

						<div class="<?php component_name(); ?>__content">

							<?php component_text(); ?>

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

						</div>

					<?php endif; ?>

				</div>

			</div>

		</div>

		<?php if (has_field('second_title') || has_field('second_text')): ?>

			<div <?php component_col('col-xl-4 col-lg-5 col-12'); ?> data-aos="fade-up">

				<div class="card bg-white shadow-none notched py-4">

					<div class="card-body p-lg-8 p-sm-6 p-4">

						<?php if (has_field('second_title')): ?>
							<h6>
								<?php echo get_field('second_title'); ?>
							</h6>
						<?php endif; ?>

						<?php echo get_has_field('second_text', ''); ?>

						<?php echo acf_link('second_button', ['class' => 'btn btn-tertiary mt-6']); ?>

						<?php echo acf_link('third_button', ['class' => 'btn btn-tertiary mt-4']); ?>

					</div>

				</div>

				<div class="speech"></div>

			</div>

		<?php endif; ?>

	<?php endif; ?>

</div>
