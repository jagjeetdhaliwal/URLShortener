<?php

require_once(__DIR__ . '/../includes/application_top.php');
require_once(__DIR__ . '/../modules/ShortUrl.php');
require_once(__DIR__ . '/../modules/UrlManager.php');


$destination_url = isset($_POST['url'])
	? trim(filter_var(trim($_POST['url']), FILTER_SANITIZE_URL)) : '';

$output = array();
$destination_url = 'https://www.very-long-domain-for-bored-people.com/articles/category/tutorials/2014/05/12/how-to-desing-url-shortener-and-build-it-in-2-hours#summary';

if (!$destination_url) {
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






