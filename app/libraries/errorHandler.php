<?php
/**
* DMyers Super Simple MVC
*
* @package    error handler for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class ErrorHandler {

	static public function init(){
		set_exception_handler(array('errorHandler','exceptionHandler'));
	}

	static public function exceptionHandler($exception) {
		if (!headers_sent()) {
			/*
			if headers not sent then send a 404 error
			if they are then just dump a regular one
			*/
			header('HTTP/1.0 404 Not Found');
		}

		die('<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Syntax Error</title></head><body><code>
Version: '.phpversion().'<br>
Memory: '.floor(memory_get_peak_usage()/1024).'K of '.ini_get('memory_limit').' used<br>
Code: '.$exception->getCode().'<br>
Syntax Error: '.$exception->getMessage().'<br>
File: '.$exception->getFile().'<br>
Line: '.$exception->getLine().'<br>
</code></body></html>');
	}

} /* end error handler */

/* wrapper old school error handler into new error handler */
function oldSchoolErrorHandler($errno, $errstr, $errfile, $errline) {
	throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}

set_error_handler('oldSchoolErrorHandler',error_reporting());
