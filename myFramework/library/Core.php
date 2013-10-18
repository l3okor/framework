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
		echo 'initialized';

	}

	public static function parseLink()
	{
	//removes the GET parameter from URL
		$realRequest = substr($_SERVER['REQUEST_URI'], strlen(dirname($_SERVER['PHP_SELF'])));
		$getRequest = '?' . http_build_query($_GET);
		$tmpRequest = str_replace($getRequest, '', $realRequest);

		//Strip whitespace (or other characters) from the beginning and end of a string
		$link = explode('/', trim($tmpRequest, '/'));
		//print_r($link);exit;
		$reqModule = 'frontend';
		$registry = Registry::getInstance();
		$modules = Registry::get('modules');
		if (in_array($link[0] , array_keys($modules)))
		{
			$reqModule = $link[0];
			array_shift($link);

		}
		//print_r($link);exit;
		$reqController = $modules[$reqModule];

		if (isset($link[0]) && $link[0] !== '')
		{
			$reqController = $link[0];
		}

		$reqAction = '';
		if (isset($link[1]) && $link[1] !== '')
		{
			$reqAction = $link[1];
		}
		$n = count($link);
		$reqParams = array();
		for ($i=2;$i<$n;$i+=2)
		{
		$reqParams [$link[$i]] = isset($link[$i+1]) ? $link[$i+1] : '' ;
		}
		$registry->controller = $reqController;
		$registry->module = $reqModule;
		$registry->params = $reqParams;
		$registry->action = $reqAction;
		echo 'parsed';

	}


// 	public static function route()
// 	{
// 		$registry = Registry::getInstance();
// 		if (!empty($registry->controller))
// 		{
// 			$route = CONTROLLER_PATH . $registry->module . '/' . ucfirst($registry->controller) . 'Controller.php';
// 			if (is_file($route))
// 			{
// 				$registry->route = $route;
// 				require_once ($route);
// 			}
// 			else
// 			{
// 				echo 'Page not found.';
// 			}
// 		}
// 	}

	public static function route()
	{
		$registry = Registry::getInstance();
		echo '1111';
		if (!empty($registry->controller))
		{

			$route = CONTROLLERS_PATH . $registry->module . '/' . ucfirst($registry->controller) . 'Controller.php';
			if (is_file($route))
			{
				$registry->route = $route;
				echo '1111';
// 				session_start();
// 				$generalView = VIEW_PATH . $registry->module . '/' . 'View.php';
// 				require_once($generalView);
// 				$tpl = View::getInstance();
// 				$tpl->setRoot('templates/' . $registry->module);
// 				$tpl->setIndexFile();
				if('admin' == $registry->module)
				{
// 					$tpl->setMenu();
// 					$tpl->displayLoginButton();
// 					$tpl->displayMessage();
                    echo 'admin is logged';
				}

				$pageTitle = '';
				self::loadControllerClasses();
				require($registry->route);
			}
			else
			{
				echo 'Page not found';

			}
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