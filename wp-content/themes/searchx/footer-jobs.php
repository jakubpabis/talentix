<?php

/**
 * The template for displaying the footer.
 */
?>

<footer id="footer" class="footer bg-primary text-white py-0">
	<div class="footer__bottom py-4">
		<div class="container">
			<div class="footer__row d-flex justify-content-between">
				<div class="footer__col">
					<?php
					printf(
						'<span>&copy; %1$s </span> %2$s <sup>&reg;</sup> All Rights Reserved',
						date('Y'),
						get_bloginfo('title')
					);
					?>
				</div>
				<div class="footer__col">
					made with <i class="fa-sharp-duotone fa-regular fa-heart text-danger"></i> by <a href="https://jakubpabis.com" class="text-white fw-medium" target="_blank">Jakub Pabis</a>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- #footer -->
<div class="mobile-overlay"></div>
<!-- Modal -->
<?php $curr_lang = pll_current_language(); ?>
<?php if (get_has_theme_option('cv_upload_form_' . $curr_lang, '')): ?>
	<div class="modal fade" id="uploadCVModal" tabindex="-1" aria-labelledby="uploadCVModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content bg-transparent border-0">
				<div class="card bg-tertiary shadow-none notched">
					<div class="card-body">
						<div class="d-flex justify-content-between mb-6">
							<h3 class="my-0"><?php pll_e('Upload CV'); ?></h3>
							<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
								<i class="fa-regular fa-xmark-large"></i>
							</button>
						</div>
						<?php
						$cta_form = get_has_theme_option('cv_upload_form_' . $curr_lang, []);
						if (is_array($cta_form)) {
							$form_id = get_has_field('id', 0, $cta_form);
							gravity_form($form_id, false, true, false, false, true);
						} else {
							echo '<p>No Form Chosen</p>';
						}
						?>
					</div>

				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php if (get_has_theme_option('job_apply_form_' . $curr_lang, '')): ?>
	<div class="modal fade" id="jobAppModal" tabindex="-1" aria-labelledby="jobAppModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content bg-transparent border-0">
				<div class="card bg-tertiary shadow-none notched">
					<div class="card-body">
						<div class="d-flex justify-content-between mb-6">
							<h4 class="my-0 modal-title"><?php pll_e('Apply for:'); ?> <span class="modal-job-title fw-normal d-lg-inline-block d-block"></span></h3>
								<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
									<i class="fa-regular fa-xmark-large"></i>
								</button>
						</div>
						<?php
						$cta_form = get_has_theme_option('job_apply_form_' . $curr_lang, []);
						if (is_array($cta_form)) {
							$form_id = get_has_field('id', 0, $cta_form);
							gravity_form($form_id, false, true, false, false, true);
						} else {
							echo '<p>No Form Chosen</p>';
						}
						?>
					</div>

				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php wp_footer(); ?>
</body>

</html>
