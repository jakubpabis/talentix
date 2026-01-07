<?php

/**
 * Template Name: Map Global
 */
?>

<?php
$component_align = get_has_field('component_text_align', '');
$content_align = $component_align ? ('justify-content-' . $component_align) : '';
$text_align = $component_align ? ('text-' . $component_align) : '';
?>

<div <?php component_row(); ?>>

	<div <?php component_col('col-12 component__header mw-100'); ?>>

		<?php if (has_field('component_sub_header') || has_field('component_header')) : ?>

			<div class="<?php component_name(); ?>__heading">

				<?php component_sub_header(); ?>

				<?php component_header(); ?>

			</div>

		<?php endif; ?>

	</div>

</div>

<div <?php component_row('justify-content-center'); ?>>

	<div <?php component_col('col-xl-10 col-lg-11 col-12'); ?>>

		<div class="<?php component_name(); ?>__content-full mw-100">

			<?php component_text(); ?>

			<div class="d-flex flex-wrap mx-n3">
				<?php if (!empty(get_field('component_link'))): ?>
					<?php component_link(); ?>
				<?php endif; ?>
				<?php if (!empty(get_field('component_link_2'))): ?>
					<?php component_link_2(); ?>
				<?php endif; ?>
				<?php if (!empty(get_field('component_link_3'))): ?>
					<?php component_link_3(); ?>
				<?php endif; ?>
				<?php if (!empty(get_field('component_link_4'))): ?>
					<?php component_link_4(); ?>
				<?php endif; ?>
				<?php if (!empty(get_field('component_link_5'))): ?>
					<?php component_link_5(); ?>
				<?php endif; ?>
			</div>

		</div>

	</div>

</div>