<?php

declare(strict_types=1);

/**
 * Generic Theme Functions.
 */

/**
 * Gets the value of a field if it is not empty. Returns the fallback if field is empty.
 *
 * @since 2.2.0
 *
 * @param string $option   Theme option name
 * @param mixed  $fallback Value to fallback to if the theme option is empty
 *
 * @return mixed The requested theme option.
 */
function get_has_theme_option(string $option, $fallback)
{
	$field = get_theme_option($option);
	return ! empty($field) ? $field : $fallback;
}

/**
 * Returns the theme option.
 *
 * @since 0.9.0
 *
 * @param string $option The requested theme option.
 * @param string $name (Optional) The theme options name. Default 'options'.
 *
 * @return mixed The theme option.
 */
function get_theme_option(string $option, $name = 'options')
{
	return get_field($option, $name);
}

/**
 * Prints the theme option if it's a string.
 *
 * @since 0.9.0
 *
 * @param string $option The requested theme option.
 * @param string $name (Optional) The theme options name. Default 'options'.
 */
function the_theme_option(string $option, $name = 'options')
{
	$option = get_theme_option($option, $name);
	if (is_string($option)) {
		echo $option;
	}
}

/**
 * Adds extra variable to a registered script.
 *
 * @since 0.9.0
 *
 * Variable will only be add if the script is already in the queue.
 * Accepts any $data that can be json encoded. Use this as a drop-in
 * replacement for `wp_localize_script()` which until WordPress 4.5
 * was the only way to pass variables from PHP to javascript.
 *
 * @param string $handle Script handle the textdomain will be attached to.
 * @param string $name   The variable name.
 * @param string $data   The variable data value.
 */
function add_inline_variable(string $handle, string $name, $data)
{
	$value = json_encode($data);
	wp_add_inline_script($handle, "var $name = $value;", 'before');
}

/* This function serves the purpose of including a php template and
 * be explicit about what vars it injects.
 * Typically, you would just set the variable above the include, but
 * doing it that way makes it hard to follow. In a sense, this also serves
 * another purpose of stopping the ugly html that some functions/methods generate.
 * @example include_with(__DIR__.'/incl-filename.php', array('foo' => $foo, 'bar' => $bar));
 */
function include_with($path, $array_vars, $once = false)
{
	extract($array_vars);
	if ($once) {
		include_once $path;
	} else {
		include $path;
	}
	foreach ($array_vars as $k => $v) {
		unset($$k);
	}
	return;
}

