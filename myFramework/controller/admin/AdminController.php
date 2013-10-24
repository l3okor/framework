<?php

$adminView = new AdminView($tpl);
$adminModel = new Admin();

switch ($registry->action)
{
	default:

	case 'login':
		if (empty($_SESSION['admin']))
		{
			$adminView->loginPage();
		}
		else
		{
			header('Location: ' . SITE_URL . 'admin/admin/');
		}
		break;

	case 'verifylogin' :
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if ((!empty($_POST['username'])) && (!empty($POST['password'])))
			{
				$username = $_POST['username'];
				$password = $_POST['password'];
				$admin = $adminModel->getAdmin($username, $password);
				if (!empty($admin))
				{
					$_SESSION['admin'] = $admin[0];
					$_SESSION['msg']['type'] = 'info';
					$_SESSION['msg']['text'] = 'Admin Logged!';
					header('Location:' . SITE_URL . '/admin/admin');
					exit;
				}
				else
				{
					$_SESSION['msg']['type'] = 'error';
					$_SESSION['msg']['text'] = 'Wrong Login.';
					header('Location:' . SITE_URL . 'admin/admin/login');
					exit;
				}
			}

			$_SESSION['msg']['type'] = 'error';
			$_SESSION['msg']['text'] = 'Wrong login.';
			header('Location:' . SITE_URL . 'admin/admin/login');
			exit;

		}
		break;
	case 'logout':
		unset($_SESSION['admin']);
		header('Location:' .SITE_URL . 'admin/admin/login');
		exit;
		break;
}