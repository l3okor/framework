<?php

$view = new UserView($tpl);
$model = new User();

switch ($registry->action)
{
	case 'login':
		if (Auth::isUserLogged())
		{
			header('Location: ' . SITE_URL . '/user');
			exit;
		}

		$view->loginPage();
		break;

	case 'verifylogin' :
		$errors = array();
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$usr = trim($_POST['username']);
			$pwd = trim($_POST['password']);

			if(empty($usr))
			{
				$errors[] = 'Username empty';
			}
			if(empty($pwd))
			{
				$errors[] = 'Password empty';
			}
			if(strlen($usr) < 3)
			{
				$errors[] = 'Username must be longer than 3 characters';
			}

			if (!empty($errors))
			{
				$_SESSION['msg']['type'] = 'error';
				$_SESSION['msg']['text'] = $errors;
				header('Location:' . SITE_URL . '/user/login');
				exit;
			}
			else

			{
				$user = $model->getUser($usr, $pwd);
				if (!empty($user))
				{
					$_SESSION['user'] = $user[0];
					$_SESSION['msg']['type'] = 'info';
					$_SESSION['msg']['text'] = 'User Logged!';
					header('Location:' . SITE_URL . '/user');
					exit;
				}
				else
				{
					$_SESSION['msg']['type'] = 'error';
					$_SESSION['msg']['text'] = 'Wrong Login.';
					header('Location:' . SITE_URL . '/user/login');
					exit;
				}
			}

		}
		break;

	default:
	case 'account':
		Auth::checkIsUserLogged();



	break;

	case 'logout':
		unset($_SESSION['user']);
		header('Location:' . SITE_URL . '/user/login');
		exit;
		break;
}