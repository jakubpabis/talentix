<div id="search-feed__result-<?php the_ID(); ?>" <?php post_class('search-feed__result'); ?>>
	<h2 class="search-feed__result-title h3 mb-0 mt-8">
		<a class="text-dark d-block" href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</h2>
	<?php the_excerpt(); ?>
	<hr>
</div>
