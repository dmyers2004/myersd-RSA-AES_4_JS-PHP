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

class mainController {

	public function indexAction() {
		View::setJs('<script src="'.Application::$base_url.'/assets/js/page/index.js"></script>');

		$key = preg_replace("![^\x20-\x7E]!", '', file_get_contents('app/libraries/keys/public.key'));

		View::setRsaPub($key);
	}
	
	public function indexPostAction() {
		$private = file_get_contents('app/libraries/keys/private.key');
		
		$email = $_POST['email'];
		$timestamp = $_POST['secure_timestamp'];
		$hmac = $_POST['hmac'];
		$password = $_POST['secure_password'];
		
		$password = General::rsa_decrypt($password,$private);
		
		$session_key = General::rsa_decrypt($_POST['secure_session_key'],$private);
		$_SESSION['session_key'] = $session_key;
				
		$hmac = hash('sha256',$email.$password.$timestamp);
		
		$utc_time = time();
		$difference = abs($utc_time - (int)$timestamp);

		View::setPosted(print_r($_POST,true));
		View::setPassword($password);
		View::setSecureHmac($hmac);
		View::setGeneratedHmac($hmac);
		View::setDifference($difference);
		
		if ($difference > 300) {
			View::setRequestAge('YES');
		} else {
			View::setRequestAge('Within Range');		
		}
		
	}
	
	public function logoutAction() {
		session_destroy();
		General::redirect('/');
	}

} /* end controller */