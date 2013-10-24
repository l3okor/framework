<?php

class Auth
{
	public static function isUserLogged()
	{
		if (empty($_SESSION['user']))
		{
			return false;
		}
		return true;
	}

	public static function checkIsUserLogged()
	{
		if (!self::isUserLogged())
		{
			header('location: ' . SITE_URL . '/frontend');
			exit;
		}
	}

	public static function isAdminLogged()
	{
		if (empty($_SESSION['admin']))
		{
			return false;
		}
		return true;
	}

	public static function checkIsAdminLogged()
	{
		if (!self::isAdminLogged())
		{
			header('location: ' . SITE_URL . '/admin/admin');
			exit;
		}
	}
}