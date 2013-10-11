<?php
date_default_timezone_set('Europe/Bucharest');
require_once 'autoloader/Autoloader.php';
//require_once 'library/DatabaseClass.php';

$db = new DatabaseClass('localhost', 'test_db', 'root', '1234');

Registry::set('database', $db);

$db = Registry::getInstance()->database;

$db->select()->from('client', array('id', 'numeClient'))
			 ->join('car', 'car.id = client.modelMasinaId', array('carId' => 'id', 'numeProdus'));


//$db->select('animals', 'animal_id=1');
$data = $db->fetchAll();

$db->printData($data);