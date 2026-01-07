<?php
/**
 * Template Name: Image Gallery Masonry
 */
?>
<div <?php component_row(); ?>>

	<?php require locate_template( 'template-parts/component-heading.php' ); ?>

</div>

<div <?php component_row(); ?>>

	<div <?php component_col(); ?>>

		<div class="grid">

			<span class="grid-gutter"></span>

			<?php if( has_field( 'image_gallery' ) ) : ?>

				<?php $sizes = [
					'gallery_tall',
					'blog_feed',
					'blog_feed',
					'gallery_tall',
				]; ?>

				<?php $uniqid = uniqid(); ?>

				<?php foreach( get_has_field( 'image_gallery', [] ) as $key => $img ) : ?>

					<div class="grid-item">

						<a href="<?php echo wp_get_attachment_image_url( $img[ 'id' ], 'post-thumbnail' ); ?>" data-fancybox="gallery-masonry-<?php echo $uniqid; ?>"><?php echo wp_get_attachment_image( $img[ 'id' ], $sizes[$key % 4] ); ?></a>

					</div>

				<?php endforeach; ?>

			<?php endif; ?>

		</div>

	</div>

</div>
