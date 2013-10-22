<?php

class Template
{

	protected $_files = array();
	protected $_varVals = array();
	protected $_varKeys = array();
	protected $_rootPath = '';

	protected static $_instance;

	public function __construct()
	{

	}

	public static function getInstance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new static;
		}
		return self::$_instance;
	}


	public function setRoot($root)
	{
		if (strrpos($root, '/') === (strlen($root) - 1) )
		{
			$root = substr($root, 0, -1);
		}
		if (is_dir($root))
		{
			$this->_rootPath=$root;
		}
	}

/**
 * Function has two parameters
 * @param $varName - the name of the variable/ template
 * @param $fileName - the path to the file
   verifies if the path is absolute.
   If needed it's concatenated with the root path
   then stores the path.
 *
 *
 */
	public function setFile($varName, $fileName)
	{

		if (0 === strpos($fileName, '/') || strpos($fileName, ':\\') || strpos($fileName, ':/') || strpos($fileName, '\\'))
		{
			$pathVar = $fileName;
		}
		else
		{
			$pathVar = $this->_rootPath . $fileName;
		}
		if (file_exists($pathVar))
		{
			$this->_files[$varName] = $pathVar;
			$this->setVar($varName, file_get_contents($pathVar));

		}
		else
		{
			echo 'Error: Template not found';
			$this->setVar($varName, "Caution : $pathVar does not exist");
		}

	}

	public function setVar($varName, $value, $append=false)
	{
		$this->_varKeys[$varName] = '{' . $varName . '}';
		$this->_varVals[$varName] = $value;
	}

	public function getVar($varName)
	{
		if (array_key_exists($varName, $this->_varKeys))
		{
			return $this->_varVals[$varName];
		}
		return '';
	}

	public function unsetVar($varName)
	{
		$this->_varKeys[$varName] = '';
		$this->_varVals[$varName] = '';
	}

	public function subst($varName)
	{
		$temp = $this->getVar($varName);

		foreach ($this->_varKeys as $key => $value)
		{
			$temp = str_replace($value, $this->_varVals, $temp);
		}

		return $temp;
	}

	public function parse($target, $varName, $append = false)
	{

	}

	public function pparse($target, $varName, $append = false)
	{

	}

	public function setBlock($parent, $varName, $alias)
	{

	}
}