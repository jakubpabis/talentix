<?php

/**
 * Template Name: Jobs Page
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$search = '';

get_header('jobs');

if (isset($_GET['s_query']) && $_GET['s_query'] !== '') {
	$search = $_GET['s_query'];
}

?>

<main>

	<section class="jobs-header bg-light py-8 pt-12 <?php echo $search ? '' : 'd-none'; ?>">
		<div class="container-md conainer-fluid">
			<div class="row">
				<div class="col-12">
					<h1 class="h3 mb-0 mt-2">
						<?php pll_e('Search results for'); ?>:
						<span class="text-success jobs-header-search-query"><?php echo $search ?? ''; ?></span>
					</h1>
				</div>
			</div>
		</div>
	</section>

	<div class="container-md container-fluid mx-auto px-4">
		<div class="jobs-container row align-items-start">
			<div class="col-12 py-10">
				<?php
				// Include filters template
				get_template_part('template-parts/jobs/filters');
				?>
			</div>
			<!-- Left column: Jobs list -->
			<div class="jobs-list col-xl-4 col-lg-5">
				<?php
				// Include jobs list template
				get_template_part('template-parts/jobs/job-list');
				?>
			</div>

			<!-- Right column: Job content -->
			<?php get_template_part('template-parts/jobs/job-content'); ?>
		</div>
	</div>
</main>

<?php if (isset($_SESSION['job_id'])): ?>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const url = new URL(window.location.href);
			const params = new URLSearchParams(url.search);
			if (!params.has('job_id')) {
				const job_id = <?php echo $_SESSION['job_id'] ?>;
				console.log(job_id);
				window.history.pushState({}, '', `?job_id=${job_id}`);
				//window.location.href = `?job_id=${job_id}`;
			}
		});
	</script>

<?php unset($_SESSION['job_id']);
endif; ?>

<?php get_footer('jobs'); ?>