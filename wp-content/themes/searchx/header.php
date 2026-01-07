<?php
$bartext = get_field('global_header_cta_text', 'option');
$showbar_cookie = ($bartext && (!isset($_COOKIE['header_cta']) || $_COOKIE['header_cta'] !== 'true')) ? true : false;
$showbar = $bartext ? true : false;
$body_class = $showbar_cookie ? ' header-cta-bar-showed' : '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo("charset"); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<?php output_custom_fonts(); ?>
	<?php output_custom_styles(); ?>
</head>

<body <?php body_class($body_class); ?>>
	<?php wp_body_open(); ?>

	<a class="skip-to-link" href="#main">Skip to Main Content</a>

	<header id="header" class="header-primary header-search-dropdown">

		<?php if ($showbar) : ?>
			<script>
				let barContentDiv = document.createElement('div');
				const barContent = `
				<div id="header-cta-bar" class="header-cta">
					<?php echo $bartext; ?>
					<span id="header-cta-bar-close" class="header-cta-close">&times;</span>
				</div>
			`;
				barContentDiv.innerHTML = barContent;
				let sessionItem = sessionStorage.getItem("header_cta");
				console.log(sessionItem);
				if (!sessionItem || sessionItem !== 'hide') {
					document.getElementById('header').prepend(barContentDiv);
					const bar = document.getElementById('header-cta-bar');
					const close = document.getElementById('header-cta-bar-close');
					let date = new Date();
					date.setDate(date.getDate() + 7);
					close.addEventListener("click", function(e) {
						sessionStorage.setItem("header_cta", "hide");
						console.log(sessionItem);
						bar.remove();
						document.getElementsByTagName('body')[0].classList.remove('header-cta-bar-showed');
					});
				}
			</script>
		<?php endif; ?>

		<?php if (has_nav_menu("utility")): ?>
			<div class="header-utility">
				<div class="container d-flex justify-content-between align-items-center">
					<ul class="lang d-flex">
						<?php
						pll_the_languages(array(
							'show_names' => 0,
							'display_names_as' => 'slug'
						));
						?>
					</ul>
					<div class="d-flex align-items-center">
						<div class="d-flex align-items-center me-sm-2 header__contact">
							<?php if (get_has_theme_option('phone_number', false)): ?>
								<div class="d-flex align-items-center me-md-6">
									<i class="fa-solid fa-circle me-2 fa-xs text-success"></i>
									<div>
										<a href="tel:<?php echo get_has_theme_option('phone_number', ''); ?>">
											<?php echo get_has_theme_option('phone_number', ''); ?>
										</a>
									</div>
								</div>
							<?php endif; ?>
							<?php if (get_has_theme_option('email', false)): ?>
								<div class="d-md-flex d-none align-items-center me-6">
									<div>
										<a href="mailto:<?php echo get_has_theme_option('email', ''); ?>">
											<?php echo get_has_theme_option('email', ''); ?>
										</a>
									</div>
								</div>
							<?php endif; ?>
						</div>
						<div class="d-sm-block d-none">
							<?php wp_nav_menu([
								"theme_location" => "utility",
								"container" => false,
							]); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="container">
			<div class="wrapper-nav-primary flex-grow-1">

				<?php
				if (has_custom_logo()) {
					the_custom_logo();
				} else {
					output_logo_header();
				}
				?>

				<nav class="nav-primary ms-auto me-0">

					<?php if (has_nav_menu("primary")) {
						wp_nav_menu([
							"theme_location" => "primary",
							"container" => false,
							"walker" => new Arrow_Walker_Nav_Menu(),
						]);
					}
					// if primary menu
					?>

					<?php if (has_nav_menu("secondary")): ?>
						<div class="mobile-secondary">
							<?php wp_nav_menu([
								"theme_location" => "secondary",
							]); ?>
						</div>
					<?php endif;
					// if secondary menu
					?>

				</nav>

			</div><!--/.wrapper-nav-primary -->

			<div class="mobile-social d-none">
				<?php social_media_icons(); ?>
			</div>
			<?php $curr_lang = pll_current_language(); ?>
			<?php if (get_has_theme_option('cv_upload_form_' . $curr_lang, '')): ?>

				<button class="btn btn-sm btn-tertiary d-flex align-items-center py-md-2 ms-lg-6" data-bs-toggle="modal" data-bs-target="#uploadCVModal">
					<span class="mt-1 fw-semibold"><?php pll_e('Upload CV'); ?></span><i class="fa-lg fa-regular fa-folder-arrow-up"></i>
				</button>

			<?php endif; ?>
			<button class="mobile-menu-button" title="Mobile Menu">
				<div class="bar"></div>
				<div class="bar"></div>
				<div class="bar"></div>
			</button>
			</nav>
		</div><!--/.wrapper-nav-primary -->

		<div class="wrapper-nav-secondary">

			<?php if (has_nav_menu("secondary")) {
				wp_nav_menu([
					"theme_location" => "secondary",
					"container" => false,
					"walker" => new Arrow_Walker_Nav_Menu(),
				]);
			}
			// if secondary menu
			?>


		</div><!--/.wrapper-nav-secondary -->
		</div><!--/.container -->
	</header>
