<?php

// add_action('init', function () {
// 	if (!session_id()) {
// 		session_start();
// 	}
// });

// Register AJAX actions
add_action('wp_ajax_load_more_jobs', 'load_more_jobs');
add_action('wp_ajax_nopriv_load_more_jobs', 'load_more_jobs');
add_action('wp_ajax_load_job_content', 'load_job_content');
add_action('wp_ajax_nopriv_load_job_content', 'load_job_content');

// Enqueue necessary scripts
function enqueue_jobs_scripts()
{
	if (is_page_template('templates/template-jobs.php') || is_singular('jobs')) {
		wp_enqueue_script('jobs-scripts', get_template_directory_uri() . '/assets/js/jobs.js', array('jquery'), '1.1', true);
		wp_localize_script('jobs-scripts', 'jobsAjax', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('jobs-nonce')
		));
	}
}
add_action('wp_enqueue_scripts', 'enqueue_jobs_scripts');

// AJAX handler for loading more jobs
function load_more_jobs()
{
	// Verify nonce
	if (!check_ajax_referer('jobs-nonce', 'nonce', false)) {
		wp_send_json_error(array(
			'message' => 'Invalid security token'
		));
	}

	// Get and sanitize parameters
	$page = isset($_POST['page']) ? absint($_POST['page']) : 1;
	$search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
	$filters = isset($_POST['filters']) ? (array)$_POST['filters'] : array();
	$order = isset($_POST['order']) ? (array)$_POST['order'] : array();

	// Build query arguments
	$args = array(
		'post_type' => 'jobs',
		'posts_per_page' => 10,
		'paged' => $page,
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC'
	);

	// Add search if provided
	if (!empty($search)) {
		$args['s'] = $search;
	}

	if (!empty($order)) {
		$args['orderby'] = array_key_first($order);
		$args['order'] = $order[array_key_first($order)];
		if (array_key_first($order) === 'salary') {
			$args['meta_key'] = 'salary_min';
			$args['orderby'] = 'meta_value_num';
			$args['order'] = $order[array_key_first($order)];
		}
	}

	// Add taxonomy filters if provided
	if (!empty($filters)) {
		$tax_query = array('relation' => 'AND');
		$meta_query = array('relation' => 'AND');

		foreach ($filters as $taxonomy => $value) {
			if (!empty($value)) {
				$taxonomy = sanitize_key($taxonomy);
				$value = sanitize_text_field($value);

				if ($taxonomy === 'job-location') {
					// Use meta_query for LIKE comparison
					$meta_query[] = array(
						'key' => 'location', // Your ACF field name
						'value' => $value,
						'compare' => 'LIKE'
					);
				} else {
					$tax_query[] = array(
						'taxonomy' => $taxonomy,
						'field' => 'slug',
						'terms' => $value,
					);
				}
			}
		}

		if (count($tax_query) > 1) {
			$args['tax_query'] = $tax_query;
		}
		if (count($meta_query) > 1) {
			$args['meta_query'] = $meta_query;
		}
	}


	// Debug log
	// error_log('Jobs Query Args: ' . print_r($args, true));

	// Perform query
	$jobs = new WP_Query($args);
	$response = array();

	if ($jobs->have_posts()) {
		while ($jobs->have_posts()) {
			$jobs->the_post();
			$job_data = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'meta' => array(),
				'date' => '30d+',
				'salaryMin' => 0,
				'salaryMax' => 0,
				'permalink' => get_the_permalink(get_the_ID())
			);

			if (!empty(get_field('salary_min')) && get_field('salary_min') > 0) {
				$job_data['salaryMin'] = get_field('salary_min');
			}
			if (!empty(get_field('salary_max')) && get_field('salary_max') > 0) {
				$job_data['salaryMax'] = get_field('salary_max');
			}
			$job_data['date'] = get_time_since_published();
			// Get taxonomy terms
			$taxonomies = array('job-location', 'job-type', 'job-industry');
			foreach ($taxonomies as $taxonomy) {
				$terms = get_the_terms(get_the_ID(), $taxonomy);
				if ($terms && !is_wp_error($terms)) {
					$job_data['meta'][$taxonomy] = $terms[0]->name;
				}
			}
			$response[] = $job_data;
		}
		array_unshift($response, ["count" => $jobs->found_posts]);
		wp_reset_postdata();
		wp_send_json_success($response);
	} else {
		wp_send_json_success(array(array("count" => 0))); // Empty array for no results
	}
}

