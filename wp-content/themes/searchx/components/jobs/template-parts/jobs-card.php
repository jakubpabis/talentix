<div class="card jobs__card shadow-none bg-white notched" data-aos="fade-up">

	<a href="<?php the_permalink(); ?>" class="wrapped-link">

		<div class="card-body d-flex flex-column justify-content-between h-100">

			<h3 class="h6 fw-semibold jobs-card__title mb-auto mt-2">

				<?php the_title(); ?>

			</h3>

			<div class="card-text jobs-card__excerpt mt-2 mb-0">

				<div class="row justify-content-between align-items-end">

					<div class="col-9">

						<div class="salary small fw-medium row mt-4 align-items-center line-height-1">
							<div class="col-2 pe-0">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19 20">
									<path fill="#183153" d="M6.3 19.8a8.162 8.162 0 003.15-.612c.998.414 2.07.622 3.15.612 3.28 0 5.85-1.75 5.85-3.986v-3.728c0-2.236-2.57-3.986-5.85-3.986-.152 0-.301.007-.45.015V3.9C12.15 1.71 9.58 0 6.3 0S.45 1.71.45 3.9v12c0 2.19 2.57 3.9 5.85 3.9zm10.35-3.986c0 1.034-1.663 2.186-4.05 2.186-2.387 0-4.05-1.152-4.05-2.186v-.833a7.496 7.496 0 004.05 1.09 7.496 7.496 0 004.05-1.09v.833zM12.6 9.9c2.387 0 4.05 1.152 4.05 2.186s-1.663 2.185-4.05 2.185c-2.387 0-4.05-1.152-4.05-2.185 0-1.033 1.663-2.186 4.05-2.186zM6.3 1.8c2.387 0 4.05 1.107 4.05 2.1 0 .992-1.663 2.1-4.05 2.1-2.387 0-4.05-1.107-4.05-2.1 0-.994 1.663-2.1 4.05-2.1zM2.25 6.734A7.62 7.62 0 006.3 7.8a7.62 7.62 0 004.05-1.066v1.663c-.98.247-1.88.746-2.61 1.446A6.925 6.925 0 016.3 10c-2.387 0-4.05-1.107-4.05-2.1V6.734zm0 4A7.628 7.628 0 006.3 11.8c.16 0 .315-.02.473-.028a2.79 2.79 0 00-.023.314v1.876c-.151.01-.297.038-.45.038-2.387 0-4.05-1.107-4.05-2.1v-1.166zm0 4A7.62 7.62 0 006.3 15.8c.151 0 .3-.012.45-.019v.033c.013.766.307 1.5.827 2.063-.421.08-.848.12-1.277.123-2.387 0-4.05-1.107-4.05-2.1v-1.166z" />
								</svg>
							</div>
							<div class="ps-1 col-10">
								€ <?php echo number_format(get_field('salary_min', get_the_ID()), 0, ',', '.'); ?>
								-
								€ <?php echo number_format(get_field('salary_max', get_the_ID()), 0, ',', '.'); ?>
							</div>
						</div>

						<div class="location small fw-medium row mt-4 align-items-center line-height-1">
							<div class="col-2 pe-0">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 20">
									<g fill="#183153" stroke="#183153" stroke-width=".5">
										<path d="M14.358 4.146C12.976 2.146 10.788 1 8.352 1 5.916 1 3.727 2.147 2.345 4.146.971 6.136.653 8.654 1.495 10.88a5.755 5.755 0 001.06 1.751l5.315 6.243a.632.632 0 00.963 0l5.314-6.241a5.76 5.76 0 001.06-1.749c.843-2.229.526-4.747-.85-6.737zm-.336 6.294a4.513 4.513 0 01-.837 1.37l-4.833 5.677-4.836-5.68a4.516 4.516 0 01-.837-1.371c-.695-1.84-.431-3.923.707-5.57a5.955 5.955 0 014.966-2.6c2.013 0 3.823.947 4.965 2.6a6.046 6.046 0 01.705 5.574z" />
										<path d="M8.352 4.754a3.547 3.547 0 00-3.544 3.543 3.547 3.547 0 003.544 3.544 3.547 3.547 0 003.543-3.544 3.547 3.547 0 00-3.543-3.543zm0 5.821a2.28 2.28 0 01-2.278-2.278A2.28 2.28 0 018.352 6.02a2.28 2.28 0 012.277 2.278 2.28 2.28 0 01-2.277 2.278z" />
									</g>
								</svg>
							</div>
							<div class="ps-1 col-10">
								<?php echo get_field('location', get_the_ID()); ?>
							</div>
						</div>

						<?php if (!empty(get_the_terms(get_the_ID(), 'job-type'))): ?>
							<div class="type small fw-medium row mt-4 align-items-center line-height-1">
								<div class="col-2 pe-0">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
										<g fill="#183153" stroke="#183153" stroke-width=".9">
											<path d="M8.92 16.84C4.553 16.84 1 13.287 1 8.92S4.553 1 8.92 1s7.92 3.553 7.92 7.92-3.553 7.92-7.92 7.92zm0-14.738A6.826 6.826 0 002.102 8.92a6.826 6.826 0 006.818 6.818 6.826 6.826 0 006.818-6.818A6.826 6.826 0 008.92 2.102z" />
											<path d="M11.272 11.8a.518.518 0 01-.275-.079L8.453 10.14a.54.54 0 01-.253-.46V5.858c0-.297.236-.538.528-.538.291 0 .528.241.528.538v3.52l2.29 1.424a.544.544 0 01.177.74.525.525 0 01-.451.258h0z" />
										</g>
									</svg>
								</div>
								<div class="ps-1 col-10">
									<?php echo get_the_terms(get_the_ID(), 'job-type')[0]->name; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php /** if (!empty(get_the_terms(get_the_ID(), 'job-industry'))): ?>
							<div class="industry small fw-medium row mt-4 align-items-center line-height-1">
								<div class="col-2 pe-0">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19 17">
										<g fill="none" fill-rule="evenodd" stroke="#183153" stroke-width="1.782">
											<path d="M1 14.77V5.86l1.279-1.215H15.92L17.2 5.86v8.91l-1.279 1.215H2.28z" />
											<path d="M12.34 15.985V2.263l-.81-.858H6.67l-.81.858v13.722" />
										</g>
									</svg>
								</div>
								<div class="ps-1 col-10">
									<?php echo get_the_terms(get_the_ID(), 'job-industry')[0]->name; ?>
								</div>
							</div>
						<?php endif; */ ?>

					</div>

					<div class="col-auto text-end small line-height-1">
						<?php days_since(); ?>
					</div>

				</div>

			</div>

		</div>

	</a>

</div>