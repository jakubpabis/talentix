<div <?php component_row('align-items-start'); ?>>

	<div <?php component_col('text-media__col-media col-lg-4 col-12'); ?> data-aos="fade-up">

		<?php
		$media = get_has_field('text_media_media_type', 'image');
		include component_part_path("text-media-{$media}");
		?>

	</div>

	<div <?php component_col('text-media__col-content col-lg-8 col-12 pt-sm-0 pt-4'); ?> data-aos="fade-up">

		<div class="<?php component_name(); ?>__content">

			<?php
			component_sub_header();
			component_header();
			?>

			<div class="text-media--big__content">
				<?php
				component_text();
				echo '<div class="d-flex flex-wrap component__header-buttons mx-n3">';
				if (!empty(get_field('component_link'))) {
					component_link();
				}
				if (!empty(get_field('component_link_2'))) {
					component_link_2();
				}
				if (!empty(get_field('component_link_3'))) {
					component_link_3();
				}
				if (!empty(get_field('component_link_4'))) {
					component_link_4();
				}
				if (!empty(get_field('component_link_5'))) {
					component_link_5();
				}
				echo '</div>';
				?>
			</div>

		</div>

	</div>

</div>