<?php
// template-parts/jobs/filters.php
?>
<div class="filters-container mb-4">
	<div class="row">
		<div class="col-xl-4 col-md-5 order-md-1 order-3 mt-md-0 mt-4">
			<div class="row mx-n3">
				<?php
				$taxonomies = array('job-industry', 'job-type', 'job-category');
				foreach ($taxonomies as $taxonomy) {
					$terms = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => true));
					if (!empty($terms) && !is_wp_error($terms) && count($terms) > 1) : ?>
						<div class="col-auto px-3">
							<div class="dropdown">
								<button class="btn btn-light bg-light btn-sm dropdown-toggle text-capitalize py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<?php pll_e(ucwords(str_replace('-', ' ', $taxonomy))); ?>
								</button>
								<div class="dropdown-menu p-0 shadow">
									<ul class="unstyled-list job-filter small p-4" data-taxonomy="<?php echo esc_attr($taxonomy); ?>">
										<?php
										foreach ($terms as $term) {
											if ($term->slug !== 'search-x-website-internal-jobs') {
												echo '<li data-value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</li>';
											}
										}
										?>
									</ul>
									<button type="button" class="btn btn-sm btn-primary text-capitalize py-2 w-100 clear-filter" data-default="<?php pll_e(ucwords(str_replace('-', ' ', $taxonomy))); ?>" data-taxonomy="<?php echo esc_attr($taxonomy); ?>">
										<?php pll_e('Clear filters'); ?>
									</button>
								</div>
							</div>
						</div>
				<?php endif;
				}
				?>
			</div>
		</div>
		<div class="col-xl-8 col-md-7 order-md-3 order-1 d-xl-none">
			<div class="job-searchbar bg-light">
				<input class="bg-light text-primary flex-grow-1" type="text" id="jobs-search-mobile" placeholder="<?php pll_e('Search jobs, keywords, companies'); ?>" value="<?php echo isset($_GET['s_query']) && !empty($_GET['s_query']) ? $_GET['s_query'] : ''; ?>">
				<button type="button" class="job-searchbar-btn">
					<i class="fa-regular fa-magnifying-glass"></i>
					<div class="sr-only"><?php pll_e('search') ?></div>
				</button>
			</div>
		</div>
	</div>

</div>
