<?php
$author_name = get_the_author();
if (get_the_author_meta('display_name')) {
	$author_name = get_the_author_meta('display_name');
} elseif (get_the_author_meta('first_name') || get_the_author_meta('last_name')) {
	$author_name = get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name');
}

?>

<div class="row justify-content-between align-items-end py-8 py-lg-10">

	<div class="col-lg-6" data-aos="fade-up">
		<div class="entry-meta">
			<div class="entry-meta__posted-on d-flex align-items-center">
				<span class="entry-meta__author">
					<div class="text-muted opacity-75 small">
						<?php pll_e('Written by'); ?>:
					</div>
					<a class="entry-meta__author-link h6 mb-0" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="View all posts by <?php the_author(); ?>"><?php echo $author_name; ?></a>
				</span>
			</div>
		</div>
	</div>

	<div class="col-lg-6" data-aos="fade-up">
		<div class="entry-meta d-flex align-items-center justify-content-end">
			<span class="entry-meta__date"><?php the_date(); ?></span>
			<span class="spacer mx-6"></span>
			<div class="entry-meta__share d-flex align-items-center">
				<?php $the_permalink = urlencode(get_the_permalink()); ?>
				<a class="entry-meta__share-link text-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $the_permalink; ?>" target="_blank">
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
	</div>

</div><!-- .entry-meta -->