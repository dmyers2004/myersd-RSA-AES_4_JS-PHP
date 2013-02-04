<?php
/**
* DMyers Super Simple MVC
*
* @package    Cache for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class Cache {
	static public $init = false;
	static public $time = 3600;
	static public $path;

	static public function init(&$app,$time=3600) {
		self::$init = true;
		self::$time = $time;
		self::$path = $app::$path.'/libraries/cache/';
		
		@mkdir(self::$path);
	}

	/* cache functions */
	static public function read($key) {
		
		$key = self::$path.md5($key);

		if (!file_exists($key) || (filemtime($key) < (time() - self::$time))) {
			return null;
		}

		if (filesize($key) == 0) {
			return null;
		}

		return(unserialize(file_get_contents($key)));
	}

	static public function write($key, $data) {
		$file = tempnam(self::$path,'temp-');
		file_put_contents($file,serialize($data));
		rename($file,self::$path.md5($key));
	}

}