function cc_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function fix_svg()
{
	echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action('admin_head', 'fix_svg');

function compress_and_convert_images_to_webp($file)
{
	// Check if file type is supported
	$supported_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
	if (!in_array($file['type'], $supported_types)) {
		return $file;
	}

	// Get the path to the upload directory
	$wp_upload_dir = wp_upload_dir();

	// Set up the file paths
	$old_file_path = $file['file'];
	$old_file_size = filesize($old_file_path);
	$file_name = basename($file['file']);
	$webp_file_path = $wp_upload_dir['path'] . '/' . pathinfo($file_name, PATHINFO_FILENAME) . '.webp';

	// Check if file is already a WebP image
	if (pathinfo($old_file_path, PATHINFO_EXTENSION) === 'webp') {
		return $file;
	}

	// Load the image using Imagick
	$image = new Imagick($old_file_path);

	// Compress the image
	$quality = 80; // Adjust this value to control the compression level
	$image->setImageCompressionQuality($quality);
	$image->stripImage(); // Remove all profiles and comments to reduce file size

	// Convert the image to WebP
	$image->setImageFormat('webp');
	$image->setOption('webp:lossless', 'false');
	$image->setOption('webp:low-memory', 'false');
	$image->setOption('webp:thread-level', '1');
	$image->setOption('webp:method', '6'); // Adjust this value to control the compression level for WebP
	$image->writeImage($webp_file_path);

	$new_file_size = filesize($webp_file_path);

	if ($new_file_size >= $old_file_size) {
		unlink($webp_file_path);
		return [
			'file' => $old_file_path,
			'url' => $wp_upload_dir['url'] . '/' . basename($old_file_path),
			'type' => $file['type'],
		];
	} else {
		// Delete the old image file
		unlink($old_file_path);
		// Return the updated file information
		return [
			'file' => $webp_file_path,
			'url' => $wp_upload_dir['url'] . '/' . basename($webp_file_path),
			'type' => 'image/webp',
		];
	}
}
add_filter('wp_handle_upload', 'compress_and_convert_images_to_webp');

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function blennder_custom_excerpt_length($length)
{
	return 16;
}
add_filter('excerpt_length', 'blennder_custom_excerpt_length', 999);

$toTranslate = array(
	'Download',
	'Give us your email and download the file',
	'Put in your email address here',
	'From',
	'To',
	'Learn more',
	'Do you need my help?',
	'Contact',
	'Get in touch',
	'Share this content',
	'Vacature',
	'Filter jobs',
	'Categories',
	'Salary range',
	'Location',
	'Industry type',
	'Job type',
	'Hot skills',
	'Open in maps',
	'Filter',
	'fulfilled jobs',
	'fulfilled job',
	'This job has been fulfilled',
	'open jobs',
	'open job',
	'jobs found',
	'job found',
	'jobs showing',
	'job showing',
	'More info',
	'Read more',
	'Topics',
	'Contact us!',
	'Apply here',
	'Apply with:',
	'Male',
	'Female',
	'Name',
	'Email',
	'Phone',
	'Date of birth',
	'City',
	'CV',
	'Upload',
	'Upload CV',
	'Upload cv here',
	'Motivation',
	'Send application',
	'I hereby agree with the',
	'Privacy Policy',
	'Send message',
	'Back',
	'Executive search consultant',
	'Show all jobs',
	'Show all articles',
	'Page Not Found',
	'We are sorry, but we couldn’t find what you looking for...',
	'Search for a job!',
	'Show less',
	'Less meer',
	'No jobs found...',
	'Schedule a call or meeting',
	'Search our knowledge base. We have tons of useful articles for you!',
	'article found',
	'articles found',
	'Enter job title here',
	'Enter job location',
	'Filter by topic',
	'Contact',
	'Recent jobs',
	'Hot skills',
	'Subscribe to our newsletter',
	'Interested in instantly receiving the latest Search X Recruitment jobs within your area of expertise?',
	'Subscribe now',
	'Category',
	'Let me help you find the perfect job',
	"Let's find the perfect job for you",
	'Clear all',
	'Your file exceeds 5mb limit...',
	'Job application sucessful',
	'Sorry, there was a problem with your application, please try again later...',
	'Congratulations! Your CV was successfully submitted!',
	'Congratulations! Your application was successfully submitted!',
	'Search X Recruitment uses cookies to improve our website and your user experience. <br/>By clicking any link or continuing to browse you are giving your consent to our cookie policy.',
	'cookie policy',
	'Accept',
	'Fulfilled jobs',
	'Choose your country',
	'Sending, please wait...',
	'Subscribing, please wait...',
	'Congratulations! You subscribe to our newsletter!',
	'Sorry, there was a problem with your subscribtion, please try again later...',
	'Thank you! You’re message was sent successfully!',
	'Sorry, there was a problem with your message, please try again later...',
	'Contact form submitted successfully',
	'Contact form message from website',
	'fulfilled-jobs',
	'Plan een (video)call of meeting',
	'Artikelen',
	'Onze <span class="bg-yellow px-3">kennisbank</span>',
	'Laten we de perfecte baan voor je zoeken',
	'Sluiten',
	'Laten we de perfecte baan voor je zoeken',
	'Hulp nodig?',
	'Stel je vraag aan onze specialisten',
	'Onze <span class="bg-yellow px-3">kennisbank</span>',
	'Direct solliciteren!',
	'Sollicitatie procedure',
	'Wat staat je te wachten',
	'Iets voor jou?',
	'Solliciteer nu!',
	'Solliciteer met:',
	'Vragen?',
	'Stel ze je persoonlijke recruiter',
	'Stel een vraag via Whatsapp',
	'Plan een videocall met',
	'bekijk ook',
	'Vergelijkbare vacatures',
	'Or just download the file without giving up your email',
	'Zoek naar een artikel',
	'Onze <span class="bg-yellow px-3 font-primary">kennisbank</span>',
	'Congratulations! You subscribed to our job alert!',
	'Sorry, it looks like you’re a robot...',
	'Thank you for contacting us!<br/>
	We will reply to your message as soon as possible.<br/>
	Have a nice day!',
	'In the meantime, you can stay posted by following us on',
	'This is an automatic message. Please do not reply to it.',
	'Vervulde vacatures',
	'Vervulde vacatures text',
	'This field is required',
	'Hou jij ook van koekjes?',
	'Ja, ik wil ook een koekje!',
	'WhatsApp us!',
	'Vacatures',
	'Waar ben jij naar op zoek?',
	'Company',
	'Email address',
	'Message',
	'Go back',
	'Other',
	'Make a job alert',
	'Get instant updates on the latest job openings?',
	'Sign up for the job alert',
	'Language',
	'E-mail us',
	'Call us',
	'Full name',
	'G-ACCOUNT: NL68 INGB 0990 3339 73',
	'Job title, skill, industry...',
	'Country, City, Town...',
	'Search',
	'Apply for:',
	'Newest &rarr; oldest',
	'Most relevant',
	'Oldest &rarr; newest',
	'Highest salary',
	'Lowest salary',
	'Most relevant',
	'Select a job to view details',
	'Clear filters',
	'Job Type',
	'Job Category',
	'Search articles...',
	'Location...',
	'Search jobs, keywords, companies',
	'Enter location or “remote”',
	'Choose Category',
	'Search results for',
	'Apply for this job',
	'Want to see how you match up?<br/>Upload your resume today.',
	'Ask a question via WhatsApp',
	'Plan a call with'
);

if (function_exists('pll_register_string')) {
	foreach ($toTranslate as $string) {
		pll_register_string('searchx', $string);
	}
}

function my_mce4_options($init)
{
	$custom_colours = '
        "193254", "Navy blue",
        "94D4E9", "Sea blue",
        "EC6278", "Pink",
        "FDD963", "Yellow",
        "E3E0E5", "Grey",
        "000000", "Black",
        "FFFFFF", "White"
    ';
	// build colour grid default+custom colors
	$init['textcolor_map'] = '[' . $custom_colours . ']';
	// change the number of rows in the grid if the number of colors changes
	// 8 swatches per row
	$init['textcolor_rows'] = 1;
	return $init;
}
add_filter('tiny_mce_before_init', 'my_mce4_options');

/**
 * Populate custom fields before submission.
 * These fields should have "Allow field to be populated dynamically"
 * and the "Parameter Name" set to the cookie key associated with it.
 *
 * @link https://docs.gravityforms.com/gform_pre_submission/
 *
 * @param array $form Gravity Forms form object
 */
function populate_gf_custom_fields($form)
{
	$cookies = array(
		'utm_id',
		'utm_source',
		'utm_medium',
		'utm_campaign',
		'utm_content',
		'utm_term',
		'referrer',
		'traffic-flow',
		'gclid'
	);
	foreach ($form['fields'] as $field) {
		if (in_array($field->inputName, $cookies) && !empty($_COOKIE[$field->inputName])) {
			$_POST['input_' . $field->id] = $_COOKIE[$field->inputName];
		}
	}
}
