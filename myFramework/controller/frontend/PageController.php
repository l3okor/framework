<?php

$model = new Page();
$view = new PageView($tpl);

switch ($registry->action)
{
	default:
	case 'about':
		$pageTitle = 'About Us';
		$clients = $model->getClients();
		$view->showAboutPage($clients);

	break;
}
