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

		return false;
	}


	public static function saveShortURL($short_url, $destination_url) {
		//Store in database and then in redis

		return true;
	}


	// Check the urls done only in the last 15 minutes. We allow duplicacy in destination urls
	public static function hasUrlAlreadyBeenShortened($destination_url) {

		return false;
	}
}
