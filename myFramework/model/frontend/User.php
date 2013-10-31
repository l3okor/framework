<?php

class User extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getUserById($id)
	{
		$this->db->select()
		->from('user')
		->where('id = ?', $id);
		$user = $this->db->fetchAll();
		return $user[0];
	}

	public function getUser($username, $password)
	{
		$this->db->select()
		->from('user')
		->where('username = ?', $username)
		->where('password = ?', $password);
		return $this->db->fetchAll();
	}

	public function registerUser($data)
	{
		try{
			if(isset($data['confirmpassword'])) unset($data['confirmpassword']);

			$this->db->insert('user', $data);
			return $this->db->lastInsertId();
		}
		catch(Exception $e)
		{
			return false;
		}
	}

	public function updateUser($data, $id)
	{
		try{

			 $this->db->update('user', $data, 'id = ' . $id);

		}
		catch (Exception $e){
			return false;
		}
	}
}