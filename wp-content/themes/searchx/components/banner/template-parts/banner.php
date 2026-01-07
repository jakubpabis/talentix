<div <?php component_row('align-items-center z-index-1 position-relative'); ?>>
	<?php if (get_has_field('image', false)): ?>
		<div <?php component_col($image_class); ?>>
			<?php acf_image('image', 'full'); ?>
		</div>
	<?php endif; ?>
	<div <?php component_col($content_class); ?>>
		<?php component_sub_header(); ?>
		<?php component_header(); ?>
		<?php component_text(); ?>
		<?php if (!empty(get_field('component_link')) || !empty(get_field('component_link_2')) || !empty(get_field('component_link_3')) || !empty(get_field('component_link_4')) || !empty(get_field('component_link_5'))): ?>
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
		<?php endif; ?>
	</div>
</div>