<?php

define('SITE_ENVIRONMENT', "development", false);
define('REDIS_INSTANCE_PORT', 6379, false);


$_settings = array();

// MySQL settings
$_settings['mysql']['host'] = 'localhost';
$_settings['mysql']['user'] = 'root';
$_settings['mysql']['password'] = 'badpassword';
$_settings['mysql']['database'] = 'urls';
