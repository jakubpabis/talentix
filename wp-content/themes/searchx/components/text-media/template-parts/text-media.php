<?php
$template_name = get_component_template_name();
$style = '';
$corners = '';
if (component_corners()['type'] === 'container') {
	$corners = component_corners()['style'];
	$style .= 'style="' . $corners . ';"';
}

?>

<?php if ($template_name === 'text-media-card-left' || $template_name === 'text-media-card-right'): ?>
	<div class="card shadow-none" data-aos="fade-up" <?php echo $style; ?>>
		<div class="card-body p-lg-16 bg-white">
		<?php endif; ?>

		<div <?php component_row('align-items-center justify-content-between'); ?>>

			<div <?php component_col('text-media__col-media col-lg-6 col-12'); ?> data-aos="fade-up">

				<?php
				$media = get_has_field('text_media_media_type', 'image');
				include component_part_path("text-media-{$media}");
				?>

			</div>

			<div <?php component_col('text-media__col-content col-lg-6 col-12 pt-lg-0 pt-6'); ?> data-aos="fade-up">

				<div class="<?php component_name(); ?>__content">

					<?php component_content(); ?>

				</div>

			</div>

		</div>

		<?php if ($template_name === 'text-media-card-left' || $template_name === 'text-media-card-right'): ?>
		</div>
	</div>
<?php endif; ?>