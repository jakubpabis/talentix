<?php
// template-parts/jobs/job-list.php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
$job_id = false;
if (is_singular('jobs') && get_queried_object() && isset(get_queried_object()->ID)) {
	$job_id = get_queried_object()->ID;
} else if (isset($_GET['job_id'])) {
	$job_id = $_GET['job_id'];
}
?>

<div class="jobs-list-container pb-20">
	<div class="jobs-list-sorting d-flex align-items-sm-center align-items-end">
		<div class="jobs-list-count"><span class="number"></span>&nbsp;<span><?php pll_e('jobs found') ?></span></div>
		<div class="jobs-sorting-dropdown">
			<button class="jobs-sorting dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
				<?php pll_e('Newest &rarr; oldest') ?>
			</button>
			<ul class="dropdown-menu list-unstyled dropdown-menu-end jobs-ordering">
				<li class="active" data-by="date" data-order="DESC"><a class="dropdown-item" href="javascript:void(0)"><?php pll_e('Newest &rarr; oldest'); ?></a></li>
				<li data-by="date" data-order="ASC"><a class="dropdown-item" href="javascript:void(0)"><?php pll_e('Oldest &rarr; newest'); ?></a></li>
				<li data-by="salary" data-order="DESC"><a class="dropdown-item" href="javascript:void(0)"><?php pll_e('Highest salary'); ?></a></li>
				<li data-by="salary" data-order="ASC"><a class="dropdown-item" href="javascript:void(0)"><?php pll_e('Lowest salary'); ?></a></li>
			</ul>
		</div>
	</div>
	<div id="jobs-list">
		<?php if ($job_id) : ?>

			<?php
			$top_job = get_post(intval($job_id));
			if ($top_job):
			?>

				<?php

				$top_job->meta = get_fields($top_job->ID);
				$top_job->meta['salaryMin'] = number_format(get_field('salary_min', $top_job->ID), 0, '', '.');
				$top_job->meta['salaryMax'] = number_format(get_field('salary_max', $top_job->ID), 0, '', '.');
				$top_job->meta['location'] = get_field('location', $top_job->ID);
				$terms = get_the_terms($top_job->ID, 'job-type');
				$top_job->meta['type'] = !empty($terms) ? $terms[0]->name : '';
				$top_job->meta['date'] = get_time_since_published(false, $top_job->ID);

				?>

				<div class="job-item mb-6 active" data-job-id="<?php echo $top_job->ID; ?>">
					<div class="job-item-content py-md-5 py-4 ps-md-7 ps-4 pe-md-14 pe-13">
						<span class="lead fw-bold mt-0"><?php echo $top_job->post_title; ?></span>
						<div class="job-meta small d-flex flex-column">
							<?php if ($top_job->meta['salaryMin'] || $top_job->meta['salaryMax']): ?>
								<div class="job-meta-item">
									<i class="meta-icon me-3 icon-job-salary"></i>
									<?php echo $top_job->meta['salaryMin'] ? '€ ' . $top_job->meta['salaryMin'] : ''; ?>
									<?php echo $top_job->meta['salaryMin'] && $top_job->meta['salaryMax'] ? '&nbsp;&nbsp;-&nbsp;&nbsp;€ ' . $top_job->meta['salaryMax'] : ''; ?>
								</div>
							<?php endif; ?>
							<?php if ($top_job->meta['location']): ?>
								<div class="job-meta-item"><i class="meta-icon me-3 icon-job-location"></i><?php echo $top_job->meta['location'] ?></div>
							<?php endif; ?>
							<?php if ($top_job->meta['type']): ?>
								<div class="job-meta-item"><i class="meta-icon me-3 icon-job-type"></i><?php echo $top_job->meta['type'] ?></div>
							<?php endif; ?>
						</div>
						<div class="job-meta-right py-md-5 py-4 pe-md-7 pe-4">
							<div class="job-date">
								<?php echo $top_job->meta['date']; ?>
							</div>
						</div>
					</div>
					<a href="<?php echo get_permalink($job_id); ?>" class="hidden-href"></a>
				</div>

			<?php endif; ?>

		<?php endif; ?>

	</div>
</div>