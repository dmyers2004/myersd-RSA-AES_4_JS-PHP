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

class baseAdminController {

	public function __construct() {
		if (empty($_SESSION['session_key'])) {
			General::redirect('/accessdenied');
		}
	}
	
} /* end controller */