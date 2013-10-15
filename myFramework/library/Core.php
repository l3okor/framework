<?php
class Core
{
	public static function initialize()
	{
		$registry= Registry::getInstance();
		$db = new DatabaseClass(DB_HOST, DB_NAME, DB_USER, DB_PASS);
		$registry->database = $db;
		$modules = array('admin' => 'admin', 'frontend' => 'page');
		$registry->modules = $modules;
		self::parseLink();

		return $registry;

	}

	public static function parseLink()
	{
		$realReq = substr($_SERVER['REQUEST_URI'], strlen(dirname($_SERVER['PHP_SELF'])));
		$getReq = '?' . http_build_query($_GET);
		$tmpReq = str_replace($getReq, '', $realReq);

		//strip whitespaces from beginning and end of a string
		$lnk = explode('/', trim($tmpReq, '/'));

	}


	public static function route()
	{
		$registry = Registry::getInstance();
		if (!empty($registry->controller))
		{
			$route = CONTROLLER_PATH . $registry->module . '/' . ucfirst($registry->controller) . 'Controller.php';
			if (is_file($route))
			{
				$registry->route = $route;
			}
			else
			{
				echo 'Page not found.';
			}
		}
	}



}