<div class="tabs__content tab-content" data-aos="fade-up">

	<?php foreach (get_has_field('tabs', []) as $key => $panel) : ?>
		<?php
		$image_position = get_has_field('panel_image_position', 'left', $panel) === 'right' ? 'order-md-3' : '';
		$content_position = get_has_field('panel_image_position', 'left', $panel) === 'right' ? 'order-md-1' : '';
		?>

		<div <?php tabs_panel_attr(['panel' => $panel, 'count' => $key, 'id' => $id]); ?>>

			<div class="tabs__panel">

				<div class="row justify-content-between align-items-center tabs__panel-content">

					<?php if (has_field('panel_image', $panel)): ?>

						<div class="col-md-6 <?php echo $image_position; ?>">

							<?php acf_image('panel_image', 'full', [], $panel); ?>

						</div>

					<?php endif; ?>

					<div class="col-lg-5 col-md-6 tabs__content <?php echo $content_position; ?> pt-sm-0 pt-4">

						<?php if (has_field('panel_title', $panel)): ?>

							<?php
							$title = get_has_field('panel_title', '', $panel);
							$tag = get_has_field('panel_title_tag', 'h3', $panel);
							$attr['class'] = [
								'panel-title',
								get_has_field('panel_title_style', '', $panel),
								get_has_field('panel_title_class', '', $panel),
							];
							the_tag($tag, $attr, $title);
							?>

						<?php endif; ?>

						<?php if (has_field('panel_content', $panel)): ?>

							<?php acf_wysiwyg('panel_content', [], $panel); ?>

						<?php endif; ?>

						<?php acf_link('panel_link', ['class' => 'mt-lg-6 mt-4 ' . get_has_field('panel_link_style', 'btn btn-primary')], $panel); ?>

					</div>

				</div>

			</div>

		</div>

	<?php endforeach; ?>

</div>
