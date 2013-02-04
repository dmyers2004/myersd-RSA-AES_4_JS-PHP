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

class general {

	static public function rsa_decrypt($input,$private) {
		$input = base64_decode($input);
		if (!openssl_private_decrypt($input, $input, openssl_pkey_get_private($private))) {
			die('failed to decrypt');
		}
		return $input;
	}

	static public function payload2post(&$ary,$payload,$key) {
		$ary = (array)json_decode(AesCtr::decrypt($payload, $key, 256));
		return $ary;
	}

	static public function Timeout($timestamp,$seconds = 300) {
		$utc_time = time();
		$difference = abs($utc_time - (int)$timestamp);
		return ($difference > $seconds) ? FALSE : TRUE;
	}

	/* basic create url */
	static public function createurl($url='') {
		return Application::$base_url.'/'.trim($url,'/');
	}

	/* basic redirect */
	static public function redirect($url='') {
		header('Location: '.general::createurl($url));
		header('Connection: close');
		die();
	}
	
	static public function request($name,$default=NULL) {
		return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
	}

	static public function crequest($name,$default=NULL) {
		$input = isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
		return general::clean($input);
	}
	
	static public function ary2data($ary) {
		foreach ((array)$ary as $key => $value)
			mvc()->data($key,$value);
	}
	
	static public function vars() {
		die('<pre>'.print_r($GLOBALS['data'],true).'</pre>');
	}
	
	static public function dump($obj=NULL) {
		return '<pre>'.print_r($obj,true).'</pre>';
	}
	
	static public function log($msg='') {
		@file_put_contents(__DIR__.'/log/'.date('Y-m-d').'.log',date('Y-m-d H:i:s').' '.getenv('REMOTE_ADDR').' '.$msg.chr(10),FILE_APPEND);
	}
	
	static public function html($str='') {
		return htmlspecialchars($str,ENT_QUOTES,'utf-8');
	}
	
	static public function slug($str='') {
		return preg_replace("/[\/_|+ -]+/", '-',  strtolower(trim(preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str), '-')));
	}
	
	/* basic clean */
	static public function clean($dirtyinput) {
		// tab, linefeed, return, ascii space (32) - ascii ~ (126) allowed only!
		return preg_replace("![^\t|\n|\r|\x20-\x7E]!", '', $dirtyinput);
	}

	static public function securitycheck() {
		if ($_SESSION['isvalid'] !== true) {
			session_destroy();
			general::redirect();
		}
	}
	
	static public function hex2str($hex) {
		for ($i=0;$i<strlen($hex);$i=$i+2)
		$str .= chr(hexdec(substr($hex,$i,2)));
		return $str;
	}
	
	static public function str2hex($str) {
		for ($i=0;$i<strlen($str);$i++)
		$hex .= str_pad(dechex(ord($str[$i])),2,0,STR_PAD_LEFT);
		return $hex;
	}
	
	static public function myencrypt($text,$key) {
		for ($i=0;$i<=strlen($text)-1;$i++) {
			$rtn .= chr(ord($text{$i}) ^ ord($key{$keyindex}));
			if ($keyindex++ == strlen($key)-1) $keyindex = 0;
		}
		return $rtn;
	}
	
	static public function encode($input,$key='something') {
	  return $self::str2hex($self::myencrypt($input,$key));
	}
	
	static public function decode($input,$key='something') {
	  return $self::myencrypt($self::hex2str($input),$key);
	}
	
} /* end general */