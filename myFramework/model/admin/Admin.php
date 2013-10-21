<?php

class Admin extends Model
{
	public function getAdmin($admin, $pass )
	{
		$this->db->select()
		->from('admin', array('id', 'name', 'password'))
		->where('name = ?', $admin)
		->where('password = ?', $pass);
		return $this->db->fetchAll();
	}

	public function getRegAdmin($admin)
	{
		$this->db->select()
		->from('admin', array('id', 'name'))
		->where('name = ?', $admin);
		return $this->db->fetchAll();
	}
}