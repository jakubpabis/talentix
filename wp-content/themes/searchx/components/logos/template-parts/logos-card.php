<div class="card logos__card" data-aos="fade-up">
	<?php if (has_field('logo_link', $logo)): ?>
		<a href="<?php echo $logo['logo_link']['url']; ?>" title="<?php echo $logo['logo_link']['title']; ?>">
		<?php endif; ?>
		<?php acf_image('logo_image', 'logo', ['class' => 'logos__image'], $logo); ?>
		<?php if (has_field('logo_link', $logo)): ?>
		</a>
	<?php endif; ?>
</div>