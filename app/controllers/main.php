<?php
/**
	* DMyers Super Simple MVC
	*
	* @package    Bootstrap File
	* @language   PHP
	* @author     Don Myers
	* @copyright  Copyright (c) 2011
	* @license    Released under the MIT License.
	*
	*/

class mainController extends basePublicController {

	public function __construct() {
		parent::__construct();
	}

	public function indexAction() {
		View::setJs('<script src="'.Application::$base_url.'/assets/js/page/main/index.js"></script>');

		$key = preg_replace("![^\x20-\x7E]!", '', file_get_contents('app/libraries/keys/public.key'));

		View::setRsaPub($key);
	}
	
	public function indexPostAction() {
		$private = file_get_contents('app/libraries/keys/private.key');
		
		$email = $_POST['email'];
		$secure_timestamp = $_POST['secure_timestamp'];
		$hmac = $_POST['hmac'];

		$secure_password = $_POST['secure_password'];
		$password = General::rsa_decrypt($secure_password,$private);

		$session_key = General::rsa_decrypt($_POST['secure_session_key'],$private);
		$_SESSION['session_key'] = $session_key;
				
		$genhmac = hash('sha256',$email.$password.$secure_timestamp);
		$match = ($hmac == $genhmac) ? 'Pass' : 'Fail';
		
		$dmatch = (General::Timeout($_POST['secure_timestamp'])) ? 'Pass' : 'fail';
		
		View::setHMatch($match);
		View::setPosted(print_r($_POST,true));
		View::setPassword($password);
		View::setSecureHmac($hmac);
		View::setGeneratedHmac($genhmac);
		View::setDMatch($dmatch);
		View::setDifference($difference);
	}
	
	public function logoutAction() {
		session_destroy();
		General::redirect('/');
	}
	
	public function notloggedinAction() {
	}

} /* end controller */