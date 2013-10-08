<?php

function __autoload($name)
{
	$dirs = array_filter(glob("library/"), 'is_dir');
	foreach ($dirs as $currDir)
	{
		dirSearch($currDir, $name);

	}
}

function dirSearch($currDir, $name)
{
	if (is_file("$currDir/$name.php"))
	{
		require_once "$currDir/$name.php";
	}

	$dirs = array_filter(glob($currDir."/*"), 'is_dir');
	foreach ($dirs as $cdir)
	{
		dirSearch("$cdir", $name);
	}
}



