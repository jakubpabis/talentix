<div class="modal fade team__modal" id="<?php echo $modal_id; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $modal_id; ?>-Label" aria-hidden="true">

	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">

		<div class="modal-content">

			<div class="row">

				<div class="col-lg-5">

					<div class="modal-img">

						<?php the_post_thumbnail( 'full', [ 'class' => '' ] ); ?>

					</div>

				</div>

				<div class="col-lg">

					<div class="modal-header">

						<h4 class="modal-title" id="<?php echo $modal_id; ?>-Label"><?php the_title(); ?></h4>

						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">

							<span aria-hidden="true">&times;</span>

						</button>

					</div>

					<div class="modal-meta"><?php echo get_field( 'team_position_title', get_post() ); ?></div>

					<div class="modal-body"><?php the_content(); ?></div>

				</div>

			</div>

		</div>

	</div>

</div>
