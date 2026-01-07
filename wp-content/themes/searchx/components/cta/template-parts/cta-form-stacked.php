<div class="card shadow-none" data-aos="fade-up">
	<div class="card-body p-0">

		<div <?php component_row('justify-content-between align-items-end'); ?>>

			<div <?php component_col('col-lg-3 cta__image'); ?> data-aos="fade-up">
				<svg viewBox="0 0 306.39 610.05" xmlns="http://www.w3.org/2000/svg">
					<path d="M140.49 0l-28 28.13v138.49h41.39l25.41-25.41V79.32H169V137l-19.24 19.42h-26.88V32.31l22-22.15h151V53l-26.34 27.77H190.4v90.94l6.35 6.35h-55.17L112.9 212v258.11l-58.45 58.44H0v10.35h58.63l64.43-64.44V215.81l23.24-27.4h60.26V188l10 10v23.8h-54.29v-12h-10.35v22.33h84.22l22.51 22V320h-22.33l-19.42-19.42v-30.5h-39.75v10.35h29.41v24.5l10.7 10.71v225.07l-47.91 43.38-8.17-8.35 38.12-35-45.2-46.28-7.26 7.26 37.75 38.66-37.93 34.82 23.59 24.5H106v-84.22H95.65v94.57h98.74l-17.78-18.52 51.18-46.28V325.81l4.36 4.35H269v-80.41l-28-28.13h-13.75v-28.13l-26.32-26.32v-76h73.33l32.13-33.76V0z" fill="#173751" />
					<g fill="#FDD963">
						<path d="M225.42 206.72l-23.51-23.51 23.51-23.51 7.31 7.32-16.19 16.19 16.19 16.2z" />
						<path d="M193.2 206.72l-7.32-7.31 16.2-16.2-16.2-16.21 7.32-7.32 23.51 23.51z" />
					</g>
				</svg>
			</div>

			<div <?php component_col('col-lg-8 col-12 cta__form-cont'); ?> data-aos="fade-up">

				<div class="triangle"></div>

				<div class="card shadow-none">

					<div class="p-lg-16 p-md-12 p-8 cta__form cta__form-half card-body bg-white">

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
</div>