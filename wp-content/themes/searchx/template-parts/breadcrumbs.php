<?php $data_links = get_breadcrumbs(); ?>
<?php if (!empty($data_links)) : ?>
	<section class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="hero-breadcrumbs-container">
						<div class="hero-breadcrumbs">
							<ol class="list-unstyled m-0 p-0">
								<?php foreach ($data_links as $index => $link) : ?>
									<li class="d-inline-block">
										<a <?php echo count($data_links) > $index + 1 ? '' : null; ?> href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>
									</li>
									<?php if (count($data_links) > $index + 1): ?>
										<li class="d-inline-block">
											<i class="fas fa-chevron-right"></i>
										</li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>