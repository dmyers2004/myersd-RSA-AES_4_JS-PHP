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
		session_destroy();
	
		$key = preg_replace("![^\x20-\x7E]!", '', file_get_contents('app/libraries/keys/public.key'));

		View::setRsaPub($key);
		
		View::setFlashMsg($_SESSION['flash_message']);
		$_SESSION['flash_message'] = '';
	}
	
	public function indexPostAction() {
		$private = file_get_contents('app/libraries/keys/private.key');

		$_SESSION['session_key'] = General::rsa_decrypt($_POST['aes_password'],$private);

		$ary = (array)json_decode(AesCtr::decrypt($_POST['payload'], $_SESSION['session_key'], 256));

		View::setSessionKey($_SESSION['session_key']);
		View::setPosted(print_r($ary,true));
	}
	
	public function logoutAction() {
		session_destroy();
		General::redirect('/');
	}
	
	public function notloggedinAction() {
	}

} /* end controller */