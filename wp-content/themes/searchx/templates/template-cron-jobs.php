<?php

/**
 * Template Name: Cron Jobs
 */
if (isset($_GET['hash']) && $_GET['hash'] === 'b31d032cfdcf47a399990a71e43c') {
	$hash = true;
} else {
	$hash = false;
}

if ($hash) {
	xmlRead();
} else if (is_user_logged_in()) {
	xmlRead();
} else {
	auth_redirect();
}
