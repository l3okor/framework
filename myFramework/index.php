<?php
date_default_timezone_set('Europe/Bucharest');
require_once 'autoloader/Autoloader.php';
//require_once 'library/DatabaseClass.php';

$db = new DatabaseClass('localhost', 'test_db', 'root', '1234');

$db->select()->from('car')->where('numeProdus LIKE %?%', 'Dacia');

// $newVar= array('animal_type' =>'dasda', 'animal_name' => 'cfafa');
// $db->Insert($newVar, 'animals');
// exit;
// echo "<pre>";
// print_r($db->Select('animals'));
// echo "</pre>";

//$db->select('animals', 'animal_id=1');
$db->execQuery('animal_id = 1');