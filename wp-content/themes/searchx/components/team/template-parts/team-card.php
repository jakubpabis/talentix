<div class="card card--light">

	<a <?php team_link_atts( $modal_id ); ?>>

	<?php if( has_post_thumbnail() ): ?>

		<div class="card-img-wrapper">

			<?php the_post_thumbnail( 'blog_card', [ 'class' => 'team__image' ] ); ?>

		</div>

	<?php endif; ?>

		<div class="card-body">

			<h3 class="team__title">

				<?php the_title(); ?>

			</h3>

			<p>

				<?php echo get_field('team_position_title', get_the_ID());	?>

			</p>

		</div>

	</a>

</div>
