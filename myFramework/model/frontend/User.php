<?php

class User extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getUser($username, $password)
	{
		$this->db->select()
		->from('user')
		->where('username = ?', $username)
		->where('password = ?', $password);
		return $this->db->fetchAll();
	}
}