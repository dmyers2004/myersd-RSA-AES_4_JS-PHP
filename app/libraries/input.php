<?php
/**
* DMyers Super Simple MVC
*
* @package    input for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class Input {
	static public $max = 2048;

	static public function int($name,$default=0,$length=8) {
		return self::preform(FILTER_SANITIZE_NUMBER_INT,$name,$default,$length);
	}

	static public function boolean($name,$default=false,$length=8) {
		return self::preform(FILTER_VALIDATE_BOOLEAN,$name,$default,$length);
	}

	static public function float($name,$default=0,$length=8) {
		return self::preform(FILTER_SANITIZE_NUMBER_FLOAT,$name,$default,$length);
	}

	static public function string($name,$default=null,$length=null) {
		return self::preform(FILTER_SANITIZE_STRING,$name,$default,$length);
	}

	static public function url($name,$default=null,$length=1024) {
		return self::preform(FILTER_SANITIZE_URL,$name,$default,$length);
	}

	static public function email($name,$default=null,$length=256) {
		return self::preform(FILTER_SANITIZE_EMAIL,$name,$default,$length);
	}

	static public function ip($name,$default=null,$length=16) {
		return self::preform(FILTER_VALIDATE_IP,$name,$default,$length);
	}

	static public function encoded($name,$default=null,$length=null) {
		return self::preform(FILTER_SANITIZE_ENCODED,$name,$default,$length);
	}

	static public function special_chars($name,$default=null,$length=null) {
		return self::preform(FILTER_SANITIZE_SPECIAL_CHARS,$name,$default,$length);
	}

	static public function raw($name,$default=null,$length=null) {
		return self::preform(FILTER_UNSAFE_RAW,$name,$default,$length);
	}

	static private function preform($filter,$name,$default,$length) {
		$length = ($length == null) ? self::$max : $length;
		$input = substr(filter_var($_REQUEST[$name],$filter),0,$length-1);

		if (empty($input)) {
			$input = $default;
		}

		return $input;
	}

} /* end class */