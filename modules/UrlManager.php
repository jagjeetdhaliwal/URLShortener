<?php

class UrlManager extends ShortUrl {
	const SHORT_URL_LENGTH = 6;

	public static function createShortUrl() {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num_characters = strlen($characters);

		$short_url = '';
		for ($i = 0; $i < self::SHORT_URL_LENGTH; $i++) {
			$short_url .= $characters[rand(0, $num_characters - 1)];
		}

		if (self::urlAlreadyExists($short_url)) {
			return createShortUrl();
		} else {
			return $short_url;
		}
	}

	public static function urlAlreadyExists($short_url) {
		// Check in database
		global $DB;

	    $query = "SELECT COUNT(*)
				FROM `url_mappings`
				WHERE `short_url` = ?";

	    $stmt = $DB->prepare($query);
	    $stmt->bind_param('s', $short_url);
		$stmt->bind_result($exists);
	    $stmt->execute();
	    $stmt->fetch();
	    $stmt->close();

	    return $exists;
	}


	public static function saveShortURL($short_url, $destination_url) {
		//Store in database and then in redis
		global $DB;

	    $query = "INSERT INTO `url_mappings`(`short_url`, `destination_url`) VALUES (?, ?)";

	    $stmt = $DB->prepare($query);
	    $stmt->bind_param('ss', $short_url, $destination_url);
	    $stmt->execute();

	    $affected = false;
	    if ($stmt->affected_rows) {
	        $affected = true;
	    }

	    $stmt->close();

	    return $affected;
	}


	// Check the urls done only in the last 15 minutes. We allow duplicacy in destination urls
	public static function hasUrlAlreadyBeenShortened($destination_url) {

		return false;
	}

	public static function getLastFiveURLs() {
	global $DB;	
	$urls = array();

		$query = "SELECT `id`, `short_url`, `destination_url`
				FROM `url_mappings`
				ORDER BY `created_at` DESC
				LIMIT 5";
		$stmt = $DB->prepare($query);
    	$stmt->bind_result($id, $url, $destination_url);
	    $stmt->execute();

	    while ($stmt->fetch()) {
	    	$urls[] = array('short_url' => $url, 'destination_url' => $destination_url);
	    }

	    $stmt->close();

	    return $urls;
	}
}
