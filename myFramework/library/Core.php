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
		$registry = Registry::getInstance();
		$modules = Registry::get('modules');
		$reqModule = 'frontend';
		if (in_array($lnk[0], array_keys($modules)))
		{
			$reqModule = $lnk[0];
			array_shift($lnk);
		}
		$registry->module = $reqModule;

		$reqController = $modules[$reqModule];
		if (isset($lnk[0]) && $lnk[0]!== '')
		{
			$reqController = $lnk[0];
			array_shift($lnk);
		}
		$registry->controller = $reqController;

		$reqAction = '';
	    if (isset($lnk[0]) && $lnk[0]!== '')
		{
			$reqAction = $lnk[0];
			array_shift($lnk);
		}
		$registry->action = $reqAction;
		$j = count($lnk);
		$reqParam = array();
		for ($i=0; $i<$j; $i+=2)
		{
			$reqParam[$lnk[$i]] = isset($lnk[$i+1]) ? $lnk[$i+1] : '';
		}

		$registry->params = $reqParam;

	}

	public static function debug($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}

	public static function route()
	{
		$registry = Registry::getInstance();

		if (!empty($registry->controller))
		{
			self::loadControllerClasses();
			$route = CONTROLLER_PATH . $registry->module . '/' . ucfirst($registry->controller) . 'Controller.php';

			if (is_file($route))
			{

				$registry->route = $route;
				require_once ($route);
			}
			else
			{
				echo 'Page not found.';
			}
		}
		else{
			echo 'Page not found';
		}
	}

	public static function loadControllerClasses()
	{
		$registry = Registry::getInstance();
		$model = MODEL_PATH . $registry->module . '/' . ucfirst($registry->controller) . '.php';
		$view = VIEW_PATH . $registry->module . '/' . ucfirst($registry->controller) . 'View.php';
		if (file_exists($model))
		{
			require_once($model);
		}
		else
		{
			die("Model $model does not exist");
		}

		if (file_exists($view))
		{
			require_once($view);
		}
		else
		{
			die("Model $view does not exist");
		}
	}



}