<?php
/**
* DMyers Super Simple MVC
*
* @package    Application File
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

/* Application */
class Application {
	static public $run_code;
	static public $path;
	static public $base_url;
	static public $uri;
	static public $raw_uri;
	static public $is_ajax;
	static public $controller;
	static public $method;
	static public $segs;
	static public $request;
	static public $raw_request;

	static public function run($runcode = 'production') {
		/* if they send in something blank then set it to production */
		self::$run_code = $runcode;

		/* Where is this bootstrap file */
		self::$path = __DIR__;

		/* Defaults to no errors displayed */
		ini_set('display_errors','Off');

		/* register the autoloader */
		spl_autoload_register(array(self, 'autoLoader'));

		/* is this a ajax request? */
		self::$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

		/* try to call hook if it's there */
		self::trigger('startup');

		/* with http:// and with trailing slash - auto detect https adjustment may be needed here */
		self::$base_url = trim('http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']),'/');

		/* The GET method is default so controller methods look like openAction, others are handled directly openPostAction, openPutAction, openDeleteAction, etc... */
		self::$raw_request = ucfirst(strtolower($_SERVER['REQUEST_METHOD']));
		self::$request = (self::$raw_request == 'Get') ? '' : self::$raw_request;

		/* Put ANY (POST, PUT, DELETE) posted into into $_POST */
		parse_str(file_get_contents('php://input'), $_POST);

		/* get the uri (uniform resource identifier) */
		self::$uri = self::$raw_uri = trim(urldecode(substr(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH),strlen(dirname($_SERVER['SCRIPT_NAME'])))),'/');

		/* try to call hook if it's there */
		self::trigger('preRouter');

		/* get the uri pieces */
		$segs = explode('/',self::$uri);

		/* If they didn't include a controller and method use the defaults  main & index */
		self::$controller = (!empty($segs[0])) ? strtolower(array_shift($segs)) : 'main';
		self::$method = (!empty($segs[0])) ? strtolower(array_shift($segs)) : 'index';

		/* store what ever is left over in segs */
		self::$segs = $segs;

		/* try to auto load the controller - will throw an error you must catch if it's not there */
		$classname = self::$controller.'Controller';
		$main_controller = new $classname;

		/* try to call hook if it's there */
		self::trigger('preController');

		/* call the method - will throw an error you must catch if it's not there */
		call_user_func_array(array($main_controller,self::$method.self::$request.'Action'),self::$segs);

		/* try to call hook if it's there */
		self::trigger('shutdown');
	}

	static public function trigger($name) {
		try {
			Hooks::$name(new Application(self::$run_code));
		} catch (Exception $e) {}
	}

	/* class autoloader */
	static public function autoLoader($name) {
		$path = 'controllers';
		
		if (substr($name,-10) == 'Controller') {
			$name = substr($name,0,-10);
		} else {
			$path = ($name{0} >= 'A' && $name{0} <='Z') ? 'libraries' : 'models';
		}
		
		self::load($path.'/'.strtolower($name),4005);
	}
	/*
	manual load for non-class based files
	(which the autoload takes care of)
	this is also used by the autoloader
	*/
	static public function load($file,$throw_error=false) {
		$load = self::$path.'/'.$file.'.php';
		
		if (file_exists($load)) {
			require_once($load);
		} elseif ($throw_error) {
			throw new Exception('File '.$load.' Not Found',$throw_error);
		}
	}

} /* end mvc controller class */