<?php

class ShortUrl {
	public $id = 0;
	public $url = ''; 
	public $destination_url = '';


	public function __construct($idOrUrl = '') {
		if ($idOrUrl) {
			$this->getData($idOrUrl);		
		}
	}

	private function getData($idOrUrl) {
		global $DB;

		//fetch url details from data store and populate the url object
	
		$id = 0;
		if (is_int($idOrUrl)) {
			$this->id = $idOrUrl;
			$query = "SELECT `id`, `short_url`, `destination_url`
				FROM `url_mappings`
				WHERE `id` = ?";
			$stmt = $DB->prepare($query);
			$stmt->bind_param('i', $idOrUrl);
		} elseif (is_string($idOrUrl)) {
			$this->url = $idOrUrl;
			$query = "SELECT `id`, `short_url`, `destination_url`
				FROM `url_mappings`
				WHERE `short_url` = ?";
			$stmt = $DB->prepare($query);
			$stmt->bind_param('s', $idOrUrl);
		}		
	
		$stmt->bind_result($id, $url, $destination_url);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();

		if ($id) {
			$this->id = $id;
			$this->url = $url;
			$this->destination_url = $destination_url;
	 	}
	}
}

