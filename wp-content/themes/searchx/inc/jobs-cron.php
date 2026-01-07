<?php

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

require_once(dirname(__DIR__) . '/vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;


// /**
//  * Register REST API routes for job webhooks
//  */
// add_action('rest_api_init', function () {
// 	// Create job endpoint
// 	register_rest_route('webhook/v1', '/job/create', array(
// 		'methods' => 'POST',
// 		'callback' => 'handle_create_job_webhook',
// 		'permission_callback' => '__return_true',
// 	));

// 	// Update job endpoint
// 	register_rest_route('webhook/v1', '/job/update', array(
// 		'methods' => 'POST',
// 		'callback' => 'handle_update_job_webhook',
// 		'permission_callback' => '__return_true',
// 	));
// });

// /**
//  * Verify webhook signature
//  */
// function verify_job_webhook_signature($data)
// {
// 	if (!isset($data['id']) || !isset($data['signature'])) {
// 		return false;
// 	}

// 	// Get bearer token from wp-config.php
// 	$bearer_token = defined('WEBHOOK_BEARER_TOKEN')
// 		? WEBHOOK_BEARER_TOKEN
// 		: 'f578531d8a7fb1168dbd71c848b053f6039e33a49ff06a64fc1af2589e47ec5a1fecc7257f00b60c5a5cc0564b8364fd1c4f6bc133b31de229f06b357cff39d4755f46118af65f40ac88658d464be0d9a0dc0cc3f2ce563d2d95a920e402f4e93faedc21a3d0f8e64343d9982fcf6d28ecef28e674e412889e0ad20d7aef6c32';

// 	$id = intval($data['id']);
// 	$received_signature = $data['signature'];

// 	// Compute signature: {id}{bearer_token}{id}
// 	$string_to_hash = $id . $bearer_token . $id;
// 	$computed_signature = hash('sha512', $string_to_hash);

// 	// Compare signatures securely
// 	return hash_equals($computed_signature, $received_signature);
// }

// /**
//  * Validate required fields
//  */
// function validate_job_webhook_data($data)
// {
// 	$required_fields = array(
// 		'id',
// 		'signature',
// 		'item_id',
// 		'item_type',
// 		'timestamp'
// 	);

// 	foreach ($required_fields as $field) {
// 		if (!isset($data[$field])) {
// 			return new WP_Error(
// 				'missing_field',
// 				sprintf('Missing required field: %s', $field),
// 				array('status' => 400)
// 			);
// 		}
// 	}

// 	return true;
// }

function getRecruiters()
{
	$recruiters = [];
	$query = new WP_Query([
		'post_type' => 'team',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'fields' => 'ids', // Tylko ID - szybsze
	]);

	foreach ($query->posts as $id) {
		$recruiters[$id] = [
			'slug' => get_post_field('post_name', $id),
			'name' => get_the_title($id),
		];
	}
	wp_reset_postdata();
	return $recruiters;
}

function getCurrentJobs()
{
	$postsArr = [
		'ids' => [],
		'job_ids' => []
	];
	global $wpdb;
	$existing_jobs = $wpdb->get_results("
        SELECT p.ID, pm.meta_value as job_id
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        WHERE p.post_type = 'jobs'
        AND p.post_status = 'publish'
        AND pm.meta_key = 'job_id'
    ", OBJECT_K);
	foreach ($existing_jobs as $post) {
		$postsArr['ids'][] = $post->ID;
		$postsArr['job_ids'][$post->job_id] = $post->ID;
	}
	return $postsArr;
}

function getAllTerms()
{
	$termCache = [
		'job-category' => [],
		'job-type' => [],
		'job-location' => []
	];

	foreach (['job-category', 'job-type', 'job-location'] as $taxonomy) {
		$terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);
		foreach ($terms as $term) {
			$termCache[$taxonomy][$term->name] = $term->term_id;
		}
	}
	return $termCache;
}

function createJob(array $job = [], array $termCache = [])
{
	$postID = wp_insert_post($job['standard'], true);

	if (!is_wp_error($postID)) {
		update_post_meta($postID, 'job_id', $job['job_id']);
		update_post_meta($postID, 'salary_min', (int)$job['salary_min']);
		update_post_meta($postID, 'salary_max', (int)$job['salary_max']);
		update_post_meta($postID, 'location', $job['location']);
		// update_post_meta($postID, 'recruiter_related', $job['recruiter']);
		update_field('recruiter_related', [(int)$job['recruiter']], $postID);
		update_post_meta($postID, 'meta_title', $job['meta_title']);
		add_post_meta($postID, '_yoast_wpseo_title', $job['meta_title']);
		update_post_meta($postID, 'meta_description', $job['meta_description']);
		add_post_meta($postID, '_yoast_wpseo_metadesc', $job['meta_description']);

		insertCategoriesFast($job['categories'], $postID, 'job-category', $termCache);
		insertCategoriesFast($job['type'], $postID, 'job-type', $termCache);
		insertLocationFast($job['location'], $postID, $termCache);
		return $postID;
	}
	// Handle error
	return false;
}

function updateJob(array $job = [], array $termCache = [], array $postsArr = [], string $jobId = '')
{
	error_log(json_encode($job));
	$postID = $postID = $postsArr['job_ids'][$jobId];
	$job['standard']['ID'] = $postID;
	wp_update_post($job['standard'], true);

	// Bezpośrednie update_post_meta zamiast update_field - SZYBSZE
	update_post_meta($postID, 'salary_min', (int)$job['salary_min']);
	update_post_meta($postID, 'salary_max', (int)$job['salary_max']);
	update_post_meta($postID, 'location', $job['location']);
	update_field('recruiter_related', [(int)$job['recruiter']], $postID);
	update_post_meta($postID, 'meta_title', $job['meta_title']);
	update_post_meta($postID, '_yoast_wpseo_title', $job['meta_title']);
	update_post_meta($postID, 'meta_description', $job['meta_description']);
	update_post_meta($postID, '_yoast_wpseo_metadesc', $job['meta_description']);

	insertCategoriesFast($job['categories'], $postID, 'job-category', $termCache);
	insertCategoriesFast($job['type'], $postID, 'job-type', $termCache);
	insertLocationFast($job['location'], $postID, $termCache);
}

function prepareJobData(object $job, object $singleJobData, array $countries, array $recruiters, array $disregardCats)
{
	$newJob = [
		'job_id' => strval($job->id),
		'salary_min' => $job->salary_min ?? 0,
		'salary_max' => $job->salary_max ?? 0,
		'location' => '',
		'meta_title' => $job->custom_text_1 ?? '',
		'meta_description' => $job->custom_text_2 ?? '',
		'recruiter' => '',
		'categories' => [],
		'type' => [],
		'standard' => [
			'post_type' => 'jobs',
			'post_status' => 'publish',
			'post_title' => strval($job->title),
			'post_name' => slugify($job->title . '-' . $job->id),
			'post_date' => date("Y-m-d H:i:s", strtotime($job->updated_at)),
			'post_excerpt' => $singleJobData->description_text ? make_excerpt($singleJobData->description_text, 30) : '',
			'post_content' => $singleJobData->description ? remove_inline_styles($singleJobData->description) : '',
		]
	];

	if ($job->city && $job->country_code) {
		$country = $countries[$job->country_code] ?? 'Netherlands';
		$newJob['location'] = $job->city . ', ' . $country;
	}

	if (!empty($job->owners)) {
		echo "Owners: ";
		echo $job->owners[0]->name . '<br/><br/>';

		$recruiter = $job->owners[0]->name;
		$recruiterID = findRecruiter($recruiters, $recruiter);
		if ($recruiterID) {
			echo 'recruiter ID: ' . $recruiterID . '<br/><br/>';
			$newJob['recruiter'] = $recruiterID;
		}
	}

	if (!empty($job->categories)) {
		foreach ($job->categories as $cat) {
			if (!in_array($cat->name, $disregardCats)) {
				$newJob['categories'][] = $cat->name;
			}
		}
	}

	if (!empty($job->job_type) && $job->job_type->name) {
		$newJob['type'][] = $job->job_type->name;
	}
	return $newJob;
}

function insertCategoriesFast($categories, $postID, $taxonomy, &$termCache)
{
	if (empty($categories)) return;

	$termIDs = [];
	foreach ($categories as $category) {
		if (!isset($termCache[$taxonomy][$category])) {
			$term = wp_insert_term($category, $taxonomy);
			if (!is_wp_error($term)) {
				$termCache[$taxonomy][$category] = $term['term_id'];
			}
		}
		if (isset($termCache[$taxonomy][$category])) {
			$termIDs[] = $termCache[$taxonomy][$category];
		}
	}

	if (!empty($termIDs)) {
		wp_set_post_terms($postID, $termIDs, $taxonomy, true);
	}
}

function insertLocationFast($location, $postID, &$termCache)
{

	if (!$location) return;

	$taxonomy = 'job-location';
	if (!isset($termCache[$taxonomy][$location])) {
		$term = wp_insert_term($location, $taxonomy);
		if (!is_wp_error($term)) {
			$termCache[$taxonomy][$location] = $term['term_id'];
		}
	}

	if (isset($termCache[$taxonomy][$location])) {
		error_log("Inserting location: " . $location);
		wp_set_post_terms($postID, $termCache[$taxonomy][$location], $taxonomy, true);
	}
}

// function batchUpdateJobLinks($client, $token, $allJobs)
// {
// 	$updateGenerator = function ($jobs, $client, $token) {
// 		foreach ($jobs as $job) {
// 			$jobUrl = get_permalink($job['post_id'] ?? 0);
// 			if (!$jobUrl) continue;

// 			error_log("Job link updated successfully for: {$jobUrl}");

// 			yield $job['job_id'] => function () use ($client, $token, $job, $jobUrl) {
// 				return $client->putAsync('https://app.loxo.co/api/search-x-recruitment/jobs/' . $job['job_id'], [
// 					'headers' => [
// 						'Accept' => 'application/json',
// 						'Authorization' => 'Bearer ' . $token,
// 					],
// 					'multipart' => [
// 						[
// 							'name' => 'job[custom_text_3]',
// 							'contents' => $jobUrl
// 						],
// 					],
// 				]);
// 			};
// 		}
// 	};

// 	$pool = new Pool($client, $updateGenerator($allJobs, $client, $token), [
// 		'concurrency' => 10,
// 		'fulfilled' => function ($reason, $jobId) {
// 			error_log("Job link updated successfully for: {$jobId}");
// 		},
// 		'rejected' => function ($reason, $jobId) {
// 			error_log("Failed to update job link for {$jobId}: " . $reason->getMessage());
// 		},
// 	]);

// 	$pool->promise()->wait();
// }

function updateJobLink(string $token = '', array $job = [])
{
	$client = new Client();
	$jobUrl = get_permalink($job['post_id'] ?? 0);
	if (!$jobUrl) return;
	$client->put('https://app.loxo.co/api/search-x-recruitment/jobs/' . $job['job_id'], [
		'headers' => [
			'Accept' => 'application/json',
			'Authorization' => 'Bearer ' . $token,
		],
		'multipart' => [
			[
				'name' => 'job[custom_text_3]',
				'contents' => $jobUrl
			],
		],
		'delay' => 250
	]);
}

function slugify($text)
{
	// replace non letter or digits by -
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);
	// transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);
	// trim
	$text = trim($text, '-');
	// remove duplicate -
	$text = preg_replace('~-+~', '-', $text);
	// lowercase
	$text = strtolower($text);
	if (empty($text)) {
		return 'n-a';
	}
	return $text;
}

