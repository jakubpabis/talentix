<?php

/**
 * The search template file.
 */

get_header(); ?>

<main id="main" role="main">

	<section class="component search-feed">

		<div class="container">

			<div class="row search-feed__row justify-content-center">

				<div class="col search-feed__col">

					<?php get_template_part('template-parts/search-bar'); ?>

					<?php if (have_posts()): ?>

						<p>Results <?php the_search_query_results(); ?> for <span class="font-weight-bold"><?php the_search_query(); ?></span></p>

						<div class="search-feed__results mt-12">

							<?php while (have_posts()): the_post(); ?>

								<?php get_template_part('template-parts/content', 'search'); ?>

							<?php endwhile; ?>

						</div>

					<?php else: ?>

						<?php get_template_part('template-parts/content', 'none'); ?>

					<?php endif; ?>

					<div class="search-feed__pagination">

						<?php posts_pagination(); ?>

					</div>

				</div><!-- .col -->

			</div><!-- .row -->

		</div><!-- .container -->

	</section>

</main>

<?php get_footer(); ?>
