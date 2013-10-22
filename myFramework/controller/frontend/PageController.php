<?php

$model = new Page();
$view = new PageView();

switch ($registry->action)
{
	default:
	case 'about':

		echo '<h1>Your in about page</h1>';

	break;
}
