<section>
	<div class="container mt-16">
		<div class="row">
			<div class="col-12">
				<div class="wysiwyg__heading">
					<?php if (get_the_category()): ?>
						<p class="wysiwyg__subheader preheader mb-0"><?php echo get_primary_term(); ?></p>
					<?php endif; ?>
					<h1 class="h2 wysiwyg__header mt-3 mb-6"><?php echo get_the_title(); ?></h1>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="pb-12 pb-md-16 pb-lg-20">

	<div class="container">

		<article id="post-<?php the_ID(); ?>" <?php post_class('post single__post'); ?>>

			<div class="row justify-content-center">

				<?php /*
				<div class="col-lg-10 col-md-11 col-12">

					<?php get_template_part('template-parts/entry', 'meta'); ?>

					<?php // the_post_thumbnail('post-thumbnail', ['class' => 'single__featured-image rounded rounded-2', 'data-aos' => 'fade-up']);
					?>

				</div>
				*/ ?>

				<div class="col-lg-8 col-md-10 col-12" data-aos="fade-up">

					<?php get_template_part('template-parts/entry', 'content'); ?>

					<?php

					if (get_field('file_download')) :
						echo '<button type="button" data-bs-toggle="modal" data-bs-target="#whitepapersModal" class="btn btn-sm btn-tertiary fw-medium"><i class="fas fa-arrow-to-bottom me-4 ms-n1 fa-xl"></i>' . pll__("Download") . ' ' . get_field('file_download')['title'] . '</button>';
						if (get_field('button')) :
							echo '<br />';
						endif;
					endif;

					if (get_field('button')) :
						echo '<a href="' . get_field('button')['url'] . '" class="btn btn__default yellow">' . get_field('button')['title'] . '</a>';
					endif;

					?>

					<div class="entry-meta d-flex align-items-center mt-lg-20 mt-12">
						<span class="h6 me-4 my-0"><?php pll_e('Share'); ?></span>
						<div class="entry-meta__share d-flex align-items-center">
							<?php $the_permalink = urlencode(get_the_permalink()); ?>
							<a class="entry-meta__share-link text-primary ms-6" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $the_permalink; ?>" target="_blank">
								<i class="fab fa-facebook"></i>
							</a>
							<a class="entry-meta__share-link text-primary ms-6" href="https://twitter.com/home?status=<?php echo $the_permalink; ?>" target="_blank">
								<i class="fab fa-x-twitter"></i>
							</a>
							<a class="entry-meta__share-link text-primary ms-6" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $the_permalink; ?>" target="_blank">
								<i class="fab fa-linkedin"></i>
							</a>
						</div>
					</div>

				</div><!-- .col-md-10 col-xl-9 -->

			</div><!-- .row -->

		</article> <!-- #section -->

	</div><!-- #container -->

</section>

<?php if (get_field('file_download')) : ?>
	<div id="whitepapersModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="whitepapersModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content bg-transparent border-0">
				<div class="card bg-secondary shadow-none notched">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-start mb-10">
							<h4 class="modal-title d-block mt-0" id="whitepapersModalTitle"><?php pll_e('Download'); ?>&nbsp;<?php echo get_field('file_download')['title']; ?></h4>

							<button type="button" class="btn btn-close px-0" data-bs-dismiss="modal" aria-label="Close">
								<i class="fa-regular fa-xmark-large"></i>
							</button>
						</div>
						<div class="d-block">
							<h5 class="modal-title d-block mb-8"><?php pll_e('Give us your email and download the file'); ?></h5>
							<form class="pt-3" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" accept-charset="UTF-8" role="form" id="whitepapers-form" enctype="multipart/form-data">
								<div class="row">
									<div class="col-sm-3 dog">
										<svg viewBox="0 0 306.39 610.05" xmlns="http://www.w3.org/2000/svg">
											<path d="m140.49 0-28 28.13v138.49h41.39l25.41-25.41v-61.89h-10.29v57.68l-19.24 19.42h-26.88v-124.11l22-22.15h151v42.84l-26.34 27.77h-79.14v90.94l6.35 6.35h-55.17l-28.68 33.94v258.11l-58.45 58.44h-54.45v10.35h58.63l64.43-64.44v-258.65l23.24-27.4h60.26v-.41l10 10v23.8h-54.29v-12h-10.35v22.33h84.22l22.51 22v65.87h-22.33l-19.42-19.42v-30.5h-39.75v10.35h29.41v24.5l10.7 10.71v225.07l-47.91 43.38-8.17-8.35 38.12-35-45.2-46.28-7.26 7.26 37.75 38.66-37.93 34.82 23.59 24.5h-64.25v-84.22h-10.35v94.57h98.74l-17.78-18.52 51.18-46.28v-219.44l4.36 4.35h36.85v-80.41l-28-28.13h-13.75v-28.13l-26.32-26.32v-76h73.33l32.13-33.76v-57.41z" fill="#173751" />
											<g fill="#ffffff">
												<path d="m225.42 206.72-23.51-23.51 23.51-23.51 7.31 7.32-16.19 16.19 16.19 16.2z" />
												<path d="m193.2 206.72-7.32-7.31 16.2-16.2-16.2-16.21 7.32-7.32 23.51 23.51z" />
											</g>
										</svg>
									</div>
									<div class="col-sm-9 d-flex justify-content-center align-items-start ps-lg-16">
										<div class="d-flex w-100">
											<input type="email" name="whitepapers-email" value="" placeholder="<?php pll_e('Put in your email address here'); ?>" class="form-control" required>
											<input type="hidden" name="whitepapers-url" value="<?php echo get_field('file_download')['url']; ?>">
											<input type="hidden" name="whitepapers-filename" value="<?php echo get_field('file_download')['title']; ?>">
											<input type="hidden" name="action" value="whitepapers_form">
											<?php wp_nonce_field('whitepapers_form', 'whitepapers_form_nonce'); ?>
											<button type="submit" class="btn btn-primary d-flex align-items-center"><i class="fas fa-download"></i> <span class="ms-3">Download</span></button>
										</div>
									</div>
								</div>
							</form>
							<div class="row justify-content-end">
								<div class="col-auto">
									<a class="text-size-small" href="<?php echo get_field('file_download')['url']; ?>"><u><?php pll_e('Or just download the file without giving up your email'); ?></u></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
<?php endif; ?>