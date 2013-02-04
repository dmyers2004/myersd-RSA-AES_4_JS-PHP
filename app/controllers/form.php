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

class formController extends baseAdminController {

	public function __construct() {
		parent::__construct();
	}

	public function indexAction() {
		View::setJs('<script src="'.Application::$base_url.'/assets/js/page/form/index.js"></script>');
	}
	
	public function indexPostAction() {
		General::payload2post($_POST,$_POST['payload'],$_SESSION['session_key']);
		
		$dmatch = (General::Timeout($_POST['protector_timestamp'])) ? 'Pass' : 'fail';
		
		View::setDMatch($dmatch);
		View::setObj(print_r($_POST,true));
	}
	
} /* end controller */