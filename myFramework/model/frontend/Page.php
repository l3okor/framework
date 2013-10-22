<?php
class Page extends Model
{
	public function getClients()
	{
		return array(0 => array('id'=>1, 'name'=>'orice', 'car' => 'altceva'), 1 => array('id'=>2, 'name'=>'altceva', 'car' => 'orice'));
	}
}