function make_excerpt($text, $word_limit = 30, $ending = '...')
{
	// Usuwa tagi HTML
	$text = strip_tags($text);

	// Dzieli tekst na słowa
	$words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

	// Jeśli tekst jest krótszy niż limit, zwraca całość
	if (count($words) <= $word_limit) {
		return implode(' ', $words);
	}

	// Wycina pierwsze $word_limit słów i dodaje zakończenie
	$excerpt = array_slice($words, 0, $word_limit);
	return implode(' ', $excerpt) . $ending;
}

function remove_inline_styles(string $html)
{
	// Załaduj HTML do DOMDocument
	$doc = new DOMDocument();
	// Ukryj błędy związane z HTML5
	libxml_use_internal_errors(true);
	$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);

	// Pobierz wszystkie elementy z atrybutem style
	$xpath = new DOMXPath($doc);
	foreach ($xpath->query('//*[@style]') as $el) {
		$el->removeAttribute('style');
	}

	// Pobierz tylko zawartość body (bez <html>, <body>)
	$body = $doc->getElementsByTagName('body')->item(0);
	$innerHTML = '';
	foreach ($body->childNodes as $child) {
		$innerHTML .= $doc->saveHTML($child);
	}

	libxml_clear_errors();
	return $innerHTML;
}

