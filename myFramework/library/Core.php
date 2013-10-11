<?php
class Core
{
	public static function initialize()
	{
		$registry= Registry::getInstance();
		$db = new DatabaseClass(DB_HOST, DB_NAME, DB_USER, DB_PASS);
		$registry->database = $db;

		return $registry;

	}

	public static function parseLink()
	{
		$realReq = substr($_SERVER['REQUEST_URI'], strlen(dirname($_SERVER['PHP_SELF'])));
		$getReq = '?' . http_build_query($_GET);
		$tmpReq = str_replace($getReq, '', $realReq);

		//strip whitespaces from beginning and end of a string
		$lnk = explode('/', trim($tmpReq, '/'));
		$reqModule = 'frontend';
		$registry = Registry::getInstance();
		$modules = Registry::get('modules');
		if (in_array($lnk[0], array_keys($modules)))
		{
			$reqModule = $lnk[0];
			array_shift($lnk);
		}

		$reqController =$modules[$reqModule];

	}


	public static function route()
	{

	}



}