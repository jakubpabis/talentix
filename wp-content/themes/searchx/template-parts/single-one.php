<?php
	the_component( 'hero', [
		'hero_block_template'  => component_directory( 'hero' ) . '/templates/hero-default.php',
		'component_header'     => get_the_title(),
		'component_sub_header' => ( get_the_category() ) ? get_primary_term() : ''
	] );
?>

<section class="component">

	<div class="container">

		<div class="row row__single">

			<div class="col col__single">

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post single__post' ); ?>>

					<?php get_template_part( 'template-parts/entry', 'meta' ); ?>

					<?php get_template_part( 'template-parts/entry', 'content' ); ?>

				</article> <!-- article -->

			</div><!-- .col -->

		</div><!-- .row -->

	</div><!-- .container -->

</section>