function findRecruiter(array $array, string $name)
{
	foreach ($array as $key => $item) {
		if (isset($item['name']) && $item['name'] === $name) {
			return $key; // Zwraca klucz, jeśli znaleziono
		}
	}
	return false; // Zwraca false, jeśli nie znaleziono
}

function getJobsToFetch(string $token = '')
{
	$client = new Client();
	// Pobierz wszystkie strony API
	$response = $client->request('GET', 'https://app.loxo.co/api/search-x-recruitment/jobs?status=active', [
		'headers' => [
			'accept' => 'application/json',
			'authorization' => 'Bearer ' . $token,
		],
	]);

	$body = $response->getBody()->getContents();
	$data = json_decode($body);
	$pages = $data->total_pages;
	$results = $data->results;

	// Równoległe pobieranie pozostałych stron
	if ($pages > 1) {
		$pagePromises = [];
		for ($i = 2; $i <= $pages; $i++) {
			$pagePromises[] = $client->getAsync('https://app.loxo.co/api/search-x-recruitment/jobs?status=active&page=' . $i, [
				'headers' => [
					'accept' => 'application/json',
					'authorization' => 'Bearer ' . $token,
				],
				'delay' => 250
			]);
		}

		$pageResponses = \GuzzleHttp\Promise\Utils::settle($pagePromises)->wait();
		foreach ($pageResponses as $result) {
			if ($result['state'] === 'fulfilled') {
				$pageData = json_decode($result['value']->getBody()->getContents());
				$results = array_merge($results, $pageData->results);
			}
		}
	}

	// Filtruj job'y
	$jobsToFetch = [];
	foreach ($results as $job) {
		$getJob = true;
		if (!empty($job->custom_hierarchy_6) && $job->custom_hierarchy_6[0] && $job->custom_hierarchy_6[0]->value === "Yes") {
			$getJob = false;
		}
		if ($getJob) {
			$jobsToFetch[$job->id] = $job;
		}
	}
	return $jobsToFetch;
}

