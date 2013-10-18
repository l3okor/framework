<?php
date_default_timezone_set('Europe/Bucharest');
require_once '../../library/Core.php';
require_once 'registry.php';
require_once 'DatabaseClass.php';


define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '1234');
define('DB_NAME', 'test_db');


$db = new DatabaseClass('localhost', 'test_db', 'root', '1234');

Registry::set('database', $db);

$core =  new Core();



$core::initialize();
//echo 'initialized';
$core::parseLink();
//echo 'parsed';
$core::route();
//echo 'routed';


