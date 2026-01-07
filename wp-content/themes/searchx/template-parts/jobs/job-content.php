<?php
// template-parts/jobs/job-content.php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
$job_id = false;
if (is_singular('jobs') && get_queried_object() && isset(get_queried_object()->ID)) {
	$job_id = get_queried_object()->ID;
	$loxo_job_id = get_field('job_id', $job_id);
	$salaryMin = number_format(get_field('salary_min', $job_id), 0, '', '.');
	$salaryMax = number_format(get_field('salary_max', $job_id), 0, '', '.');
	$location = get_field('location', $job_id);
	$terms = get_the_terms($job_id, 'job-type');
	$type = !empty($terms) ? $terms[0]->name : '';
	$date = get_time_since_published(true, $job_id);
	$recruiter = !empty(get_field('recruiter_related', $job_id)) ? get_field('recruiter_related', $job_id)[0] : false;
	if ($recruiter) {
		$recruiterName = $recruiter->post_title;
		$recruiterPhoto = get_the_post_thumbnail($recruiter, 'medium');
		$recruiterPhone = get_field('phone', $recruiter);
		$recruiterWhatsapp = get_field('whatsapp', $recruiter);
		$recruiterCal = get_field('calendly', $recruiter);
	}
}
?>
<article class="col-xl-8 col-lg-7 col-12 job-content-container-scroll">
	<div class="job-content-container">
		<div id="job-content-meta" class="job-content-meta py-xxl-5 py-4 px-xxl-5 px-4">

			<?php if ($job_id) : ?>
				<div class="d-flex justify-content-between mb-xxl-4 mb-2 align-items-start">
					<h6 class="m-0 job-content-title"><?php echo get_the_title($job_id); ?></h6>
					<button type="button" data-bs-toggle="modal" data-bs-target="#jobAppModal" data-jobtitle="<?php echo get_the_title($job_id); ?>" data-jobid="<?php echo $loxo_job_id; ?>" class="btn btn-sm btn-tertiary">
						<i class="fa-solid fa-bolt me-2 ms-0"></i>
						<?php pll_e('Apply for this job'); ?>
					</button>
				</div>
				<div class="d-flex justify-content-between align-items-stretch">
					<div class="job-meta small d-flex flex-wrap flex-grow-1">
						<?php if ($salaryMin || $salaryMax) : ?>

							<div class="job-meta-item w-auto me-7">
								<i class="meta-icon me-3 icon-job-salary"></i>
								<?php echo $salaryMin ? '€ ' . $salaryMin : ''; ?>
								<?php echo $salaryMin && $salaryMax ? '&nbsp;&nbsp;-&nbsp;&nbsp;€ ' . $salaryMax : ''; ?>
							</div>

						<?php endif; ?>

						<?php if ($location): ?>
							<div class="job-meta-item w-auto me-7">
								<i class="meta-icon me-3 icon-job-location"></i>
								<?php echo $location; ?>
							</div>
						<?php endif; ?>

						<?php if ($type): ?>
							<div class="job-meta-item w-auto me-7">
								<i class="meta-icon me-3 icon-job-type"></i>
								<?php echo $type; ?>
							</div>
						<?php endif; ?>

					</div>
					<div class="job-meta-right">
						<div class="job-date text-nowrap">
							<?php echo $date; ?>
						</div>

					</div>
				</div>
			<?php endif; ?>

		</div>
		<div id="job-content" class="py-xxl-5 py-4 px-xxl-5 px-4">

			<?php if ($job_id) : ?>
				<div class="job-content small">
					<?php
					$content  = apply_filters(
						'the_content',
						get_post_field('post_content', $job_id)
					);
					echo $content;
					?>
				</div>
			<?php else : ?>
				<div class="job-content-placeholder text-center text-gray-500">
					<?php pll_e('Select a job to view details'); ?>
				</div>
			<?php endif; ?>

		</div>
		<div id="job-content-footer" class="py-xxl-5 py-4 px-xxl-5 px-4">

			<?php if ($job_id) : ?>
				<div class="row vw-100 justify-content-end align-items-end">
					<?php if ($recruiter) : ?>
						<div class="col-xl-6 col-lg-4 col-md-6 d-flex align-items-center mb-md-0 mb-4">
							<?php if ($recruiterPhoto): ?>
								<div class="job-content-footer__recruiter-photo">
									<?php echo $recruiterPhoto; ?>
								</div>
							<?php endif; ?>
							<div class="job-content-footer__recruiter-info ms-4 d-flex flex-column justify-content-center">

								<?php if ($recruiterPhone) : ?>
									<a class="text-nowrap nowrap fw-semibold text-secondary py-1" href="tel:<?php echo $recruiterPhone; ?>">
										<i class="fa-regular fa-phone"></i>
										<span class="small ms-2 d-xl-inline-block d-lg-none"><?php echo $recruiterPhone; ?></span>
									</a>
								<?php endif; ?>

								<?php if ($recruiterWhatsapp): ?>
									<a class="text-nowrap nowrap fw-semibold text-success py-lg-1" href="<?php echo $recruiterWhatsapp; ?>">
										<i class="fa-lg fa-brands fa-whatsapp"></i>
										<span class="small ms-2 d-xl-inline-block d-lg-none"><?php pll_e('Ask a question via WhatsApp'); ?></span>
									</a>
								<?php endif; ?>

								<?php if ($recruiterCal) : ?>
									<a class="text-nowrap nowrap fw-semibold py-1" href="<?php echo $recruiterCal; ?>">
										<i class="fa-regular fa-video"></i>
										<span class="small ms-2 d-xl-inline-block d-lg-none"><?php pll_e('Plan a call with'); ?> <?php echo $recruiterName; ?></span>
									</a>
								<?php endif; ?>

							</div>
						</div>
					<?php endif; ?>
					<div class="col-xl-6 col-lg-8 col-md-6 d-flex flex-column justify-content-between">
						<span class="fs-6 text-md-end d-block fw-semibold">
							<?php pll_e('Want to see how you match up?<br/>Upload your resume today.'); ?>
						</span>
						<a href="#" data-bs-toggle="modal" data-bs-target="#jobAppModal" data-jobtitle="<?php echo get_the_title($job_id); ?>" data-jobid="<?php echo $loxo_job_id; ?>" class="btn btn-tertiary btn-sm ms-md-auto me-md-0 mt-md-4 mt-3 ms-0 me-auto">
							<i class="fa-regular fa-folder-arrow-up ms-0 me-2"></i>
							<?php pll_e('Apply for this job'); ?>
						</a>
					</div>
				</div>
			<?php endif; ?>

		</div>
	</div>
</article>