<div class="card shadow-none" data-aos="fade-up">
	<div class="card-body p-0">

		<div <?php component_row('m-0'); ?>>

			<div <?php component_col('col-lg-6 col-12 d-block'); ?> data-aos="fade-up">

				<?php component_sub_header(); ?>

				<?php component_header(); ?>

				<?php component_text(); ?>

			</div>

			<div <?php component_col('col-lg-6 col-12 cta__form-cont'); ?> data-aos="fade-up">

				<div class="cta__form">

					<?php
					$cta_form = get_has_field('cta_form', []);
					if (is_array($cta_form)) {
						$form_id = get_has_field('id', 0, $cta_form);
						gravity_form($form_id, false, false, false, false, true);
					} else {
						echo '<p>No Form Chosen</p>';
					}
					?>

				</div>

			</div>

		</div>

	</div>
</div>