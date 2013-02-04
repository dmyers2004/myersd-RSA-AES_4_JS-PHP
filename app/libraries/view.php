<?php
/**
* DMyers Super Simple MVC
*
* @package    view for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class View {
	static public $init = false;
	static public $layout;
	static public $body;
	static public $path;
	static public $app_path;
	static public $default;
	static public $data;

	static public function init(&$app,$default='') {
		self::$init = true;
		self::$data = new stdClass;
		
		self::$layout = Config::get('view.layout','layout');
		self::$body = Config::get('view.body','body');
		
		self::$app_path = $app::$path;
		self::$default = $default;
	}

	/* load view into variable and output */
	/*
		render(); load default page into body and output default template
		render('template'); load this template and output
		render('viewfile','template'); load this view file into body data variable and output using template
	*/
	static public function render($file=NULL,$template=NULL) {
		$layout = $file;
	
		if ($file == NULL and $template == NULL) {
			self::load(self::$default,self::$body);
			$layout = ($template) ? $template : self::$layout;
		}

		/* output the template if it's there */
		echo self::load($layout);
	}
	
	/*
		load('viewfile'); load this view file and return it
		load('viewfile',(array)$data); load this view file with this data and return it
		load('viewfile',(array)$data); load this view file and echo it out and return it

		load('viewfile',(string)'nav'); load view file into nav data variable
		load('viewfile',(string)'nav',$data); load view file into nav data variable using this array as the data
	*/
	static public function load($file,$data=null,$newdata=null) {
		$capture = '';
	
		if ($data == NULL or is_array($data)) {
			$data = ($data) ? $data : self::$data;
	
			$file = self::$app_path.'/views/'.$file.'.php';
			if (is_file($file)) {
				$capture = self::_capture($file,(array)$data);
			}
		} elseif (is_string($data)) {
			$newdata = ($newdata) ? $newdata : self::$data;
			$capture = self::load($file,(array)$newdata);
			self::$data->$data = $capture;
		}

		return $capture;
	}
	
	static protected function _capture($_mvc_file,$_mvc_data) {
		extract($_mvc_data);
		ob_start();
		include($_mvc_file);
		return ob_get_clean();
	}

	static public function __callStatic($method, $args) {	
	  if (preg_match('/^([gs]et)([A-Z])(.*)$/', $method, $match)) {
			$property = strtolower($match[2].$match[3]);
			switch ($match[1]) {
				case 'set':
					self::$data->$property = $args[0];
				break;
				case 'get':
					return self::$data->$args[0];
				break;
			}
	  }
	  return self;
	}

}