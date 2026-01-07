<?php
/**
 * Template Name: Image Gallery Grid
 */
?>
<div <?php component_row(); ?>>

	<?php require locate_template( 'template-parts/component-heading.php' ); ?>

</div>

<div <?php component_row(); ?>>

	<div <?php component_col(); ?>>

		<?php $imgs = get_has_field( 'image_gallery', [] ); ?>

		<?php $uniqid = uniqid(); ?>

		<div class="gallery gallery-columns-xs-1 gallery-columns-sm-2 gallery-columns-md-3 gallery-columns-lg-3">

			<?php foreach( $imgs as $img ) : ?>

				<div class="gallery-item">

					<div class="gallery-icon">

					<?php $url = wp_get_attachment_image_src( $img[ 'ID' ], 'full' ); ?>

						<a href="<?php echo $url[0] ?? ''; ?>" data-fancybox="gallery-<?php echo $uniqid; ?>">

							<?php echo wp_get_attachment_image( $img[ 'ID' ], 'blog_feed' ); ?>

						</a>

					</div>

				</div>

			<?php endforeach; ?>

		</div>

	</div>

</div>
