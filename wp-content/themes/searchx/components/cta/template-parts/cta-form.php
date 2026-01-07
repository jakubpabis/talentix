<div class="card shadow-none" data-aos="fade-up">
	<div class="card-body p-0">

		<div <?php component_row('m-0'); ?>>

			<div <?php component_col('col-lg-6 col-12 cta__image'); ?> data-aos="fade-up">
				<?php acf_image('cta_image', 'medium_large', ['class' => 'object-fit-cover']); ?>
			</div>

			<div <?php component_col('col-lg-6 col-12 cta__form-cont'); ?> data-aos="fade-up">

				<div class="p-xl-16 p-lg-12 cta__form">

					<?php component_sub_header(); ?>

					<?php component_header(); ?>

					<?php component_text(); ?>

					<?php
					$cta_form = get_has_field('cta_form', []);
					if (is_array($cta_form)) {
						$form_id = get_has_field('id', 0, $cta_form);
						gravity_form($form_id, true, true, false, false, true);
					} else {
						echo '<p>No Form Chosen</p>';
					}
					?>

				</div>

			</div>

		</div>

	</div>
</div>