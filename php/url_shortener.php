<?php

require_once(__DIR__ . '/../includes/application_top.php');
require_once(__DIR__ . '/../modules/ShortUrl.php');
require_once(__DIR__ . '/../modules/UrlManager.php');


// Validate CSRF token
if (!isSet($_SESSION['csrf_token']) || empty($_SESSION['csrf_token'])
    || empty($_POST['csrf_token']) || !isSet($_POST['csrf_token'])
    || ($_SESSION['csrf_token'] != $_POST['csrf_token']) ) {
	$output['status'] = 'failed';
    $output['message'] = "Something went wrong, go back and try again!";
} else {
	$destination_url = isset($_POST['url'])
		? trim(filter_var(trim($_POST['url']), FILTER_SANITIZE_URL)) : '';

	$output = array();

	// validate destination url that we are shortening.
	if (!$destination_url || !filter_var($destination_url, FILTER_VALIDATE_URL)) {
		$output['status'] = 'failed';
		$output['message'] = 'Please pass a valid URL';
	} else {
		$short_url = \UrlManager::createShortUrl($destination_url); //generate a short url.

		//TO DO - use a semaphore on short_url to avoid further collisions at scale. Redis can be used.
		if ($short_url) {
			if (\UrlManager::saveShortURL($short_url, $destination_url)) { //save url in the database
				$redis = new Redis();
				$redis->connect(REDIS_URL_HOST, REDIS_URL_PORT);
				$redis->set($short_url, $destination_url); //save in redis for faster fetching.

				$output['status'] = 'success';
				$output['short_url'] = $short_url;
				$output['message'] = 'Url shortened successfully';
			} else {
				$output['status'] = 'failed';
				$output['message'] = 'Sorry, we let you down. Please try again later';
			}
		} else {
			$output['status'] = 'failed';
			$output['message'] = 'Sorry, we let you down. Please try again later';
		}
	}
}

header("Content-Type: application/json");
echo json_encode($output);
die();






