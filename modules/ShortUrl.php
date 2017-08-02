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
		if (is_int($idOrUrl)) {
			$this->id = $idOrUrl;
		} elseif (is_string($idOrUrl)) {
			$this->url = $idOrUrl;
		}

		//fetch url details from data store and populate the url object

	}
}

