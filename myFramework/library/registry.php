<?php
/**
 * @author Stef
 */

class Registry {

	//------ static fields ------

	private static $_instance;
	protected $_objects = array();


	//------ constructor ------
	protected function __construct()
	{

	}

	//------ clone ------
	protected function __clone()
	{
		// stub method inca;
	}


	//------ getInstance()------
	public static function getInstance()
	{
		if (!isset(static::$_instance)) {
			static::$_instance = new self();
		}
		return static::$_instance;
	}


	//------  __get, __set; ------


	public function __get($key)
	{
// 		if (isset($this->_objects[$key]))
// 		{
// 			return $this->_objects[$key];
// 		}
// 		return NULL;
		if (is_null(self::$_instance))
		{
			return null;
		}
		else
		{
			return self::$_instance->getVar($key);
		}
	}

	public function __set($key, $value)
	{
		if (is_null(self::$_instance))
		{
			self::$_instance = new static;
		}
		$this->_objects[$key] = $value;
	}


	//------  setVar, getVar ------



	public function setVar($key, $value)
	{
		$this->_objects[$key] = $value;
	}

	public function getVar($key)
	{

		if(isset($this->_objects[$key]))
		{
			return $this->_objects[$key];
		}
		return null;
	}



	//------  set, get; ------



	public static function set($key, $value)
	{

		if (is_null(self::$_instance))
		{
			self::$_instance = new static;
		}
		self::$_instance->setVar($key, $value);

	}

	public static function get($key)
	{
		if (is_null(self::$_instance))
		{
			return null;
		}
		else
		{
			return self::$_instance->getVar($key);
		}

	}

	public function __isset($key)
	{
		if (is_null(self::$_instance))
		{
			return false;
		}
		else
		{
			return isset($this->_objects[$key]);
		}
	}



}
