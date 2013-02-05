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

	public function indexAction() {}
	
	public function indexPostAction() {
		$ary = (array)json_decode(AesCtr::decrypt($_POST['payload'], $_SESSION['session_key'], 256));
		
		View::setObj(print_r($ary,true));
	}
	
} /* end controller */