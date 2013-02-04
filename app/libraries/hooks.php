<?php
/**
* DMyers Super Simple MVC
*
* @package    Hooks for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*
* Hooks:
* startup
* pre_router
* pre_controller
* shutdown
*/

class Hooks {
	static public function startup(&$app) {
		/* Default timezone of server */
		date_default_timezone_set('UTC');

		/* if MODE = DEBUG show errors - in htaccess SetEnv MODE debug */
		if ($app::$run_code != 'production') {
			ini_set('display_errors','On');
		}
	
		/* default errors */
		error_reporting(E_ALL & ~E_NOTICE);

		/* Start Session */
		session_start();

		ErrorHandler::init();

		Config::init($app);
	}

	static public function preRouter(&$app) {
		/* Include routes if they are there */
		if (is_file($app::$path.'/config/routes.php')) {
			include($app::$path.'/config/routes.php');

			foreach ((array)$routes as $regex_path => $new_path) {
				$matches = array();
				if (preg_match($regex_path, $app::$uri, $matches)) {
					$app::$uri = preg_replace($regex_path, $new_path, $app::$uri);
					break;
				}
			}
		} /* end routes */

		/* if you want to remove the request (Post, Delete, Put) from the controller method name uncomment the next line */
		// $app::$request = '';
	
	}

	/* pre controller junk here */
	static public function preController(&$app) {
		/* attach our view object & config object to the application */
		$request = (empty($app::$request)) ? '' : $app::$request.'/';
		$default_view = $app::$controller.'/'.$request.$app::$method;
		
		View::init($app,$default_view);

		View::setSitename('Simple MVC Template');
		View::setBase_url($app::$base_url);

		/* database connection - if needed */
		Database::connect(Config::get('db.dsn'),Config::get('db.username'),Config::get('db.password'));
	}

	static public function shutdown(&$app) {
		/* try to auto display the view - if it's there */
		View::render();
	}

} /* end hooks */