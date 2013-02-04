<?php
/**
* DMyers Super Simple MVC
*
* @package    Config for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class Config {
	static public $init = false;
	static public $data = array();
	static public $app_path;
	static public $default = 'application';

	static public function init(&$app) {
		self::$init = true;
		self::$app_path = $app::$path;

		self::load();
	}

	static public function load($name=NULL) {
		$name = ($name) ? $name : self::$default;

		/* manually load file so $config variable is local */
		if (is_file(self::$app_path.'/config/'.$name.'.php')) {
			include(self::$app_path.'/config/'.$name.'.php');
			if ($name == self::$default) {
				self::$data = array_merge_recursive((array)self::$data,(array)$config);
			} else {
				self::$data[$name] = $config;
			}
		} else {
			self::$data[$name] = array();
		}
	}
	
	static public function get($name,$default=NULL) {
		$val = NULL;
		
		if (strpos($name,'.') === false) {
			$val = self::$data[$name];
		} else {
			$e = explode('.',$name);
			if (!isset(self::$data[$e[0]])) {
				self::load($e[0]);
			}
			$val = self::$data[$e[0]][$e[1]];
		}
		
		return ($val === NULL) ? $default : $val;
	}
	
	static public function set($name,$value) {
		if (strpos($name,'.') === false) {
			self::$data[$name] = $value;
		} else {
			$e = explode('.',$name);
			self::$data[$e[0]][$e[1]] = $value;
		}
	}

}