// AJAX handler for loading job content
function load_job_content()
{
	check_ajax_referer('jobs-nonce', 'nonce');

	$job_id = $_POST['job_id'];
	$job = get_post($job_id);

	if ($job) {
		$response = array(
			'title' => get_the_title($job_id),
			'content' => apply_filters('the_content', $job->post_content),
			'meta' => array(),
			'date' => get_time_since_published(true, $job_id),
			'salaryMin' => get_field('salary_min', $job_id),
			'salaryMax' => get_field('salary_max', $job_id),
			'recruiter' => [],
			'jobID' => get_field('job_id', $job_id)
		);

		if (!empty(get_field('recruiter_related', $job_id))) {
			$rec = get_field('recruiter_related', $job_id)[0];
			// var_dump($rec);
			$recruiter = [
				'photo' => get_the_post_thumbnail($rec->ID, 'medium'),
				'name' => $rec->post_title,
				'phone' => get_field('phone', $rec->ID),
				'calendly' => get_field('calendly', $rec->ID),
				'whatsapp' => get_field('whatsapp', $rec->ID),
			];
			$response['recruiter'] = $recruiter;
		}

		// Get taxonomy terms
		$taxonomies = array('job-location', 'job-type', 'job-industry');
		foreach ($taxonomies as $taxonomy) {
			$terms = get_the_terms($job_id, $taxonomy);
			if ($terms && !is_wp_error($terms)) {
				$response['meta'][$taxonomy] = $terms[0]->name;
			}
		}

		wp_send_json_success($response);
	} else {
		wp_send_json_error('Job not found');
	}
}

// Redirect taxonomy archives to main jobs archive with filter
function redirect_job_taxonomy_archives()
{
	$job_taxonomies = array('job-type', 'job-location', 'job-salary', 'job-industry');
	$current_taxonomy = get_query_var('taxonomy');

	if (in_array($current_taxonomy, $job_taxonomies)) {
		$term = get_term_by('slug', get_query_var('term'), $current_taxonomy);

		if ($term) {
			$jobs_archive_url = get_post_type_archive_link('jobs');
			$redirect_url = add_query_arg(array(
				'filter_' . $current_taxonomy => $term->slug
			), $jobs_archive_url);

			wp_redirect($redirect_url, 301);
			exit;
		}
	}
}
add_action('template_redirect', 'redirect_job_taxonomy_archives');

// function redirect_from_single_job()
// {
// 	if (is_singular('jobs')) {
// 		$current_lang = 'en';
// 		// Wykryj język za pomocą Polylang
// 		if (function_exists('pll_current_language')) {
// 			$current_lang = pll_current_language();
// 		}

// 		// Ustal adres przekierowania na podstawie języka
// 		$redirect_url = home_url('/en/jobs?job_id=' . get_the_ID());
// 		if ($current_lang === 'nl') {
// 			$redirect_url = home_url('/nl/vacatures?job_id=' . get_the_ID());
// 		}

// 		$_SESSION['job_id'] = get_the_ID();

// 		error_log($redirect_url);

// 		wp_redirect($redirect_url, 301);
// 		exit;
// 	}
// }

// add_action('template_redirect', 'redirect_from_single_job');


