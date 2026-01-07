<?php

/**
 * Global template used on archive.php and home.php
 *
 * This template part exists to provide consistency across all archive pages.
 * Use extreme caution when editing this template part as its effects are
 * far reaching.
 */
?>
<section class="archive--header bg-secondary py-16">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php get_template_part('template-parts/archive-filter-search'); ?>
			</div>
		</div>
	</div>
</section>

<section class="component archive">

	<h2 class="visually-hidden sr-only">Kennis</h2>

	<?php if (have_posts()): ?>

		<div class="container">

			<div class="row justify-content-center">

				<div class="col-lg-10 col-md-11 col-12">

					<div <?php component_card_group_row('archive', ['archive__row--cards', 'archive-feed']); ?>>

						<?php while (have_posts()): the_post();
							if (!is_sticky()) : ?>

								<div class="col archive__col" data-aos="fade-up">

									<?php get_template_part('template-parts/content', 'post'); ?>

								</div><!-- .col -->

						<?php endif;
						endwhile; ?>

					</div><!-- .row -->

					<div class="row archive__row archive__row--pagination mt-16">

						<?php posts_pagination(); ?>

					</div>

				</div>

			</div>

		</div><!-- .container -->

	<?php else: ?>

		<?php get_template_part('template-parts/content', 'none'); ?>

	<?php endif; ?>

</section>

<?php
$options = [
	'global-component_block_template' => component_directory('global-component') . 'templates/global-component.php',
	'component_picker' => get_has_theme_option('blog_component_picker', []),
];
the_component('global-component', $options);
?>