function getJobDetails(string $token, array $jobsToFetch = [])
{
	$client = new Client();
	// KLUCZOWA OPTYMALIZACJA: Równoległe pobieranie szczegółów wszystkich job'ów
	$jobDetailsGenerator = function ($jobs, $client, $token) {
		foreach ($jobs as $jobId => $job) {
			yield $jobId => function () use ($client, $jobId, $token) {
				return $client->getAsync('https://app.loxo.co/api/search-x-recruitment/jobs/' . $jobId, [
					'headers' => [
						'accept' => 'application/json',
						'authorization' => 'Bearer ' . $token,
					],
					'delay' => 500
				]);
			};
		}
	};

	$jobDetails = [];
	$pool = new Pool($client, $jobDetailsGenerator($jobsToFetch, $client, $token), [
		'concurrency' => 2, // 10 równoległych requestów
		'fulfilled' => function (Response $response, $jobId) use (&$jobDetails) {
			$jobDetails[$jobId] = json_decode($response->getBody()->getContents());
		},
		'rejected' => function (RequestException $reason, $jobId) {
			error_log("Failed to fetch job {$jobId}: " . $reason->getMessage());
		},
	]);

	$pool->promise()->wait();
	return $jobDetails;
}

function getSingleJob(string $jobId = '')
{
	$token = defined('WEBHOOK_BEARER_TOKEN')
		? WEBHOOK_BEARER_TOKEN
		: 'f578531d8a7fb1168dbd71c848b053f6039e33a49ff06a64fc1af2589e47ec5a1fecc7257f00b60c5a5cc0564b8364fd1c4f6bc133b31de229f06b357cff39d4755f46118af65f40ac88658d464be0d9a0dc0cc3f2ce563d2d95a920e402f4e93faedc21a3d0f8e64343d9982fcf6d28ecef28e674e412889e0ad20d7aef6c32';
	$client = new Client();
	$respone = $client->get('https://app.loxo.co/api/search-x-recruitment/jobs/' . $jobId, [
		'headers' => [
			'accept' => 'application/json',
			'authorization' => 'Bearer ' . $token,
		],
		'delay' => 250
	]);
	$body = $respone->getBody()->getContents();
	$job = json_decode($body);
	return $job;
}