add_action('gform_after_submission_7', 'wyslij_do_loxo_po_gravity', 10, 2);
add_action('gform_after_submission_8', 'wyslij_do_loxo_po_gravity', 10, 2);
function wyslij_do_loxo_po_gravity($entry, $form)
{
	// Zamień na prawdziwe ID pola Gravity Forms:
	$name_field_id        = '1.3'; // Imię i nazwisko
	// $description_field_id = '6'; // Opis
	$resume_field_id      = '8'; // Plik (CV)
	// $city_field_id        = '5.3';
	// $country_field_id     = '5.6';
	$email_field_id       = '3';
	$phone_field_id       = '4';
	$token_field_id 	  = '7';

	// Pobierz wartości z wpisu Gravity Forms
	$name        = rgar($entry, $name_field_id);
	// $description = rgar($entry, $description_field_id);
	$resume_url  = rgar($entry, $resume_field_id);
	// $city        = rgar($entry, $city_field_id);
	// $country     = rgar($entry, $country_field_id);
	$email       = rgar($entry, $email_field_id);
	$phone       = rgar($entry, $phone_field_id);
	$token 		 = rgar($entry, $token_field_id);

	// Pobierz ścieżkę fizyczną pliku
	if ($resume_url) {
		$resume_path = GFFormsModel::get_physical_file_path($resume_url);
		$resume_filename = basename($resume_path);
	} else {
		$resume_path = null;
		$resume_filename = '';
	}

	// Przygotuj multipart/form-data
	$multipart = [
		[
			'name'     => 'name',
			'contents' => $name
		],
		[
			'name'     => 'email',
			'contents' => $email
		],
		[
			'name'     => 'phone',
			'contents' => $phone
		]
	];
	// error_log('form1: ' . json_encode($multipart));

	// Dodaj plik, jeśli istnieje
	if ($resume_path && file_exists($resume_path)) {
		// $fp = fopen($resume_path, 'r');
		$multipart[] = [
			'name'     => 'resume',
			'filename' => $resume_filename,
			'contents' => file_get_contents($resume_path),
			'headers'  => [
				'Content-Type' => mime_content_type($resume_path)
			]
		];
	} else {
		error_log('no CV RESUME FILE...');
	}

	$client = new \GuzzleHttp\Client();

	try {
		error_log('form3: ' . json_encode($multipart));
		$response = $client->request('POST', 'https://app.loxo.co/api/search-x-recruitment/jobs/3149679/apply', [
			'multipart' => $multipart,
			'headers' => [
				'accept'        => 'application/json',
				'authorization' => 'Bearer ' . $token,
			],
		]);

		// Opcjonalnie: logowanie odpowiedzi
		// var_dump($response);
		error_log(json_encode($response->getBody()));
	} catch (Exception $e) {
		// Obsługa błędów
		error_log('Błąd wysyłki do LOXO: ' . $e->getMessage());
	}
	// fclose($fp);
}


add_action('gform_after_submission_9', 'application_loxo_gravity', 10, 2);
add_action('gform_after_submission_10', 'application_loxo_gravity', 10, 2);
function application_loxo_gravity($entry, $form)
{
	// Zamień na prawdziwe ID pola Gravity Forms:
	$name_field_id        = '1.3'; // Imię i nazwisko
	$resume_field_id      = '8'; // Plik (CV)
	$email_field_id       = '3';
	$phone_field_id       = '4';
	$token_field_id 	  = '7';
	$job_id_field_id	  = '10';

	// Pobierz wartości z wpisu Gravity Forms
	$name        = rgar($entry, $name_field_id);
	$resume_url  = rgar($entry, $resume_field_id);
	$email       = rgar($entry, $email_field_id);
	$phone       = rgar($entry, $phone_field_id);
	$token 		 = rgar($entry, $token_field_id);
	$job_id		 = rgar($entry, $job_id_field_id);

	if (!$job_id) {
		error_log('No JOB ID FROM FORM FOUND: ' . $job_id);
	}

	// Pobierz ścieżkę fizyczną pliku
	if ($resume_url) {
		$resume_path = GFFormsModel::get_physical_file_path($resume_url);
		$resume_filename = basename($resume_path);
	} else {
		$resume_path = null;
		$resume_filename = '';
	}

	// Przygotuj multipart/form-data
	$multipart = [
		[
			'name'     => 'name',
			'contents' => $name
		],
		[
			'name'     => 'email',
			'contents' => $email
		],
		[
			'name'     => 'phone',
			'contents' => $phone
		]
	];

	// Dodaj plik, jeśli istnieje
	if ($resume_path && file_exists($resume_path)) {
		$multipart[] = [
			'name'     => 'resume',
			'filename' => $resume_filename,
			'contents' => file_get_contents($resume_path),
			'headers'  => [
				'Content-Type' => mime_content_type($resume_path)
			]
		];
	} else {
		error_log('no CV RESUME FILE...');
	}

	$client = new \GuzzleHttp\Client();

	try {
		error_log('form3: ' . json_encode($multipart));
		$response = $client->request('POST', 'https://app.loxo.co/api/search-x-recruitment/jobs/' . $job_id . '/apply', [
			'multipart' => $multipart,
			'headers' => [
				'accept'        => 'application/json',
				'authorization' => 'Bearer ' . $token,
			],
		]);

		error_log('form data: ' . json_encode($response->getBody()));
	} catch (Exception $e) {
		// Obsługa błędów
		error_log('Błąd wysyłki do LOXO: ' . $e->getMessage());
	}
}

