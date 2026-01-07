<div class="card blurbs__card">

	<?php $btn = get_has_field( 'blurb_button', [], $blurb ); ?>

	<?php $url = get_has_field( 'url', '', $btn ); ?>

	<?php $title = get_has_field( 'title', '', $btn ); ?>

	<?php if( $url ) : ?>

	<a href="<?php echo $url; ?>" class="wrapped-link">

	<?php endif; ?>

		<?php if( has_field( 'blurb_image_icon', $blurb ) ): ?>

			<div class="blurbs__graphic">

				<?php acf_image( 'blurb_image_icon', [ 80, 80 ], [], $blurb ); ?>

			</div>

		<?php endif; ?>

		<div class="blurbs__body">

			<h3 class="blurbs__title"><?php echo get_has_field( 'blurb_title', '', $blurb ); ?></h3>

			<div class="blurbs__text">
				<?php acf_wysiwyg( 'blurb_content', [], $blurb ); ?>
			</div>

			<?php if( $url ) : ?>

				<span class="blurbs__link btn-text"><?php echo $title; ?></span>

			<?php endif; ?>

		</div>

	<?php if( $url ) : ?>

	</a>

	<?php endif; ?>

</div>
