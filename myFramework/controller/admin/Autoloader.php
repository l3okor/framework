<?php

class Autoloader
{
	public static function autoload($path, $recursive = TRUE )
	{
		if(is_dir($path))

		$handle = opendir($path);

		while(false !== ($file = readdir($handle)))
		{
			if(is_file($path . $file) && strpos($file, '.php'))
			{
				require_once($path . $file);
			}
			elseif(is_dir($path . $file) && $recursive && $file != '.' && $file != '..')
			{
				self::autoload($path . $file . '/' ,$recursive);
			}
		}
	}
}


