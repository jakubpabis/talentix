<?php

/**
 * The template for displaying the footer.
 */
?>

<footer id="footer" class="footer bg-primary text-white">
	<div class="footer__main">
		<div class="container-xl container-fluid">
			<div class="footer__row row justify-cotent-center px-xl-0 px-md-8">
				<div class="footer__col col-12 d-flex flex-column align-items-center justify-content-center">
					<?php
					if (has_custom_logo()) {
						the_custom_logo();
					} elseif (output_logo_footer()) {
						output_logo_footer();
					}
					?>
					<?php if (get_field('footer_text', 'options')): ?>
						<div class="footer__text">
							<?php echo get_field('footer_text', 'options'); ?>
						</div>
					<?php endif; ?>
					<?php social_media_icons(); ?>
					<ul class="lang d-flex">
						<?php
						pll_the_languages(array(
							'show_names' => 0,
							'display_names_as' => 'slug'
						));
						?>
					</ul>
				</div>
				<div class="footer__col col-lg-3 col-sm-6 order-lg-1 pt-lg-12 pt-md-16 pt-12">
					<span class="lead fw-semibold text-white text-uppercase">Office</span>
					<?php echo get_has_theme_option('address', '') ? '<div class="d-flex mt-8"><i class="fa-solid fa-location-dot me-3"></i><div>' . get_has_theme_option('address', '') . '</div></div>' : ''; ?>
					<?php echo get_has_theme_option('address_2', '') ? '<div class="d-flex mt-8"><i class="fa-solid fa-location-dot me-3"></i><div>' . get_has_theme_option('address_2', '') . '</div></div>' : ''; ?>
					<?php echo get_has_theme_option('address_3', '') ? '<div class="d-flex mt-8"><i class="fa-solid fa-location-dot me-3"></i><div>' . get_has_theme_option('address_3', '') . '</div></div>' : ''; ?>
					<?php if (get_has_theme_option('phone_number', false)): ?>
						<div class="d-flex mt-8 align-items-center">
							<i class="fa-solid fa-phone me-3"></i>
							<div>
								<a href="tel:<?php echo get_has_theme_option('phone_number', ''); ?>">
									<?php echo get_has_theme_option('phone_number', ''); ?>
								</a>
							</div>
						</div>
					<?php endif; ?>
					<?php if (get_has_theme_option('email', false)): ?>
						<div class="d-flex mt-8 align-items-center">
							<i class="fa-regular fa-envelope me-3"></i>
							<div>
								<a href="mailto:<?php echo get_has_theme_option('email', ''); ?>">
									<?php echo get_has_theme_option('email', ''); ?>
								</a>
							</div>
						</div>
					<?php endif; ?>
					<div class="mt-8">
						<p>
							<strong>KVK:</strong> 97710849<br />
							<strong>BTW:</strong> NL868195960B01<br />
							<strong>BANK:</strong> NL48BUNQ2157351272
						</p>
					</div>
				</div>
				<div class="footer__col col-lg-6 col-12 order-lg-2 order-3 col-12 pt-lg-12 pt-md-16 pt-12">
					<div class="d-none d-sm-block">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'footer-menu',
							'container' => '',
							'depth' => 2,
							'before' => ' ',
							'menu_class' => '',
							'menu_id' => 'footer-menu',
							'echo' => true,
							'fallback_cb' => false,
						));
						?>
					</div>
					<div class="d-block d-sm-none">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'footer-menu',
							'container' => '',
							'depth' => 2,
							'before' => ' ',
							'menu_class' => '',
							'menu_id' => 'footer-menu-mobile',
							'echo' => true,
							'fallback_cb' => false,
							"walker" => new Arrow_Walker_Nav_Menu(),
						));
						?>
					</div>
				</div>

			</div>
			<?php if (get_has_theme_option('footer_gallery', false)): ?>
				<div class="footer__row row justify-content-center footer__gallery mt-10 flex-wrap">
					<div class="col-12 text-center">
						<p class="text-uppercase lead fw-semibold font-primary my-2">
							<?php pll_e('Our awards'); ?>
						</p>
					</div>
					<?php foreach (get_theme_option('footer_gallery') as $item): ?>
						<?php acf_single_image($item['ID'], 'medium'); ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="footer__bottom">
		<div class="container">
			<div class="footer__row d-flex flex-wrap flex-md-row flex-column justify-content-xl-between justify-content-center align-items-center">
				<div class="footer__col d-flex align-items-center mt-lg-0 mt-4">
					<div>
						<?php
						printf(
							'<span>&copy; %1$s </span> %2$s <sup>&reg;</sup> All Rights Reserved',
							date('Y'),
							get_bloginfo('title')
						);
						?>
					</div>

				</div>
				<div class="footer__col d-flex align-items-center mt-lg-0 mt-4">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'footer-legal',
						'container' => '',
						'depth' => 1,
						'before' => ' ',
						'menu_id' => 'footer-legal',
						'echo' => true,
						'fallback_cb' => 'footer_legal_fallback',
					));
					?>
				</div>
				<div class="footer__col mt-xl-0 mt-4">
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
							<button type="button" class="btn btn-close px-0" data-bs-dismiss="modal" aria-label="Close">
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
<?php wp_footer(); ?>
</body>

</html>