function xmlRead()
{
	$countries = [
		'AF' => 'Afghanistan',
		'AX' => 'Aland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua And Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BA' => 'Bosnia And Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, Democratic Republic',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Cote D\'Ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island & Mcdonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran, Islamic Republic Of',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle Of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KR' => 'Korea',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libyan Arab Jamahiriya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia, Federated States Of',
		'MD' => 'Moldova',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'AN' => 'Netherlands Antilles',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory, Occupied',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Reunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthelemy',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts And Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin',
		'PM' => 'Saint Pierre And Miquelon',
		'VC' => 'Saint Vincent And Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome And Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia And Sandwich Isl.',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard And Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad And Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks And Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis And Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
	]; // Twoja tablica krajów
	$disregardCats = [
		'A-job',
		'B-job',
		'C-job',
		'Team Jeroen',
		'Team Ernst',
		'Team Maarten',
		'Team Herre',
		'Team Jan',
		'Open Intro',
		'Open intro',
		'Team Corporate Recruitment',
		'Search X Website internal jobs',
		'search-x-website-internal-jobs',
		'team-jeroen'
	]; // Twoja tablica
	$token = defined('WEBHOOK_BEARER_TOKEN')
		? WEBHOOK_BEARER_TOKEN
		: 'f578531d8a7fb1168dbd71c848b053f6039e33a49ff06a64fc1af2589e47ec5a1fecc7257f00b60c5a5cc0564b8364fd1c4f6bc133b31de229f06b357cff39d4755f46118af65f40ac88658d464be0d9a0dc0cc3f2ce563d2d95a920e402f4e93faedc21a3d0f8e64343d9982fcf6d28ecef28e674e412889e0ad20d7aef6c32';

	// Cache recruiters
	$recruiters = getRecruiters();

	// Pobierz istniejące job_ids JEDNYM zapytaniem
	$postsArr = getCurrentJobs();

	// Cache dla term lookups
	$termCache = getAllTerms();

	$jobsToFetch = getJobsToFetch($token);

	$jobDetails = getJobDetails($token, $jobsToFetch);

	// Przetwórz job'y
	$allJobs = [];
	$job_ids = [];

	foreach ($jobsToFetch as $jobId => $job) {
		$singleJobData = $jobDetails[$jobId] ?? null;
		if (!$singleJobData) continue;

		$newJob = prepareJobData($job, $singleJobData, $countries, $recruiters, $disregardCats);
		$allJobs[] = $newJob;
		$job_ids[] = $newJob['job_id'];
	}

	$jobsProcessed = [];

	// Batch update/insert
	foreach ($allJobs as $job) {
		$jobId = $job['job_id'];

		if (isset($postsArr['job_ids'][$jobId])) {
			$postID = $postsArr['job_ids'][$jobId];
			$post = get_post($postID);

			array_push($jobsProcessed, ["post_id" => $postID, "job_id" => $jobId]);

			if ($post->post_date !== $job['standard']['post_date'] || (isset($_GET['force']) && $_GET['force'] === true)) {
				sleep(1);
				// Update
				unset($job['standard']['post_name']);
				updateJob($job, $termCache, $postsArr, $jobId);
				if (!isset($_GET['nolink']) || $_GET['nolink'] !== "true") {
					updateJobLink($token, ['post_id' => $postID, 'job_id' => $jobId]);
				}
			}

			unset($postsArr['job_ids'][$jobId]);
			unset($postsArr['ids'][array_search($postID, $postsArr['ids'])]);
		} else {
			sleep(1);
			// Insert
			$postID = createJob($job, $termCache);
			if ($postID && (!isset($_GET['nolink']) || $_GET['nolink'] !== "true")) {
				updateJobLink($token, ['post_id' => $postID, 'job_id' => $jobId]);
			}
		}
	}

	// if (!isset($_GET['nolink']) || $_GET['nolink'] !== "true") {
	// 	error_log($_GET['nolink']);
	// 	error_log('-------------Updating job links------------');
	// 	// Batch update job links - równolegle
	// 	$client = new Client();
	// 	batchUpdateJobLinks($client, $token, $jobsProcessed);
	// }

	// Usuń nieaktualne
	foreach ($postsArr['ids'] as $pid) {
		if (get_post_status($pid)) {
			wp_delete_post($pid, true);
		}
	}
}

/**
 * Handle create job webhook request
 */
function handle_create_job_webhook(WP_REST_Request $request)
{
	$data = $request->get_json_params();

	//Validate data
	$validation = validate_job_webhook_data($data);
	if (is_wp_error($validation)) {
		return $validation;
	}

	// Verify signature
	if (!verify_job_webhook_signature($data)) {
		return new WP_Error(
			'invalid_signature',
			'Invalid signature',
			array('status' => 401)
		);
	}

	// Check if job already exists
	$existing_jobs = get_posts(array(
		'post_type' => 'job',
		'meta_query' => array(
			array(
				'key' => 'job_id',
				'value' => $data['item_id'],
				'compare' => '='
			)
		),
		'posts_per_page' => 1
	));

	if (!empty($existing_jobs)) {
		return new WP_Error(
			'job_exists',
			'Job already exists with this item_id',
			array('status' => 409)
		);
	}

	// Create new job post
	$post_id = wp_insert_post(array(
		'post_type' => 'job',
		'post_status' => 'publish',
		'post_title' => sprintf('Job %s', $data['item_id']),
	));

	if (is_wp_error($post_id)) {
		return new WP_Error(
			'create_failed',
			'Failed to create job post',
			array('status' => 500)
		);
	}

	return new WP_REST_Response(array(
		'success' => true,
		'message' => 'Job created successfully',
		'post_id' => $post_id,
		'item_id' => $data['item_id']
	), 201);
}
