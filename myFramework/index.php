<?php
date_default_timezone_set('Europe/Bucharest');
ini_set('display_errors', 1);

define('CONFIG_PATH', 'config/config.php');
require_once(CONFIG_PATH);
require_once('/library/Autoloader.php');
Autoloader::autoload(LIBRARY_PATH);

Core::initialize();
Core::route();

