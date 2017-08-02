<?php

require_once(__DIR__ . '/../includes/application_top.php');
require_once(__DIR__ . '/../modules/ShortUrl.php');
require_once(__DIR__ . '/../modules/UrlManager.php');


$destination_url = isset($_POST['url'])
	? trim(filter_var(trim($_POST['url']), FILTER_SANITIZE_URL)) : '';

$output = array();

if (!$destination_url || !filter_var($destination_url, FILTER_VALIDATE_URL)) {
	//return error json

	$output['status'] = 'failed';
	$output['message'] = 'Please pass a valid URL';

} else {
	$short_url = \UrlManager::createShortUrl($destination_url);

	if ($short_url) {
		if (\UrlManager::saveShortURL($short_url, $destination_url)) {
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

echo json_encode($output);
die();






