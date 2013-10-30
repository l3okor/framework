<?php

$view = new UserView($tpl);
$model = new User();

switch ($registry->action)
{
	case 'login':
		$pageTitle = 'User Login';
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
		$pageTitle = 'My Account';
		Auth::checkIsUserLogged();
		$jojo = $model->getUser($_POST['username'], $_POST['password']);
		var_dump($jojo);
		$view->myAccountPage();


	break;

	case 'logout':
		unset($_SESSION['user']);
		header('Location:' . SITE_URL . '/user/login');
		exit;
		break;

	case 'register' :
		$error = array();
		$pageTitle = 'Register User';

		$data = isset($_SESSION['registerData']) ? $_SESSION['registerData'] : array();
		unset($_SESSION['registerData']);

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if (($_POST['confirmpassword'] != $_POST['password']) )
			{
				$error[] = 'Passwords do not match';
			}

			if (empty($_POST['password']))
			{
				$error[]='Password must not be empty!';
			}
			if (empty($_POST['username']))
			{
				$error[]='Username must not be empty!';
			}
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === FALSE)
			{
				$error[]='Email not valid!';
			}

			if (!empty($error))
			{
				$_SESSION['msg']['type'] = 'error';
				$_SESSION['msg']['text'] = $error;

				$_SESSION['registerData'] = $_POST;
				unset($_SESSION['registerData']['password']);
				unset($_SESSION['registerData']['confirmpassword']);

				header('Location: ' . SITE_URL . '/user/register');
				exit;
			}
			else
			{
				$_SESSION['msg']['type'] = 'info';
				$_SESSION['msg']['text'] = 'User registered';

				$id = $model->registerUser($_POST);

				if($id === false)
				{
					$_SESSION['msg']['type'] = 'error';
					$_SESSION['msg']['text'] = 'Register unsuccessfull. Internal error/username/email already taken';

					$_SESSION['registerData'] = $_POST;
					unset($_SESSION['registerData']['password']);
					unset($_SESSION['registerData']['confirmpassword']);

					header('Location: ' . SITE_URL . '/user/register');
					exit;

				}
				else{
					$user = $model->getUserById($id);
					$_SESSION['user'] = $user;
				}


				header('Location: ' . SITE_URL . '/user');
				exit;
			}

		}

		$view->registerPage($data);
		break;

}

