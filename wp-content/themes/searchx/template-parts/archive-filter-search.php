<div class="row">
	<div class="col-xl-8 col-lg-10 col-12">
		<div class="row z-99 position-relative m-0 p-0" data-aos="fade-up">

			<div class="col-lg-4 col-md-5 col-12 px-2 py-2 bg-white">
				<?php $primary_taxonomy = get_primary_taxonomy(); ?>
				<?php if (! empty($primary_taxonomy)) : ?>
					<div class="archive-filter-taxonomy w-100 z-99 m-0 h-100">
						<?php $archive_filter_id = "dropdown-menu-button" . uniqid(); ?>
						<button class="btn bg-grey-100 dropdown-toggle w-100 h-100 text-dark d-flex justify-content-between align-items-center px-5" type="button" id="<?php echo $archive_filter_id; ?>" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php pll_e('Choose Category'); ?>
						</button>
						<div class="dropdown-menu archive-filter-taxonomy__menu bg-white w-100 z-99" aria-labelledby="<?php echo $archive_filter_id; ?>">

							<a class="dropdown-item archive-filter-taxonomy__anchor archive-filter-taxonomy__anchor--active bg-white" href="<?php echo get_post_type_archive_link(get_post_type()); ?>" data-category="0">All</a>

							<?php
							// Zamień na swoją taxonomię
							// $primary_taxonomy = 'category'; // już powinno być ustawione

							function get_term_id_by_name($name, $taxonomy)
							{
								$term = get_term_by('name', $name, $taxonomy);
								return $term ? $term->term_id : 0;
							}

							// Funkcja rekurencyjna – pobiera wszystkich potomków termu
							function get_descendants($term_id, $terms_map)
							{
								$descendants = [];
								foreach ($terms_map as $term) {
									if ($term->parent == $term_id) {
										$descendants[] = $term;
										$descendants = array_merge($descendants, get_descendants($term->term_id, $terms_map));
									}
								}
								return $descendants;
							}

							// Renderuj drzewa hierarchii
							function render_term_hierarchy($terms, $depth = 0)
							{
								foreach ($terms as $term) {
									$indent = str_repeat('&nbsp;', $depth * 4);
							?>
									<a class="dropdown-item archive-filter-taxonomy__anchor"
										href="<?php echo get_term_link($term); ?>"
										data-category="<?php echo $term->term_id; ?>">
										<?php echo $indent . esc_html($term->name); ?>
									</a>
									<?php
									if (!empty($term->children)) {
										render_term_hierarchy($term->children, $depth + 1);
									}
								}
							}

							// Pobierz wszystkie terminy do mapy
							$terms_query = new WP_Term_Query(array(
								'taxonomy' => $primary_taxonomy,
								'hide_empty' => true,
								'orderby' => 'name',
								'order' => 'ASC'
							));
							$terms = $terms_query->terms;
							$terms_map = [];
							foreach ($terms as $term) {
								$terms_map[$term->term_id] = $term;
								$term->children = [];
							}

							// Przetwarzaj każdą główną kategorię z osobna
							$root_terms = [
								'Kennis',
								'Knowledge'
							];

							foreach ($root_terms as $root_name) {
								$root_id = get_term_id_by_name($root_name, $primary_taxonomy);
								if ($root_id && isset($terms_map[$root_id])) {
									// Pobierz wszystkich potomków danej kategorii
									$descendants = get_descendants($root_id, $terms_map);

									// Przygotuj strukturę hierarchiczną (tylko pod „rootem”)
									$hierarchy = [];
									foreach ($descendants as $desc) {
										$desc->children = [];
										foreach ($descendants as $child) {
											if ($child->parent == $desc->term_id) $desc->children[] = $child;
										}
										// Tylko bezpośrednie dzieci "ROOT"
										if ($desc->parent == $root_id)
											$hierarchy[] = $desc;
									}

									// WYŚWIETL NAZWĘ ROOTA JAKO NAGŁÓWEK
									?>
							<?php

									// Renderuj drzewo wybranej kategorii
									render_term_hierarchy($hierarchy);
								}
							}
							?>

						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="col-lg-8 col-md-7 col-12 px-2 py-md-2 pb-2 bg-white">
				<div class="archive-filter-search m-0 h-100">
					<?php
					blennder_search_form([
						'form_id' => 'search-blog',
						'input_id' => 'search-blog-btn',
						'aria-describedby' => 'search-blog-submit',
					]);
					?>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- <div class="archive-filter-view" aria-hidden="true">
	<button tabindex="-1" href="#" class="archive-filter-view__button archive-filter-view__button--active" data-blog-view="grid">
		<i class="fas fa-th archive-filter-view__icon"></i>
	</button>
	<button tabindex="-1" href="#" class="archive-filter-view__button" data-blog-view="list">
		<i class="fas fa-list archive-filter-view__icon"></i>
	</button>
</div> -->