function moveApplicantsToLOXO()
{
	$form_id = 10;

	$paging = array(
		'offset' => 0,
		'page_size' => 999999
	);

	$entries = GFAPI::get_entries($form_id, array(), null, $paging);

	foreach ($entries as $entry) {

		$name_field_id        = '1.3';
		$resume_field_id      = '8';
		$email_field_id       = '3';
		$phone_field_id       = '4';
		$token_field_id 	  = '7';
		$job_id_field_id	  = '10';

		$name        = rgar($entry, $name_field_id);
		$resume_url  = rgar($entry, $resume_field_id);
		$email       = rgar($entry, $email_field_id);
		$phone       = rgar($entry, $phone_field_id);
		$token 		 = rgar($entry, $token_field_id);
		$job_id		 = rgar($entry, $job_id_field_id);

		if ($job_id && intval($job_id) < 100000) {

			$job_id_loxo = get_field('job_id', $job_id);

			if ($job_id_loxo && $job_id_loxo !== '') {
				// if ($resume_url) {
				// 	$resume_path = GFFormsModel::get_physical_file_path($resume_url);
				// 	$resume_filename = basename($resume_path);
				// } else {
				// 	$resume_path = null;
				// 	$resume_filename = '';
				// }

				// $multipart = [
				// 	[
				// 		'name'     => 'name',
				// 		'contents' => $name
				// 	],
				// 	[
				// 		'name'     => 'email',
				// 		'contents' => $email
				// 	],
				// 	[
				// 		'name'     => 'phone',
				// 		'contents' => $phone
				// 	]
				// ];

				// if ($resume_path && file_exists($resume_path)) {
				// 	$multipart[] = [
				// 		'name'     => 'resume',
				// 		'filename' => $resume_filename,
				// 		'contents' => file_get_contents($resume_path),
				// 		'headers'  => [
				// 			'Content-Type' => mime_content_type($resume_path)
				// 		]
				// 	];
				// } else {
				// 	error_log('GFORM LOXO: no CV RESUME FILE...');
				// }

				// $client = new \GuzzleHttp\Client();

				// try {
				// 	error_log('form3 GFORM LOXO: ' . json_encode($multipart));
				// 	$response = $client->request('POST', 'https://app.loxo.co/api/search-x-recruitment/jobs/' . $job_id_loxo . '/apply', [
				// 		'multipart' => $multipart,
				// 		'headers' => [
				// 			'accept'        => 'application/json',
				// 			'authorization' => 'Bearer ' . $token,
				// 		],
				// 	]);

				// 	error_log('form data GFORM LOXO: ' . json_encode($response->getBody()));
				// } catch (Exception $e) {
				// 	error_log('Błąd wysyłki do LOXO, GFORM LOXO: ' . $e->getMessage());
				// }
			} else {
				error_log('no job ID found for post: ' . $job_id);
			}
		}
	}
}
