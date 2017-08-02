<?php

define('SITE_ENVIRONMENT', "development", false);
define('HOST', 'http://13.59.76.31/index?goto=', false);
define('REDIS_URL_PORT', 6379, false);
define('REDIS_URL_HOST', '127.0.0.1', false);

$_settings = array();

// MySQL settings
$_settings['mysql']['host'] = 'localhost';
$_settings['mysql']['user'] = 'root';
$_settings['mysql']['password'] = 'badpassword';
$_settings['mysql']['database'] = 'urls';
