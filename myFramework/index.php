<?php
date_default_timezone_set('Europe/Bucharest');
require_once 'autoloader/Autoloader.php';
//require_once 'library/DatabaseClass.php';

$db = new DatabaseClass('localhost', 'test_db', 'root', '1234');

Registry::set('database', $db);

$db = Registry::getInstance()->database;

$db->select()->from('client', array('id', 'numeClient'))
			 ->join('car', 'car.id = client.modelMasinaId', array('carId' => 'id', 'numeProdus'));

// $newVar= array('animal_type' =>'dasda', 'animal_name' => 'cfafa');
// $db->Insert($newVar, 'animals');
// exit;
// echo "<pre>";
// print_r($db->Select('animals'));
// echo "</pre>";

//$db->select('animals', 'animal_id=1');
$data = $db->fetchAll();

echo '<pre>';
print_r($data);
echo '</pre>';